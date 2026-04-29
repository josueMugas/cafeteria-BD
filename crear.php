<?php 
include("conexion.php"); 
if($_POST){
    $nom = $_POST['nombre'];
    $pre = $_POST['precio'];
    $cant = $_POST['cantidad'];
    
    // Lógica básica para la imagen
    $imgNombre = $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "imagenes/" . $imgNombre);

    $sql = "INSERT INTO productos (nombre, precio, cantidad, IMG) VALUES ('$nom', '$pre', '$cant', '$imgNombre')";
    mysqli_query($conexion, $sql);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="p-5">
    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow">
        <h3>Nuevo Producto</h3>
        <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2" required>
        <input type="number" name="precio" placeholder="Precio" class="form-control mb-2" required>
        <input type="number" name="cantidad" placeholder="Stock Inicial" class="form-control mb-2" required>
        <input type="file" name="foto" class="form-control mb-3" required>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="clientes.php">Cancelar</a>
    </form>
</body>
</html>