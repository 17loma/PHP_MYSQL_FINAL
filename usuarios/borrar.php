    <?php
    session_start();
    if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
        header("Location: ../login.php");
        exit();
    }

    include '../menu.php';

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "concesionario";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    $mensaje = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuarios'])) {
        $usuariosSeleccionados = $_POST['usuarios'];
        $usuariosLista = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($usuariosSeleccionados), $conn), $usuariosSeleccionados));
        
        $sql = "DELETE FROM usuarios WHERE correo IN ('$usuariosLista')";
        if (mysqli_query($conn, $sql)) {
            $mensaje = "Usuarios eliminados correctamente.";
        } else {
            $mensaje = "Error al eliminar los usuarios.";
        }
    }

    $sql = "SELECT nombre, apellidos, dni, correo FROM usuarios";
    $result = mysqli_query($conn, $sql);
    $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_close($conn);
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Borrar Usuarios</title>
        <link rel="stylesheet" href="../index.css">
    </head>
    <body>
        <h2>Borrar Usuarios</h2>
        <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>
        <form action="" method="post">
            <table border="1">
                <tr>
                    <th>Seleccionar</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>DNI</th>
                    <th>Correo</th>
                </tr>
                <?php foreach ($usuarios as $usuario) : ?>
                    <tr>
                        <td><input type="checkbox" name="usuarios[]" value="<?php echo htmlspecialchars($usuario['correo']); ?>"></td>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['dni']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar los usuarios seleccionados?');">Eliminar Seleccionados</button>
        </form>
        <a href="listar.php">Volver al listado</a>
    </body>
    </html>