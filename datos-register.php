<?php
include 'conexion.php'; 

// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopilación y saneamiento de los datos del formulario
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

    // Define una consulta básica sin la foto de perfil
    $consulta = "INSERT INTO usuarios (nombre, email, password, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais) VALUES ('$nombre', '$email', '$password_encriptada', '$apellido', '$dni', '$fecha_nacimiento', '$direccion', '$codigo_postal', '$ciudad', '$provincia', '$pais')";

    // Procesa la foto de perfil si se subió una
    if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
        $fotoPerfil = $_FILES['foto_perfil'];
        $tamañoMaximo = 5 * 1024 * 1024; // 5MB, por ejemplo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if ($fotoPerfil['size'] <= $tamañoMaximo && in_array($fotoPerfil['type'], $tiposPermitidos)) {
            $nombreArchivo = uniqid() . "-" . basename($fotoPerfil['name']);
            $rutaDestino = 'uploads/' . $nombreArchivo;

            // Intenta mover el archivo subido al directorio de destino
            if (move_uploaded_file($fotoPerfil['tmp_name'], $rutaDestino)) {
                // Modifica la consulta para incluir la ruta de la imagen
                $consulta = "INSERT INTO usuarios (nombre, email, password, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais, foto_perfil) VALUES ('$nombre', '$email', '$password_encriptada', '$apellido', '$dni', '$fecha_nacimiento', '$direccion', '$codigo_postal', '$ciudad', '$provincia', '$pais', '$rutaDestino')";
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Archivo no válido o demasiado grande.";
        }
    }

    // Verifica si la consulta está definida y no es vacía
    if (isset($consulta) && $consulta) {
        if ($conexion->query($consulta) === TRUE) {
            session_start();
            $_SESSION['nombre'] = $nombre; 
            header('Location: login.html');
            exit;
        } else {
            echo "Error: " . $conexion->error;
        }
    } else {
        echo "Consulta SQL no definida o vacía.";
    }

    $conexion->close();
}
?>
