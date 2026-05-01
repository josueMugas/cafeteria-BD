<?php 
include("conexion.php"); 

$categoria_seleccionada = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$sql = "SELECT * FROM productos";
if ($categoria_seleccionada != '') {
    $sql .= " WHERE categoria = '$categoria_seleccionada'";
}
$res = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a nuestra Cafetería</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body>
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro); z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">☕ Mi Cafetería</a>
        <div class="d-flex">
            <?php if(isset($_SESSION['usuario'])): ?>
                <?php 
                $pagina_actual = basename($_SERVER['PHP_SELF']);
                if($pagina_actual == 'index.php'): ?>
                    <a href="clientes.php" class="btn btn-outline-light me-2">Ir a Gestión de Productos</a>
                <?php else: ?>
                    <a href="index.php" class="btn btn-outline-light me-2">Ver Menú Principal</a>
                <?php endif; ?>
                
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-secondary">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div style="margin-top: 100px;"></div>

<div class="container" style="max-width: 1200px; background-color: rgba(255,255,255,0.8); padding: 30px; border-radius: 15px;">
    <h1 class="mb-4" style="font-family: 'times new roman', script; font-weight: bold;">Nuestra Carta</h1>
    <?php if(isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])): ?>
    <div class="mb-4">
        <h4>🛒 Tu pedido actual:</h4>
        <ul>
            <?php 
            foreach($_SESSION['carrito'] as $id => $cant) {
                $item = mysqli_query($conexion, "SELECT nombre FROM productos WHERE id = $id");
                $n = mysqli_fetch_assoc($item);
                echo "<li>{$n['nombre']} x $cant</li>";
            }
            ?>
        </ul>
        <a href="finalizar_compra.php" class="btn btn-success">✅ Confirmar Compra</a>
        <a href="carrito.php?accion=vaciar" class="btn btn-link text-danger">Vaciar</a>
    </div>
<?php endif; ?>
    <form method="GET" class="row g-3 mb-5 justify-content-center">
        <div class="col-auto">
            <select name="categoria" class="form-select" style="min-width: 250px;">
                <option value="">-- Ver Todas las Categorías --</option>
                <option value="Cafetería" <?php if($categoria_seleccionada == 'Cafetería') echo 'selected'; ?>>Cafetería</option>
                <option value="Pastelería" <?php if($categoria_seleccionada == 'Pastelería') echo 'selected'; ?>>Pastelería</option>
                <option value="Salado" <?php if($categoria_seleccionada == 'Salado') echo 'selected'; ?>>Salado</option>
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <?php if($categoria_seleccionada != ''): ?>
                <a href="index.php" class="btn btn-secondary mt-2">Limpiar Filtro</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php
        while($p = mysqli_fetch_assoc($res)) {
        ?>
        <div class="col">
            <div class="card h-100">
                <img src="imagenes/<?php echo $p['IMG']; ?>" class="card-img-top" alt="<?php echo $p['nombre']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $p['nombre']; ?></h5>
                    <!-- Mostramos la categoría en la tarjeta -->
                    <span class="badge bg-info text-dark mb-2"><?php echo $p['categoria']; ?></span>
                    <p class="card-text">Precio: $<?php echo $p['precio']; ?></p>
                    <p class="text-muted small">Disponibles: <?php echo $p['cantidad']; ?></p>
                </div>
                <div class="card-footer bg-transparent border-0 pb-3">
                    <?php if(isset($_SESSION['usuario'])): ?>
                    <a href="carrito.php?accion=agregar&id=<?php echo $p['id']; ?>" class="btn btn-primary w-100">
                        🛒 Agregar al Carrito
                    </a>
                    <?php else: ?>
                        <p class="text-muted">Debes <a href="login.php">iniciar sesión</a> para agregar productos al carrito.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php if(mysqli_num_rows($res) == 0): ?>
        <div class="alert alert-warning text-center mt-4">
            No se encontraron productos en la categoría "<?php echo $categoria_seleccionada; ?>".
        </div>
    <?php endif; ?>
</div>

</body>
</html>