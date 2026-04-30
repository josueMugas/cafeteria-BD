<?php include("conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a nuestra Cafetería</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--cafe-oscuro);">
        <div class="container-fluid">
            <a class="navbar-brand" href="clientes.php">☕ Mi Cafetería</a>
            <div class="d-flex">
                <a href="login.php" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-secondary">Registrarse</a>
            </div>
        </div>
    </nav>

    <div class="container" style="max-width: 1200px;">
        <h1 class="mb-4">Nuestra Carta</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $res = mysqli_query($conexion, "SELECT * FROM productos");
            while($p = mysqli_fetch_assoc($res)) {
            ?>
            <div class="col">
                <div class="card h-100">
                    <img src="imagenes/<?php echo $p['IMG']; ?>" class="card-img-top" alt="<?php echo $p['nombre']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $p['nombre']; ?></h5>
                        <p class="card-text">Precio: $<?php echo $p['precio']; ?></p>
                        <p class="text-muted small">Disponibles: <?php echo $p['cantidad']; ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-0 pb-3">
                        <a href="login.php" class="btn btn-primary w-100">Pedir Ahora</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>