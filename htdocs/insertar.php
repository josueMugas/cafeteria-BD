<?php
session_start();    
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpieza de datos
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $email  = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = mysqli_real_escape_string($conexion, $_POST['pass']); // Corregido
    $domicilio = mysqli_real_escape_string($conexion, $_POST["domicilio"]);


    $sql = "SELECT * FROM clientes WHERE mail = '$email' or contraseña = '$password'";
    $resultado = mysqli_query($conexion, $sql);
    // si el correo o contraseña ya existe, redirige al registro con un mensaje de error
    if (mysqli_num_rows($resultado) > 0) {
        header("Location: registro.php?error=El correo o contraseña ya está registrado");
        exit();
    } else {
        $_SESSION['usuario'] = $email;
        
        $sql = "INSERT INTO clientes (nombre, mail, contraseña, domicilio) 
            VALUES ('$nombre', '$email', '$password', '$domicilio')";

    if (mysqli_query($conexion, $sql)) {
        header('Location: clientes.php');
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
    }
}
mysqli_close($conexion);
?>