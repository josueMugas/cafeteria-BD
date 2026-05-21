<?php
session_start();
include("conexion.php");
$fecha_actual = date('Y-m-d');
$id_usuario = $_SESSION['id_usuario'] ?? null;
if (!$id_usuario) {
    $error = "No se encontró el usuario. Por favor, inicia sesión nuevamente.";
    header("Location: index.php?error=" . urlencode($error));
    exit();
}
if (!isset($_SESSION["usuario"])) {
    $error = "No estás logueado. Por favor, inicia sesión.";
    header("Location: index.php?error=" . urlencode($error));
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reseña = mysqli_real_escape_string($conexion, $_POST['reseña']);
    $sql = "INSERT INTO reseñas (id_usuario, reseña, fecha) VALUES ($id_usuario, '$reseña', '$fecha_actual')";
    if (mysqli_query($conexion, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        $error = "Error al guardar la reseña. Inténtalo de nuevo.";
        header("Location: reseña.php?error=" . urlencode($error));
        exit();
    }
}   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">  
    <title>Reseñas</title>
</head>
<body><br>
<div class="container"> 
    <br>
    <h2>Deja tu reseña</h2>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <form method="POST">
        <div class="conform-group">
            <label for="reseña">Escribe tu reseña:</label>
            <textarea class="form-control" id="reseña" name="reseña" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-link text-decoration-underline">Enviar Reseña</button>
    </form>
    <br>
    </div>
</body>
</html>