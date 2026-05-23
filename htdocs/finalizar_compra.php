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

foreach ($_SESSION['carrito'] as $id => $cantidad_comprar) {
    $id = intval($id);
    $cantidad_comprar = intval($cantidad_comprar);
    $sqlProd = "SELECT * FROM productos WHERE id_producto = $id";
    $resProd = mysqli_query($conexion, $sqlProd);
    $prod_data = mysqli_fetch_assoc($resProd);

    if ($prod_data) {
        if ($prod_data['cantidad'] >= $cantidad_comprar) {
            $subtotal = $prod_data['precio'] * $cantidad_comprar;
            $total_compra += $subtotal;
            $productos_validos[] = [
                'id' => $id,
                'cantidad' => $cantidad_comprar,
                'precio' => $prod_data['precio']
            ];
        } else {
            $errores[] = "Stock insuficiente para: " . htmlspecialchars($prod_data['nombre']) . " (Disponibles: " . $prod_data['cantidad'] . ")";
        }
    } else {
        $errores[] = "Producto ID $id no encontrado en la base de datos.";
    }
}

if ($total_compra > $saldo_actual) {
    $errores[] = "Saldo insuficiente. El total es $" . number_format($total_compra, 2) . " y tu saldo actual es $" . number_format($saldo_actual, 2);
}

if (!empty($errores)) {
    echo "<!DOCTYPE html>
    <html lang='es'>
    <head>
        <title>Errores en la compra</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'>
        <link rel='stylesheet' href='sa.css'>
    </head>
    <body>
    <div class='container mt-5 p-4 bg-light text-dark rounded shadow' style='max-width: 600px;'>
        <h3 class='text-danger mb-3'>Errores en la compra:</h3>
        <ul class='list-group mb-4'>";
        foreach ($errores as $error) {
            echo "<li class='list-group-item list-group-item-danger'>$error</li>";
        }
    echo "</ul>
        <a class='btn btn-primary w-100' href='carrito.php?accion=vaciar'>Volver al menú</a>
    </div>
    </body>
    </html>";
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
    mysqli_commit($conexion);
    unset($_SESSION['carrito']);
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <title>Compra Exitosa</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css'>
        <link rel='stylesheet' href='sa.css'>
    </head>
    <body>
        <div class='container mt-5 text-center p-5 bg-light text-dark rounded shadow' style='max-width: 600px;'>
            <h3 class='text-success fw-bold'>¡Compra exitosa! 🎉</h3>
            <p class='fs-5 mt-3'>Tus productos han sido procesados y descontados correctamente de tu saldo.</p>
            <a class='btn btn-success mt-4 px-4' href='index.php'>Volver al Inicio</a>
            <a class='btn btn-outline-secondary mt-4 ms-2 px-4' href='reseña.php'>Dejar Reseña</a>
        </div>
    </body>
    </html>
    <?php
} catch (Exception $e) {
    mysqli_rollback($conexion);
    die("Error crítico al procesar la compra en la base de datos: " . $e->getMessage() . " <a href='index.php'>Volver</a>");
}
?>