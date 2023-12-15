<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="SASS/styles.css">

</head>
<body>
    <!-- Barra lateral -->
    <div class="sidebar">
            <h3>Bankini</h3>
            <img class="logo" src="img/Logo-removebg-preview.png" alt="Logo" width="60" height="40">

            <ul>
                <li><a href="banco.php">Inicio</a></li>
                <li><a href="#">Perfil</a></li>
                <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>
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
    header('Location: /html/login.html');
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Si se envía el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_actualizado = $conexion->real_escape_string($_POST['nombre']);
    $apellido_actualizado = $conexion->real_escape_string($_POST['apellido']);
    $fecha_nacimiento_actualizado = $conexion->real_escape_string($_POST['fecha_nacimiento']);
    $direccion_actualizado = $conexion->real_escape_string($_POST['direccion']);
    $ciudad_actualizado = $conexion->real_escape_string($_POST['ciudad']);
    $codigo_postal_actualizado = $conexion->real_escape_string($_POST['codigo_postal']);
    $provincia_actualizado = $conexion->real_escape_string($_POST['provincia']);
    $pais_actualizado = $conexion->real_escape_string($_POST['pais']);

    $consulta_actualizacion = "UPDATE usuarios SET nombre = '$nombre_actualizado', apellido = '$apellido_actualizado', fecha_nacimiento = '$fecha_nacimiento_actualizado', direccion = '$direccion_actualizado', codigo_postal = '$codigo_postal_actualizado', ciudad = '$ciudad_actualizado', provincia = '$provincia_actualizado', pais = '$pais_actualizado' WHERE id = '$usuario_id'";
    
    if ($conexion->query($consulta_actualizacion) === TRUE) {
        // Actualizar el nombre en la sesión
        $_SESSION['nombre'] = $nombre_actualizado;
        echo "Datos actualizados con éxito.";
    } else {
        echo "Error al actualizar los datos: " . $conexion->error;
    }
}

// Obtener los datos actualizados del usuario
$consulta = "SELECT nombre, apellido, dni, email, fecha_nacimiento, codigo_postal, direccion, ciudad, provincia, pais, foto_perfil, iban FROM usuarios WHERE id = '$usuario_id'";
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
            
            <p>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">
            </p>

            <p>
                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>">
            </p>

            <p>
                <label for="dni">DNI:</label>
                <span id="dni"><?php echo isset($usuario['dni']) ? htmlspecialchars($usuario['dni']) : 'No disponible'; ?></span>
            </p>

            <p>
                <label for="email">Email:</label>
                <span id="email"><?php echo isset($usuario['email']) ? htmlspecialchars($usuario['email']) : 'No disponible'; ?></span>
            </p>

            <p>
                <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>">
            </p>

            <p>
                <label for="direccion">Dirección:</label>
                <input type="text" id="direccion" name="direccion" value="<?php echo $usuario['direccion']; ?>">
            </p>

            <p>
                <label for="codigo_postal">Código postal:</label>
                <input type="text" id="codigo_postal" name="codigo_postal" value="<?php echo $usuario['codigo_postal']; ?>">
            </p>

            <p>
                <label for="ciudad">Ciudad:</label>
                <input type="text" id="ciudad" name="ciudad" value="<?php echo $usuario['ciudad']; ?>">
            </p>

            <p>
                <label for="provincia">Provincia:</label>
                <input type="text" id="provincia" name="provincia" value="<?php echo $usuario['provincia']; ?>">
            </p>

            <p>
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" value="<?php echo $usuario['pais']; ?>">
            </p>

            <p>
                <label for="iban">IBAN:</label>
                <span id="iban"><?php echo isset($usuario['iban']) ? htmlspecialchars($usuario['iban']) : 'No disponible'; ?></span>
            </p>

            <input type="submit" value="Actualizar">
        </form>
        
        <div class="perfil-imagen">

            <?php
                $rutaImagen = isset($usuario['foto_perfil']) && !empty($usuario['foto_perfil']) ? $usuario['foto_perfil'] : 'img/foto-predeterminada.png';
            ?>
            <img src="<?php echo $rutaImagen; ?>" alt="Foto de perfil">

        </div>

</body>
</html>         