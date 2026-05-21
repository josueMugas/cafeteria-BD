<?php 
session_start();
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<div class='alert alert-danger text-center fixed-top'>$error</div>";
}
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || strcasecmp($_SESSION['rol'], 'Admin') !== 0) {
    header("Location: index.php");
    exit();
}

include "conexion.php";

if($_POST){
    $nom = $_POST['nombre'];
    $pre = $_POST['precio'];
    $cant = $_POST['cantidad'];
    $cat = $_POST['categoria'];

    $foto = $_FILES['foto'];
    $imgNombre = basename($foto['name']);
    $imgTmp = $foto['tmp_name'];
    $imgError = $foto['error'];

    if ($imgError !== UPLOAD_ERR_OK || !is_uploaded_file($imgTmp)) {
        $error = "Error al subir la imagen.";
        header("Location: crear.php?error=" . urlencode($error));
        exit();
    }

    $allowedExtensions = ['png', 'jpg', 'jpeg'];
    $imgExt = strtolower(pathinfo($imgNombre, PATHINFO_EXTENSION));

    if (!in_array($imgExt, $allowedExtensions, true)) {
        $error = "Solo se permiten imágenes PNG o JPG.";
        header("Location: crear.php?error=" . urlencode($error));
        exit(); 
    }

    $imageInfo = getimagesize($imgTmp);
    if ($imageInfo === false) {
        $error = "El archivo no es una imagen válida.";
        header("Location: crear.php?error=" . urlencode($error));
    }

    $allowedMimeTypes = ['image/png', 'image/jpeg'];
    if (!in_array($imageInfo['mime'], $allowedMimeTypes, true)) {
        $error = "Solo se permiten imágenes PNG o JPG.";
        header("Location: crear.php?error=" . urlencode($error));
    }

    $targetDir = "imagenes/";
    if (!move_uploaded_file($imgTmp, $targetDir . $imgNombre)) {
        $error = "No se pudo guardar la imagen."    ;
        header("Location: crear.php?error=" . urlencode($error));
    }

    $sql = "INSERT INTO productos (nombre, precio, cantidad, IMG,categoria) VALUES ('$nom', '$pre', '$cant', '$imgNombre','$cat')";
    mysqli_query($conexion, $sql);
    header("Location: clientes.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
    <title>Agregar Producto</title>
</head>
<body class="p-5" style="background-color:  #f5f5dc;"  >
    <form method="POST" enctype="multipart/form-data" class="container" style="max-width: 500px; background-color: #f5f5dc; padding: 30px; border-radius: 15px;">
        <h3>Nuevo Producto</h3>
        <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
        <input type="text" name="categoria" placeholder="Categoria" class="form-control mb-2" required>
        <input type="number" class="form-control mb-2"onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189"placeholder=" $ Precio" required>
        <input type="number" name="cantidad" pattern="[0-9]*" placeholder="Stock Inicial" class="form-control mb-2" required>
        <input type="file" name="foto" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="clientes.php">Cancelar</a>
    </form>
</body>
</html>