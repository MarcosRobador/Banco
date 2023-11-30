<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="perfil.css">

</head>
<body>
    <!-- Barra lateral -->
    <div class="sidebar">
            <h3>Bankini</h3>
            <img class="logo" src="img/Logo-removebg-preview.png" alt="Logo" width="60" height="40">

            <ul>
                <li><a href="banco.php">Inicio</a></li>
                <li><a href="#">Perfil</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Ayuda</a></li>
            </ul>
        </div>

        <div class="content">
            <?php
session_start();
include 'conexion.php';

// Asegurarse de que el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Si se envía el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_actualizado = $conexion->real_escape_string($_POST['nombre']);
    $email_actualizado = $conexion->real_escape_string($_POST['email']);

    $consulta_actualizacion = "UPDATE usuarios SET nombre = '$nombre_actualizado', email = '$email_actualizado' WHERE id = '$usuario_id'";
    
    if ($conexion->query($consulta_actualizacion) === TRUE) {
        // Actualizar el nombre en la sesión
        $_SESSION['nombre'] = $nombre_actualizado;
        echo "Datos actualizados con éxito.";
    } else {
        echo "Error al actualizar los datos: " . $conexion->error;
    }
}

// Obtener los datos actualizados del usuario
$consulta = "SELECT nombre, email FROM usuarios WHERE id = '$usuario_id'";
$resultado = $conexion->query($consulta);

if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();
} else {
    echo "No se encontraron datos del usuario.";
}

$conexion->close();
?>

        <!-- Formulario HTML para mostrar y editar los datos del usuario -->
        <form action="perfil.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>">

            <input type="submit" value="Actualizar">
        </form>
        
    </div>

</body>
</html>