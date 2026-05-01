<?php include("conexion.php"); 
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
$cat_filtro = isset($_GET['cat_filtro']) ? $_GET['cat_filtro'] : '';

$sql = "SELECT * FROM productos";
if ($cat_filtro != '') {
    $sql .= " WHERE categoria = '$cat_filtro'";
}
$res = mysqli_query($conexion, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Cafetería</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>

<body >
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro); z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">☕ Mi Cafetería</a>
        
        <div class="d-flex">
            <?php if(isset($_SESSION['usuario'])): ?>
                <!-- Si hay sesión iniciada -->
                <?php 
                // Detectar en qué página estamos para mostrar el botón opuesto
                $pagina_actual = basename($_SERVER['PHP_SELF']);
                if($pagina_actual == 'index.php'): ?>
                    <a href="clientes.php" class="btn btn-outline-light me-2">Ir a Gestión de Productos</a>
                <?php else: ?>
                    <a href="index.php" class="btn btn-outline-light me-2">Ver Menú Principal</a>
                <?php endif; ?>
                
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php else: ?>
                <!-- Si NO hay sesión iniciada -->
                <a href="login.php" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                <a href="registro.php" class="btn btn-secondary">Registrarse</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- Importante: Agregar un espaciador para que el contenido no quede oculto bajo la navbar fija -->
<div style="margin-top: 80px;"></div>
    <div class="container">
    <h1>Gestión de Productos</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="crear.php" class="btn btn-success">+ Agregar</a>
        
        <!-- Filtro Rápido -->
        <form method="GET" class="d-flex gap-2">
            <select name="cat_filtro" class="form-select shadow-sm">
                <option value="">todos.</option>
                <option value="cafeteria">Cafetería</option>
                <option value="Pastelería">Pastelería</option>
                <option value="Salado">Salado</option>
            </select>
            <button type="submit" class="btn btn-dark">Ver</button>
        </form>
    </div>

    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td><?php echo $p['nombre']; ?></td>
                    <td><span class="badge bg-info text-dark"><?php echo $p['categoria']; ?></span></td>
                    <td>$<?php echo $p['precio']; ?></td>
                    <td>
                        <a href="editar.php?id=<?php echo $p['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="borrar.php?id=<?php echo $p['id']; ?>" class="btn btn-danger btn-sm">Borrar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <br>
</div>
<br>
</body>
</html>