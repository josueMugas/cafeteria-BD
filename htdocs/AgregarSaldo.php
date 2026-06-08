<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

include("conexion.php");

if (!isset($_SESSION['usuario']) || (isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Admin') === 0)) {
    header("Location: index.php");
    exit();
}
$saldo_actual = $_SESSION["saldo"] ;
$mensaje_exito = "";


$id_usuario = $_SESSION['id_usuario'];
$sqlActual = "SELECT fondos FROM clientes WHERE id_usuario = $id_usuario";
$resActual = mysqli_query($conexion, $sqlActual);
if ($u = mysqli_fetch_assoc($resActual)) {
    $saldo_actual = $u['fondos'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad = intval($_POST['cantidad']);
    
    if ($cantidad > 0) {
        $sqlCliente = "UPDATE clientes SET fondos = fondos + $cantidad WHERE id_usuario = $id_usuario";
        
        if (mysqli_query($conexion, $sqlCliente)) {
            $resActual = mysqli_query($conexion, $sqlActual);
            if ($u = mysqli_fetch_assoc($resActual)) {
                $saldo_actual = $u['fondos'];
                $_SESSION["saldo"] = $saldo_actual;
            }
            $saldo_actual = $u['fondos'];
                $_SESSION["saldo"] = $saldo_actual;
            $mensaje_exito = "¡Saldo agregado con éxito! Tu saldo actual es: $" . number_format($saldo_actual, 2);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="sa.css">
        <title>Agregar Saldo - Mi Cafetería</title>
    </head>
    <body style="padding-top: 90px;">
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro); z-index: 1030;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php" style="font-family: 'Times New Roman', 'Times, serif';">☕ Mi Cafetería</a>
                <div class="d-flex">
                    <?php if(isset($_SESSION['usuario'])): ?>
                        <span class="navbar-text text-white me-3 align-self-center">Saldo: <strong>$<?php echo number_format($saldo_actual, 2); ?></strong></span>
                        <?php if(isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Admin') === 0): ?>
                            <a href="Admin.php" class="btn btn-outline-light me-2">Panel Admin</a>
                        <?php elseif(isset($_SESSION['rol']) && strcasecmp($_SESSION['rol'], 'Cliente') === 0): ?>
                            <a href="ver_carrito.php" class="btn btn-outline-light me-2">🛒 Carrito (<?php echo isset($_SESSION['carrito']) ? array_sum($_SESSION['carrito']) : 0; ?>)</a>
                            <a href="index.php" class="btn btn-outline-light me-2">Ver Menú</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-light me-2">Iniciar Sesión</a>
                        <a href="registro.php" class="btn btn-secondary">Registrarse</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
        <div class="container bg-transparent shadow-none" style="max-width: 500px; margin-top: 50px;">
            <div class="card p-4 shadow border-0 bg-light text-dark text-center">
                <h2 class="mb-4" style="font-family: 'Times New Roman', 'Times, serif';">Agregar Saldo</h2>
                
                <?php if (!empty($mensaje_exito)): ?>
                    <div class="alert alert-success"><?php echo $mensaje_exito; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Tu saldo disponible es: <strong>$<?php echo number_format($saldo_actual, 2); ?></strong></label>
                        <input type="number" name="cantidad" class="form-control text-center fs-5" min="1" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189" placeholder="¿Cuánto deseas cargar?" required>
                    </div>
                    <button type="submit" class="btn text-white w-100 fs-5" style="background-color: var(--cafe-medio);">💳 Cargar Dinero</button>
                </form>
            </div>
        </div>

    </body>
</html>