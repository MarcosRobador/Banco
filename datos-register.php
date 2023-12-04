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

    // Procesa la foto de perfil si se subió una
    if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] == 0) {
        $fotoPerfil = $_FILES['fotoPerfil'];

        // Verificar tamaño y tipo del archivo
        $tamañoMaximo = 5 * 1024 * 1024; // 5MB, por ejemplo
        $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if ($fotoPerfil['size'] <= $tamañoMaximo && in_array($fotoPerfil['type'], $tiposPermitidos)) {
            $nombreArchivo = uniqid() . "-" . basename($fotoPerfil['name']);
            $rutaDestino = 'uploads/' . $nombreArchivo;

            // Intenta mover el archivo subido al directorio de destino
            if (move_uploaded_file($fotoPerfil['tmp_name'], $rutaDestino)) {
                // Aquí puedes modificar tu consulta para incluir la ruta de la imagen
                $consulta = "INSERT INTO usuarios (nombre, email, password, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais, fotoPerfil) VALUES ('$nombre', '$email', '$password_encriptada', '$apellido', '$dni', '$fecha_nacimiento', '$direccion', '$codigo_postal', '$ciudad', '$provincia', '$pais', '$rutaDestino')";
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Archivo no válido o demasiado grande.";
        }
    }

    // Inserta el nuevo usuario en la base de datos
    if ($conexion->query($consulta) === TRUE) {
        session_start();
        $_SESSION['nombre'] = $nombre; 
        header('Location: banco.html');
        exit;
    } else {
        echo "Error: " . $consulta . "<br>" . $conexion->error;
    }

    $conexion->close();
}
?>
