<?php
include 'conexion.php'; 

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $email = $conexion->real_escape_string($_POST['email']);
    $password = $conexion->real_escape_string($_POST['password']);

    // Encripta la contraseña
    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

    // Inserta el nuevo usuario en la base de datos
    $consulta = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password_encriptada')";

    if ($conexion->query($consulta) === TRUE) {
        // Redireccionar a la página de inicio de sesión después del registro exitoso
        header('Location: login.html');
        exit;
    } else {
        echo "Error: " . $consulta . "<br>" . $conexion->error;
    }

    $conexion->close();
}
?>
