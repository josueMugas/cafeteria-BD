<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || strcasecmp($_SESSION['rol'], 'Admin') !== 0) {
    header("Location: index.php");
    exit();
}

include("conexion.php");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $id = $_GET['id'];
    mysqli_query($conexion, "DELETE FROM productos WHERE id_producto = $id");
    header("Location: Admin.php");
    exit();

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() == 1451) {
        $error = "No se puede eliminar el producto porque tiene registros relacionados.";
        header("Location: Admin.php?error=" . urlencode($error));
        exit();
    } else {
        $error = "Error inesperado: " . $e->getMessage();
        header("Location: Admin.php?error=" . urlencode($error));
        exit();
    }
}
?>