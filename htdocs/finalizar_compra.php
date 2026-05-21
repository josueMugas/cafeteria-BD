<?php
include("conexion.php");
session_start();
if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión para comprar. <a href='login.php'>Ir al login</a>");
}

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die("El carrito está vacío. <a href='index.php'>Volver</a>");
}
$email = mysqli_real_escape_string($conexion, $_SESSION['usuario']);
$sqlUsuario = "SELECT id_usuario FROM usuarios WHERE mail = '$email'";
$resUsuario = mysqli_query($conexion, $sqlUsuario);
$usuario = mysqli_fetch_assoc($resUsuario);

if (!$usuario) {
    die("No se encontró el usuario. <a href='index.php'>Volver</a>");
}

$id_usuario = $usuario['id_usuario'];
$sqlCliente = "SELECT fondos FROM clientes WHERE id_usuario = $id_usuario";
$resCliente = mysqli_query($conexion, $sqlCliente);
$cliente = mysqli_fetch_assoc($resCliente);
$_SESSION['id_usuario'] = $id_usuario;
if (!$cliente) {
    die("No se encontró el cliente. <a href='index.php'>Volver</a>");
}

$saldo_actual = $cliente['fondos'] ?? 0;
$errores = [];
$total_compra = 0;
$productos_validos = [];

foreach ($_SESSION['carrito'] as $id => $cantidad_pedida) {
$stmtProd = mysqli_prepare($conexion, "CALL ObtenerInfoProducto(?)");
mysqli_stmt_bind_param($stmtProd, "i", $id);
mysqli_stmt_execute($stmtProd);
$resProd = mysqli_stmt_get_result($stmtProd);

if ($prod = mysqli_fetch_assoc($resProd)) {
    $total_compra += $prod['precio'] * $cantidad_comprar;
    $productos_validos[] = [
        'id' => $id,
        'nombre' => $prod['nombre'],
        'precio' => $prod['precio'],
        'cantidad' => $cantidad_comprar
    ];
}
mysqli_stmt_close($stmtProd);
    if (!$producto) {
        $errores[] = "Producto ID $id no encontrado";
        continue;
    }

    if ($producto['cantidad'] < $cantidad_pedida) {
        $errores[] = "No hay suficiente stock de: " . $producto['nombre'];
        continue;
    }

    $total_producto = $producto['precio'] * $cantidad_pedida;
    $total_compra += $total_producto;
    $productos_validos[] = [
        'id' => $id,
        'nombre' => $producto['nombre'],
        'cantidad' => $cantidad_pedida,
        'precio' => $producto['precio'],
        'total' => $total_producto
    ];
}
if (!empty($errores)) {
    echo "<h3>Errores en la compra:</h3><ul>";
    foreach($errores as $e) echo "<li>$e</li>";
    echo "</ul><a href='index.php'>Volver</a>";
    exit();
}
if ($saldo_actual < $total_compra) {
    echo "<head>
    <title>Fondos Insuficientes</title>
    <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='sa.css'>
    </head>
    <body>
    <div class='container mt-5 text-center'>
    <h3>Fondos insuficientes</h3>
    <p>Saldo disponible: $" . number_format($saldo_actual, 2) . "</p> 
    <p>Total a pagar: $" . number_format($total_compra, 2) . "</p>
    <p>Faltante: $" . number_format($total_compra - $saldo_actual, 2) . "</p> 
    <a href='index.php'>Volver al menú</a>
    <script>setTimeout(function() { window.location.href='index.php'; }, 3000);</script>
    </div>
    </body>";
    exit();
}

mysqli_begin_transaction($conexion);

try {
    $stmt = mysqli_prepare($conexion, "CALL Registrar_Compra(?, ?, ?)");
    foreach ($productos_validos as $prod) {
        mysqli_stmt_bind_param($stmt, "iii", $id_usuario, $prod['id'], $prod['cantidad']);
        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception(mysqli_stmt_error($stmt));
        }
    }
    mysqli_stmt_close($stmt);

    unset($_SESSION['carrito']);
    ?>
    <head>
        <title>Compra Exitosa</title>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
        <link rel='stylesheet' href='sa.css'>
    </head>
    <body>
        <div class='container mt-5 text-center'>
            <h3 class='text-success'>¡Compra exitosa!</h3>
            <p>Tus productos han sido procesados correctamente.</p>
            <a class='btn btn-primary mt-3' href='index.php'>Volver al Inicio</a>
        </div>
    </body>
    <?php

} catch (Exception $e) {
    die("<div class='container mt-5 alert alert-danger text-center'>
            <h4>Error al procesar la compra</h4>
            <p>" . $e->getMessage() . "</p>
            <a class='btn btn-danger mt-2' href='index.php'>Volver al menú</a>
        </div>");
}
?>
