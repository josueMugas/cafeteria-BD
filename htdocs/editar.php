<?php 
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || strcasecmp($_SESSION['rol'], 'Admin') !== 0) {
    header("Location: index.php");
    exit();
}

include "conexion.php";
if(isset($error)) echo "<div class='alert alert-danger'>$error</div>";
if ($_POST) {
    $id = $_GET['id'];
    $nom = $_POST['nombre'];
    $pre = $_POST['precio'];
    if ($pre < 0) {
        $pre = 0;
    }
    $cant = $_POST['cantidad'];
    if ($cant < 0) {
        $cant = 0;
    }
    $stmt = mysqli_prepare($conexion, "CALL ActualizarProducto(?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isdi", $id, $nom, $pre, $cant);
    
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        header("Location: Admin.php");
        exit();
    } else {
        echo "Error al actualizar el producto: " . mysqli_error($conexion);
        mysqli_stmt_close($stmt);
        exit();
    }
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt_select = mysqli_prepare($conexion, "SELECT nombre, precio, cantidad FROM productos WHERE id_producto = ?");
    mysqli_stmt_bind_param($stmt_select, "i", $id);
    mysqli_stmt_execute($stmt_select);
    $resultado = mysqli_stmt_get_result($stmt_select);
    $producto = mysqli_fetch_assoc($resultado);
    mysqli_stmt_close($stmt_select);

    if (!$producto) {
        header("Location: Admin.php?error=" . urlencode("Producto no encontrado."));
        exit();
    }
} else {
    header("Location: Admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
    <title>Editar Producto</title>
</head>
<body class="p-5" style="background-color: #f5f5dc;">
    <form method="POST" enctype="multipart/form-data" class="container" style="max-width: 500px; background-color: #f5f5dc; padding: 30px; border-radius: 15px;">
        <h3>Editar Producto</h3>
        
        <label class="form-label">Nombre del Producto</label>
        <input type="text" name="nombre" class="form-control mb-2" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        
        <label class="form-label">Precio ($)</label>
        <input name="precio" type="number" step="0.01" class="form-control mb-2" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189 || event.keyCode === 190 || event.keyCode === 110" value="<?php echo $producto['precio']; ?>" required>
        
        <label class="form-label">Stock / Cantidad disponible</label>
        <input name="cantidad" type="number" class="form-control mb-3" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189" value="<?php echo $producto['cantidad']; ?>" required>
        
        <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
        <a href="Admin.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
    </form>
</body>
</html>