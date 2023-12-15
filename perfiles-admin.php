<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bankini - Usuarios</title>
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
            <li><a href="#">Perfiles</a></li>
            <li><a href="#">Productos</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="#">Ayuda</a></li>
        </ul>
    </div>

    <div class="content">
        <?php
        include 'conexion.php';

        $consulta = "SELECT id, nombre, apellido, dni, fecha_nacimiento, direccion, codigo_postal, ciudad, provincia, pais, email FROM usuarios";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Fecha Nacimiento</th>
                        <th>Dirección</th>
                        <th>Código Postal</th>
                        <th>Ciudad</th>
                        <th>Provincia</th>
                        <th>País</th>
                        <th>Email</th>
                    </tr>
                  </thead>";
            echo "<tbody>";
            while($fila = $resultado->fetch_assoc()) {
                echo "<tr>
                        <td>" . $fila["id"] . "</td>
                        <td>" . $fila["nombre"] . "</td>
                        <td>" . $fila["apellido"] . "</td>
                        <td>" . $fila["dni"] . "</td>
                        <td>" . $fila["fecha_nacimiento"] . "</td>
                        <td>" . $fila ["direccion"] . "</td>
                        <td>" . $fila["codigo_postal"] . "</td>
                        <td>" . $fila["ciudad"] . "</td>
                        <td>" . $fila["provincia"] . "</td>
                        <td>" . $fila["pais"] . "</td>
                        <td>" . $fila["email"] . "</td>
                        </tr>";
                        }
                        echo "</tbody></table>";
                        } else {
                        echo "<p>No hay usuarios registrados.</p>";
                        }
                        $conexion->close();
                        ?>
                    </div>
                    
                    <script src="banco.js"></script>
</body>
</html>