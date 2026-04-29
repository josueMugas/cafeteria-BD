<?php
session_start();
include("conexion.php");

if ($_POST) {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass = mysqli_real_escape_string($conexion, $_POST['pass']);
    
    $sql = "SELECT * FROM clientes WHERE mail = '$email' AND contraseña = '$pass'";
    $resultado = mysqli_query($conexion, $sql);
    
    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['usuario'] = $email;
        header("Location: clientes.php");
    } else {
        $error = "Correo o contraseña incorrectos";
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
    <div class="container">
        <form method="POST" class="p-4">
            <h2 class="mb-4">Ingreso de Clientes</h2>
            <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
            <label>Correo Electrónico</label>
            <input type="email" name="email" required>
            <label>Contraseña</label>
            <input type="password" name="pass" required>
            <button type="submit">Entrar</button>
            <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </form>
    </div>
</body>
</html>