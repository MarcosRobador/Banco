<?php
include 'conexion.php'; 

function letra_a_binario($letra) {
    $posicion = ord(strtoupper($letra)) - ord('A') + 1;
    return str_pad(decbin($posicion), 5, "0", STR_PAD_LEFT);
}

function generar_identificador_iban($nombre, $conexion) {
    $nombre = str_pad($nombre, 4, "z");
    $nombre = substr($nombre, 0, 4);
    $binario = '';

    for ($i = 0; $i < 4; $i++) {
        $binario .= letra_a_binario($nombre[$i]);
    }

    $iban_unico = $binario;
    $contador = 1;

    do {
        $consulta = "SELECT COUNT(*) AS cantidad FROM usuarios WHERE iban = '$iban_unico'";
        $resultado = $conexion->query($consulta);
        $fila = $resultado->fetch_assoc();

        if ($fila['cantidad'] == 0) {
            break;
        } else {
            $iban_unico = $binario . str_repeat(($contador % 2 == 0) ? '0' : '1', $contador);
            $contador++;
        }
    } while (true);

    return $iban_unico;
}

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

    // Genera el identificador IBAN basado en el nombre
    $iban = generar_identificador_iban($nombre, $conexion);

    // Consulta con el IBAN
    $consulta = "INSERT INTO usuarios (nombre, email, password, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais, iban) VALUES ('$nombre', '$email', '$password_encriptada', '$apellido', '$dni', '$fecha_nacimiento', '$direccion', '$codigo_postal', '$ciudad', '$provincia', '$pais', '$iban')";

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
                // Si se sube el archivo con éxito, incluye la ruta de la imagen en la consulta
                $consulta = "INSERT INTO usuarios (nombre, email, password, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais, foto_perfil, iban) VALUES ('$nombre', '$email', '$password_encriptada', '$apellido', '$dni', '$fecha_nacimiento', '$direccion', '$codigo_postal', '$ciudad', '$provincia', '$pais', '$rutaDestino', '$iban')";
            } else {
                echo "Error al subir el archivo.";
            }
        } else {
            echo "Archivo no válido o demasiado grande.";
        }
    }

    // Ejecuta la consulta de inserción en la base de datos
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

    // Cierra la conexión de la base de datos
    $conexion->close();
}
?>