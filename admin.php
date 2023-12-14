<?php
session_start();
include 'conexion.php';



$mensaje = "";

// Lógica para aprobar o rechazar préstamos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPrestamo = $_POST['id_prestamo'];
    $accion = $_POST['accion'];

    $estadoAprobacion = ($accion == 'aprobar') ? 1 : 0;
    $consultaActualizar = "UPDATE prestamos SET aprobado = '$estadoAprobacion' WHERE id = '$idPrestamo'";
    if ($conexion->query($consultaActualizar) === TRUE) {
        $mensaje = "Préstamo " . ($estadoAprobacion ? "aprobado" : "rechazado") . ".";
    } else {
        $mensaje = "Error al actualizar el préstamo: " . $conexion->error;
    }
}

// Obtener todas las solicitudes de préstamos pendientes
$consultaPrestamos = "SELECT * FROM prestamos WHERE aprobado IS NULL";
$resultadoPrestamos = $conexion->query($consultaPrestamos);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="#">Productos</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="#">Ayuda</a></li>
        </ul>
    </div>

    <div class="content">
        <h2>Gestión de Préstamos</h2>
        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <!-- Tabla de solicitudes de préstamos -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario ID</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $resultadoPrestamos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['id']; ?></td>
                        <td><?php echo $fila['usuario_id']; ?></td>
                        <td><?php echo $fila['cantidad']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="id_prestamo" value="<?php echo $fila['id']; ?>">
                                <button type="submit" name="accion" value="aprobar">Aprobar</button>
                                <button type="submit" name="accion" value="rechazar">Rechazar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>