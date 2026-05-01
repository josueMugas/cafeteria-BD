<?php
include("conexion.php");
session_start();

// 1. Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$accion = $_GET['accion'] ?? '';

// 2. Lógica para AGREGAR
if ($accion == 'agregar') {
    $id = $_GET['id'];
    // Si el producto ya está, sumamos 1, si no, lo iniciamos en 1
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]++;
    } else {
        $_SESSION['carrito'][$id] = 1;
    }
    header("Location: index.php");
}

// 3. Lógica para VACIAR
if ($accion == 'vaciar') {
    unset($_SESSION['carrito']);
    header("Location: index.php");
}
?>