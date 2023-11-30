<?php
include 'conexion.php'; 

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $email = $conexion->real_escape_string($_POST['email']);
    $password = $conexion->real_escape_string($_POST['password']);
    $apellido = $conexion->real_escape_string($_POST['apellido']);
    $dni = $conexion->real_escape_string($_POST['dni']);
    $fecha_nacimiento = $conexion->real_escape_string($_POST['fecha_nacimiento']);
    $direccion = $conexion->real_escape_string($_POST['direccion']);
    $codigo_postal = $conexion->real_escape_string($_POST['codigo_postal']);
    $ciudad = $conexion->real_escape_string($_POST['ciudad']);
    $provincia = $conexion->real_escape_string($_POST['provincia']);
    $pais = $conexion->real_escape_string($_POST['pais']);

    // Encripta la contraseña
    $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

    // Inserta el nuevo usuario en la base de datos
    $consulta = "INSERT INTO usuarios (nombre, email, password, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais) VALUES ('$nombre', '$email', '$password_encriptada', '$apellido', '$dni', '$fecha_nacimiento', '$direccion', '$codigo_postal', '$ciudad', '$provincia', '$pais')";

    if ($conexion->query($consulta) === TRUE) {
        // Redireccionar a la página de inicio de sesión después del registro exitoso
        header('Location: login.html');
        exit;
    } else {
        echo "Error: " . $consulta . "<br>" . $conexion->error;
    }

    $conexion->close();
}

// Guardar nombre en la sesión
if ($conexion->query($consulta) === TRUE) {
    session_start();
    $_SESSION['nombre'] = $nombre; 

    header('Location: banco.html');
    exit;
}

?>
