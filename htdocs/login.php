<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $pass  = $_POST['pass'];

    $stmt = mysqli_prepare($conexion, "SELECT id_usuario, contraseña, Rol, nombre, domicilio FROM usuarios WHERE mail = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $id_usuario, $hash_db, $rol, $nombre, $domicilio);

        if (mysqli_stmt_fetch($stmt)) {
            if (password_verify($pass, $hash_db)) {
                $_SESSION['usuario'] = $email;
                $_SESSION['rol']     = $rol ?: 'Cliente';
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['nombre'] = $nombre;

                $subject = "Inicio de sesión exitoso";
                $message = "Hola $nombre,\n\n" .
                           "Has iniciado sesión correctamente en tu cuenta.\n\n" .
                           "Tus datos de usuario:\n" .
                           "- ID: $id_usuario\n" .
                           "- Email: $email\n" .
                           "- Rol: $rol\n" .
                           "- Domicilio: $domicilio\n\n" .
                           "Si no fuiste tú, por favor contacta con el soporte.";
                $headers = "From: no-reply@localhost\r\n" .
                           "Content-Type: text/plain; charset=UTF-8\r\n";
                mail($email, $subject, $message, $headers);

                if (strcasecmp($_SESSION['rol'], 'Admin') === 0) {
                    header("Location: Admin.php");
                } else {
                    header("Location: index.php");
                }
                mysqli_stmt_close($stmt);
                exit();
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "El correo electrónico no está registrado";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "Error interno al preparar la consulta";
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
            
            <input id="pass"type="password" name="pass" required><span id="togglePassword" class="password-container" style="cursor: pointer;">👁️</span>
            <button type="submit">Entrar</button>
            <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </form>
        <script src="script.js"></script>
    </div>
    
</body>
</html>