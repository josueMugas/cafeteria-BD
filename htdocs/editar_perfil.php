<?php
session_start();
include("conexion.php");

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$error = '';
$exito = '';
$id_usuario = $_SESSION['id_usuario'];
$email = $_SESSION['usuario'];
$nombre_actual = $_SESSION['cuenta'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $contraseña_actual = $_POST['contraseña_actual'];
    $contraseña_nueva = $_POST['contraseña_nueva'];
    $contraseña_confirmar = $_POST['contraseña_confirmar'];

    // Verificar contraseña actual
    $sql_verificar = "SELECT contraseña FROM usuarios WHERE id_usuario = $id_usuario";
    $res_verificar = mysqli_query($conexion, $sql_verificar);
    $usuario_verificar = mysqli_fetch_assoc($res_verificar);

    if (!password_verify($contraseña_actual, $usuario_verificar['contraseña'])) {
        $error = "La contraseña actual es incorrecta";
    } elseif ($contraseña_nueva !== $contraseña_confirmar) {
        $error = "Las contraseñas nuevas no coinciden";
    } elseif (strlen($contraseña_nueva) < 6 && !empty($contraseña_nueva)) {
        $error = "La contraseña debe tener al menos 6 caracteres";
    } else {
        // Actualizar nombre
        if (!empty($nuevo_nombre)) {
            $sql_nombre = "UPDATE usuarios SET nombre = '$nuevo_nombre' WHERE id_usuario = $id_usuario";
            if (!mysqli_query($conexion, $sql_nombre)) {
                $error = "Error al actualizar el nombre";
            }
        }

        // Actualizar contraseña si se proporciona
        if (!empty($contraseña_nueva)) {
            $contraseña_hash = password_hash($contraseña_nueva, PASSWORD_BCRYPT);
            $sql_pass = "UPDATE usuarios SET contraseña = '$contraseña_hash' WHERE id_usuario = $id_usuario";
            if (!mysqli_query($conexion, $sql_pass)) {
                $error = "Error al actualizar la contraseña";
            }
        }

        if (empty($error)) {
            $_SESSION['cuenta'] = $nuevo_nombre;
            $exito = "Perfil actualizado correctamente";
            $nombre_actual = $nuevo_nombre;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
    <style>
        body {
            padding-top: 5%;
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro); z-index: 1030;">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">☕ Mi Cafetería</a>
        <div class="d-flex">
            <?php if(isset($_SESSION['usuario'])): ?>
                <a href="index.php" class="btn btn-outline-light me-2">Volver</a>
                <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="profile-container mt-4">
    <h1 class="mb-4" style="font-family: 'Times New Roman', 'Times, serif';">Editar Perfil</h1>

    <?php if(!empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if(!empty($exito)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($exito); ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
            <small class="text-muted">El correo no puede ser modificado</small>
        </div>

        <div class="form-group">
            <label for="nombre" class="form-label">Nombre de la Cuenta</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre_actual); ?>" required>
        </div>

        <hr>

        <h5>Cambiar Contraseña</h5>
        <p class="text-muted small">Completa los campos si deseas cambiar tu contraseña. Deja vacío si no deseas cambiarla.</p>

        <div class="form-group">
            <label for="contraseña_actual" class="form-label">Contraseña Actual</label>
            <input type="password" class="form-control" id="contraseña_actual" name="contraseña_actual" required>
        </div>

        <div class="form-group">
            <label for="contraseña_nueva" class="form-label">Nueva Contraseña (opcional)</label>
            <input type="password" class="form-control" id="contraseña_nueva" name="contraseña_nueva">
            <small class="text-muted">Mínimo 6 caracteres</small>
        </div>

        <div class="form-group">
            <label for="contraseña_confirmar" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" class="form-control" id="contraseña_confirmar" name="contraseña_confirmar">
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script src="script.js"></script>
</body>
</html>
