<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Cafetería</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body >
    <div class="container">
        <h1>Gestión de Productos</h1>
        <a href="crear.php" class="btn btn-success mb-3">+ Agregar Nuevo Producto</a>
        
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conexion, "SELECT * FROM productos");
                while($p = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                            <td>{$p['nombre']}</td>
                            <td>\${$p['precio']}</td>
                            <td>{$p['cantidad']}</td>
                            <td>
                                <a href='editar.php?id={$p['id']}' class='btn btn-primary btn-sm'>Editar</a>
                                <a href='borrar.php?id={$p['id']}' class='btn btn-danger btn-sm'>Borrar</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>