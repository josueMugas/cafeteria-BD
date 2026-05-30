<?php include("conexion.php"); 
session_start();
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<div class='alert alert-danger text-center fixed-top'>$error</div>";
}
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || strcasecmp($_SESSION['rol'], 'Admin') !== 0) {
    header("Location: index.php");
    exit();
}
$cat_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';

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
        <a class="navbar-brand" href="index.php"style="font-family: 'Times New Roman', 'Times, serif';">☕ Mi Cafetería</a>
        <div class="d-flex">
            <?php if(isset($_SESSION['usuario'])): ?>
                <div class="d-flex">
                    <a href="editar_perfil.php" style="font-family: 'Times New Roman', 'Times, serif';"class="btn btn-outline-light me-2 d-flex align-items-center" title="Editar Perfil">
                        🙍‍♂️ <?php echo htmlspecialchars($_SESSION['cuenta']); ?>
                    </a>
                <?php 
                $pagina_actual = basename($_SERVER['PHP_SELF']);
                if($pagina_actual == 'index.php'): ?>
                    <a href="Admin.php" class="btn btn-outline-light me-2">Ir a Gestión de Productos</a>
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
<div style="margin-top: 80px;"></div>
    <div class="container">
        <br>
    <h1 style= "font-family: 'Times New Roman', Times, serif;'">Gestión de Productos</h1>
    
    <div class="d-flex justify-content-between mb-3">
        <a href="crear.php" class="btn btn-success">+ Agregar</a>
        
        <div class="btn-group" role="group">
        <a href="Admin.php" class="btn btn-sm <?php echo $categoria_seleccionada == '' ? 'btn-dark' : 'btn-outline-dark'; ?>">Todos</a>
        <a href="Admin.php?categoria=Café" class="btn btn-sm <?php echo $categoria_seleccionada == 'Café' ? 'btn-dark' : 'btn-outline-dark'; ?>">Café</a>
        <a href="Admin.php?categoria=Bebidas" class="btn btn-sm <?php echo $categoria_seleccionada == 'Bebidas' ? 'btn-dark' : 'btn-outline-dark'; ?>">Bebidas</a>
        <a href="Admin.php?categoria=Pastelería" class="btn btn-sm <?php echo $categoria_seleccionada == 'Pastelería' ? 'btn-dark' : 'btn-outline-dark'; ?>">Pastelería</a>
        <a href="Admin.php?categoria=Salado" class="btn btn-sm <?php echo $categoria_seleccionada == 'Salado' ? 'btn-dark' : 'btn-outline-dark'; ?>">Salado</a>
    </div>
    </div>

    <table class="table table-hover bg-white rounded shadow-sm">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($p = mysqli_fetch_assoc($res)) { ?>
                <tr>
                    <td><?php echo $p['nombre']; ?></td>
                    <td><?php echo $p['cantidad']?></td>
                    <td><span class="badge bg-info text-dark"><?php echo $p['categoria']; ?></span></td>
                    <td>$<?php echo $p['precio']; ?></td>
                    <td>
                        <a  class="btn btn-warning btn-sm"href="editar.php?id=<?php echo $p['id_producto']; ?>">Editar</a>
                        <a href="borrar.php?id=<?php echo $p['id_producto']; ?>" class="btn btn-danger btn-sm">Borrar</a>
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