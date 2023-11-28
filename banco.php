<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankini</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="banco.css">
</head>
<body>
      
      <!-- Barra lateral -->
        <div class="sidebar">
            <h3>Bankini</h3>
            <img class="logo" src="img/Logo-removebg-preview.png" alt="Logo" width="60" height="40">

            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Perfil</a></li>
                <li><a href="#">Productos</a></li>
                <li><a href="#">Contacto</a></li>
                <li><a href="#">Ayuda</a></li>
            </ul>
        </div>
  
        <div class="content">
            <!-- Mensaje de bienvenida -->
            <p>Hola, <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado'; ?></p>
        </div>

        <script src="banco.js"></script>

</body>
</html>