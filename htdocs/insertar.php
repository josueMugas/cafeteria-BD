<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpieza de datos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email  = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['pass']); // Corregido
    $domicilio = mysqli_real_escape_string($conexion, $_POST["domicilio"]);

    $sql = "INSERT INTO clientes (nombre, mail, contraseña, domicilio) 
            VALUES ('$nombre', '$email', '$password', '$domicilio')";

    if (mysqli_query($conexion, $sql)) {
        header('Location: clientes.php');
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
mysqli_close($conexion);
?>