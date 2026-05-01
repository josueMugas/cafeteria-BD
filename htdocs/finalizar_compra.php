<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    die("El carrito está vacío.");
}

$errores = [];
foreach ($_SESSION['carrito'] as $id => $cantidad_pedida) {
    // Consultamos el stock actual
    $res = mysqli_query($conexion, "SELECT nombre, cantidad FROM productos WHERE id = $id");
    $producto = mysqli_fetch_assoc($res);

    if ($producto['cantidad'] < $cantidad_pedida) {
        $errores[] = "No hay suficiente stock de: " . $producto['nombre'];
    } else {
        // Restamos la cantidad en la base de datos
        $nueva_cantidad = $producto['cantidad'] - $cantidad_pedida;
        mysqli_query($conexion, "UPDATE productos SET cantidad = $nueva_cantidad WHERE id = $id");
    }
}

if (empty($errores)) {
    mysqli_commit($conexion); // Guardar cambios permanentemente
    unset($_SESSION['carrito']); // Limpiar carrito
    echo "<script>alert('¡Compra exitosa!'); window.location.href='index.php';</script>";
} else {
    mysqli_rollback($conexion); // Cancelar todo si hubo error
    echo "<h3>Errores en la compra:</h3><ul>";
    foreach($errores as $e) echo "<li>$e</li>";
    echo "</ul><a href='index.php'>Volver</a>";
}
?>