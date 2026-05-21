
<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = $_POST['pass'];
    $domicilio = mysqli_real_escape_string($conexion, $_POST['domicilio']);

    $stmtCheck = mysqli_prepare($conexion, "SELECT id_usuario FROM usuarios WHERE mail = ? LIMIT 1");
    mysqli_stmt_bind_param($stmtCheck, "s", $email);
    mysqli_stmt_execute($stmtCheck);
    mysqli_stmt_store_result($stmtCheck);

    if (mysqli_stmt_num_rows($stmtCheck) > 0) {
        mysqli_stmt_close($stmtCheck);
        header("Location: registro.php?error=" . urlencode("El correo ya está registrado"));
        exit();
    }

    mysqli_stmt_close($stmtCheck);

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmtInsert = mysqli_prepare($conexion, "CALL InsertarCliente(?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmtInsert, "ssss", $nombre, $email, $hash, $domicilio);

    if (mysqli_stmt_execute($stmtInsert)) {
        $nuevoId = mysqli_insert_id($conexion);
        $_SESSION['usuario'] = $email;
        $_SESSION['rol'] = 'Cliente';
        $_SESSION['id_usuario'] = $nuevoId;

        $subject = "Registro exitoso en Cafetería";
        $message = "Hola $nombre,\n\n" .
                   "Gracias por registrarte en nuestra Cafetería. Aquí están tus datos de usuario:\n\n" .
                   "- ID: $nuevoId\n" .
                   "- Nombre: $nombre\n" .
                   "- Email: $email\n" .
                   "- Domicilio: $domicilio\n\n" .
                   "Ya puedes iniciar sesión y comenzar a ordenar.";
        $headers = "From: no-reply@localhost\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n";
        mail($email, $subject, $message, $headers);

        mysqli_stmt_close($stmtInsert);
        header('Location: index.php');
        exit();
    } else {
        $error = "Error al registrar el cliente: " . mysqli_error($conexion);
        mysqli_stmt_close($stmtInsert);
    }
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<div class='alert alert-danger text-center fixed-top'>$error</div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería - Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body>
    <div class="container" style="max-width: 500px; margin-top: 50px;" >
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">☕ Nuevo Cliente</h2>
                <form action="registro.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Pedro Pérez" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="juan@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        
                        <label class="form-label">Contraseña</label>
                        <span id="togglePassword" class="password-container1" style="cursor: pointer;">👁️</span>
                        <input id = "pass" type="password" name="pass" class="form-control" placeholder="password1234" required>
                        
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Domicilio</label>
                        <input type="text" name="domicilio" class="form-control" placeholder="Dirección de entrega" required>
                    </div>
                    <button type="submit">Registrar y Ver Menú</button>
                    <p class="mt-3 text-center">¿Ya tienes cuenta?</p>
                    <a style ="margin-left: 30%;margin-buttom: 30% "href="login.php">Login aquí</a>
                </form><script src="script1.js"></script>
                <br>
            </div>
            <br>
        </div>
    </div>
    <br>
    
</body>
</html>