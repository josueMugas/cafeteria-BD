<?php 
include("conexion.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<div class='alert alert-danger text-center fixed-top' style='z-index: 2000;'>$error</div>";
}
$categoria_seleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$sql = "SELECT * FROM productos";
if ($categoria_seleccionada != '') {
    $sql .= " WHERE categoria = '" . mysqli_real_escape_string($conexion, $categoria_seleccionada) . "'";
}
$res = mysqli_query($conexion, $sql);

$id_usuario = $_SESSION['id_usuario'];
$sqlActual = "SELECT fondos FROM clientes WHERE id_usuario = $id_usuario";
$resActual = mysqli_query($conexion, $sqlActual);
if ($u = mysqli_fetch_assoc($resActual)) {
    $saldo_actual = $u['fondos'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a nuestra Cafetería</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
    <style>
        body {
            padding-top:5%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro); z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">☕ Mi Cafetería</a>
        <div class="d-flex">
            <?php if(isset($_SESSION['usuario'])): ?>
                <span class="navbar-text text-white me-3 align-self-center">Saldo: <strong>$<?php echo number_format($saldo_actual, 2); ?></strong></span>
                <?php if(isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Admin') === 0): ?>
                    <a href="Admin.php" class="btn btn-outline-light me-2">Panel Admin</a>
                <?php elseif(isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Cliente') === 0): ?>
                    <a href="ver_carrito.php" class="btn btn-outline-light me-2">🛒 Carrito (<?php echo isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0; ?>)</a>
                    <a href="AgregarSaldo.php" class="btn btn-outline-light me-2">Agregar Saldo</a>
                <?php endif; ?>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-secondary">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container shadow-none mb-5" style="max-width: 1200px; margin-top: 20px;">
    <h1 class="text-white mb-4 text-center" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.8);">Nuestra Carta</h1>
    <div class="btn-group" role="group">
        <a href="index.php" class="btn btn-sm <?php echo $categoria_seleccionada == '' ? 'btn-dark' : 'btn-outline-dark'; ?>">Todos</a>
        <a href="index.php?categoria=café" class="btn btn-sm <?php echo $categoria_seleccionada == 'café' ? 'btn-dark' : 'btn-outline-dark'; ?>">Café</a>
        <a href="index.php?categoria=Pastelería" class="btn btn-sm <?php echo $categoria_seleccionada == 'Pastelería' ? 'btn-dark' : 'btn-outline-dark'; ?>">Pastelería</a>
        <a href="index.php?categoria=Salado" class="btn btn-sm <?php echo $categoria_seleccionada == 'Salado' ? 'btn-dark' : 'btn-outline-dark'; ?>">Salado</a>
    </div>
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-1">
        <?php while($p = mysqli_fetch_assoc($res)) { ?>
        <div class="col">
            <div class="card h-100 shadow-sm">
                <img src="Imagenes/<?php echo htmlspecialchars($p['IMG']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['nombre']); ?>" onerror="this.src='Imagenes/default.jpg';">
                <div class="card-body">
                    <h5 class="card-title text-dark fw-bold"><?php echo htmlspecialchars($p['nombre']); ?></h5>
                    <span class="badge bg-secondary mb-2"><?php echo htmlspecialchars($p['categoria']); ?></span>
                    <p class="card-text text-dark fs-5">Precio: <strong>$<?php echo number_format($p['precio'], 2); ?></strong></p>
                    <p class="text-muted small">Disponibles: <?php echo $p['cantidad']; ?></p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <?php if(isset($_SESSION['usuario']) && isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Cliente') === 0): ?>
                        <a href="carrito.php?accion=agregar&id=<?php echo $p['id_producto']; ?>" class="btn w-100 text-white" style="background-color: var(--cafe-medio);">
                            🛒 Agregar al Carrito
                        </a>
                    <?php elseif(isset($_SESSION['usuario']) && isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Admin') === 0): ?>
                        <p class="text-muted text-center small">Modo Administrador</p>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-sm btn-outline-danger w-100">Inicia sesión para comprar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>

    <?php if(mysqli_num_rows($res) == 0): ?>
        <div class="alert alert-warning text-center mt-4 bg-white text-dark border-0 shadow">
            No se encontraron productos en la categoría "<?php echo htmlspecialchars($categoria_seleccionada); ?>".
        </div>
    <?php endif; ?>
    <br>
</div>
</body>
</html>