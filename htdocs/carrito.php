<?php
include("conexion.php");
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

$accion = $_GET['accion'] ?? '';

if ($accion == 'agregar') {
    $id = $_GET['id'];
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]++;
    } else {
        $_SESSION['carrito'][$id] = 1;
    }
    header("Location: index.php");
}

if ($accion == 'agregar1') {
    $id = $_GET['id'];
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]++;
    } else {
        $_SESSION['carrito'][$id] = 1;
    }
    header("Location: ver_carrito.php");
}
if ($accion == 'sacar') {
    $id = $_GET['id'];
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]--;
        if ($_SESSION['carrito'][$id] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    }
    header("Location: index.php");
}

if ($accion == 'sacar1') {
    $id = $_GET['id'];
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]--;
        if ($_SESSION['carrito'][$id] <= 0) {
            unset($_SESSION['carrito'][$id]);
        }
    }
    header("Location: ver_carrito.php");
}
if ($accion == 'vaciar') {
    unset($_SESSION['carrito']);
    header("Location: index.php");
}
?>