<?php
session_start(); 
include 'conexion.php'; 

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conexion->real_escape_string($_POST['email']);
    $password = $conexion->real_escape_string($_POST['password']);

    // Credenciales del administrador
    $adminEmail = "admin@gmail.com";
    $adminPassword = "admin123"; 

    // Verifica si las credenciales son del administrador
    if ($email === $adminEmail && $password === $adminPassword) {
        // Iniciar sesión como administrador
        $_SESSION['usuario_id'] = 0; 
        $_SESSION['nombre'] = "admin";
        
        // Redireccionar a banco.php
        header("Location: admin.php");
        exit();
    }

    // Consulta para buscar el usuario en la base de datos
    $consulta = "SELECT id, nombre, password FROM usuarios WHERE email = '$email'";
    $resultado = $conexion->query($consulta);

    if ($resultado->num_rows > 0) {
        // Usuario encontrado
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila['password'])) {
            // La contraseña coincide
            $_SESSION['usuario_id'] = $fila['id']; 
            $_SESSION['nombre'] = $fila['nombre'];
            
            // Redireccionar a banco.php
            header("Location: banco.php");
            exit();
        } else {
            // La contraseña no coincide
            echo "Contraseña incorrecta";
        }
    } else {
        // Usuario no encontrado
        echo "No se encontró una cuenta con ese email";
    }
    $conexion->close();
}
?>
