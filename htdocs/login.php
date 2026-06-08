<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass  = $_POST['pass'];
    $sql = "SELECT * FROM usuarios WHERE mail = '$email'";
    $resultado = mysqli_query($conexion, $sql);
    if ($usuario = mysqli_fetch_assoc($resultado)) {
        if (password_verify($pass, $usuario['contraseña'])) {
            $_SESSION['cuenta'] = $usuario['nombre'];
            $_SESSION['usuario'] = $email;
            $_SESSION['rol']     = $usuario['Rol'] ?? 'Cliente';
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION["saldo"] = $usuario['fondos'];
            if (strcasecmp($_SESSION['rol'], 'Admin') === 0) {
                header("Location: Admin.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Contraseña incorrecta";
        }
    } else {
        $error = "El correo electrónico no está registrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro); z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">☕ Mi Cafetería</a>
        
        <div class="d-flex">
            <?php if(isset($_SESSION['usuario'])): ?>
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
    <div class="container">
        <form method="POST" class="p-4">
            <h2 class="mb-4" style="font-family: 'Times New Roman', 'Times, serif';">Ingreso de Clientes</h2>
            <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <label>Correo Electrónico</label>
            <input type="email" name="email" required>
            
            <label>Contraseña</label>
            
            <input id="pass"type="password" name="pass" required><span id="togglePassword" class="password-container" style="cursor: pointer;">👁️</span>
            <button type="submit">Entrar</button>
            <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </form>
        <script src="script.js"></script>
    </div>
    
</body>
</html>