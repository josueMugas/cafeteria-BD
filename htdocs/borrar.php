<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
include("conexion.php");
$id = $_GET['id'];
mysqli_query($conexion, "DELETE FROM productos WHERE id = $id");
header("Location: clientes.php");
?>