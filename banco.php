<?php
session_start();
include 'conexion.php';

$mensaje = "";

// Manejar acciones de depósito, retiro y solicitud de préstamo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];
    $accion = $_POST['accion'];

    if ($accion == 'depositar' || $accion == 'retirar') {
        $cantidad = floatval($_POST['cantidad']);
        $consultaSaldo = "SELECT saldo FROM usuarios WHERE id = '$usuario_id'";
        $resultado = $conexion->query($consultaSaldo);

        if ($resultado) {
            $fila = $resultado->fetch_assoc();
            $saldoActual = $fila['saldo'];

            if ($accion == 'depositar') {
                $nuevoSaldo = $saldoActual + $cantidad;
            } elseif ($accion == 'retirar') {
                if ($cantidad > $saldoActual) {
                    $mensaje = "No puedes retirar más saldo del disponible.";
                } else {
                    $nuevoSaldo = $saldoActual - $cantidad;
                }
            }

            if (empty($mensaje)) {
                $saldoHex = dechex($nuevoSaldo * 100);
                $consultaActualizar = "UPDATE usuarios SET saldo = '$nuevoSaldo', saldo_hex = '$saldoHex' WHERE id = '$usuario_id'";
                if ($conexion->query($consultaActualizar) === TRUE) {
                    $mensaje = "Saldo actualizado correctamente.";
                    $_SESSION['saldo'] = $nuevoSaldo;
                } else {
                    $mensaje = "Error al actualizar el saldo: " . $conexion->error;
                }
            }
        } else {
            $mensaje = "Error al obtener el saldo actual: " . $conexion->error;
        }
    } elseif ($accion == 'solicitar_prestamo') {
        $cantidadSolicitada = floatval($_POST['cantidad_prestamo']);
        $saldoMinimo = $cantidadSolicitada * 0.15;

        if ($_SESSION['saldo'] >= $saldoMinimo) {
            $consultaPrestamo = "INSERT INTO prestamos (usuario_id, cantidad) VALUES ('$usuario_id', '$cantidadSolicitada')";
            if ($conexion->query($consultaPrestamo) === TRUE) {
                $mensaje = "Solicitud de préstamo enviada.";
            } else {
                $mensaje = "Error al solicitar el préstamo: " . $conexion->error;
            }
        } else {
            $mensaje = "No cumples con los requisitos para el préstamo.";
        }
    }

    $conexion->close();
}
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
            <li><a href="perfil.php">Perfil</a></li>
            <li><a href="#">Productos</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="#">Ayuda</a></li>
        </ul>
    </div>

    <div class="content">
        <?php
            $fecha = new DateTime();
            $formatter = new IntlDateFormatter('es_ES', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
            $fechaFormateada = $formatter->format($fecha);
        ?>
        <p id="nombre">Hola, <?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Invitado'; ?>, hoy es <?php echo $fechaFormateada; ?>.</p>
        <p>Tu saldo actual es: <?php echo isset($_SESSION['saldo']) ? $_SESSION['saldo'] : 'No disponible'; ?>.</p>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <!-- Formulario para depositar y retirar -->
        <form method="post" action="banco.php">
            <input type="number" name="cantidad" placeholder="Cantidad" min="0" step="0.01" required>
            <button type="submit" name="accion" value="depositar">Depositar</button>
            <button type="submit" name="accion" value="retirar">Retirar</button>
        </form>

        <!-- Formulario para solicitar un préstamo -->
        <form method="post" action="banco.php">
            <input type="number" name="cantidad_prestamo" placeholder="Cantidad del Préstamo" min="0" step="0.01" required>
            <button type="submit" name="accion" value="solicitar_prestamo">Solicitar Préstamo</button>
        </form>
    </div>

    <script src="banco.js"></script>
</body>
</html>
