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

// Obtener la lista de usuarios solo si el usuario es admin
$sql = "SELECT nombre, apellidos, dni, correo, tipo_usuario, saldo 
        FROM usuarios";
$result = mysqli_query($conn, $sql);
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Listado de Usuarios</h2>
    <table border="1">
        <tr>
           
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>DNI</th>
            <th>Correo</th>
            <th>Tipo de Usuario</th>
            <th>Saldo (€)</th>
            <th>Acciones</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['apellidos']); ?></td>
                <td><?php echo htmlspecialchars($row['dni']); ?></td>
                <td><?php echo htmlspecialchars($row['correo']); ?></td>
                <td><?php echo htmlspecialchars($row['tipo_usuario']); ?></td>
                <td><?php echo number_format($row['saldo'], 2); ?> €</td>
                <td>
                    <a href="modificar.php?id_usuario=<?php echo $row['id_usuario']; ?>">Modificar</a> |
                    <a href="borrar.php?id_usuario=<?php echo $row['id_usuario']; ?>" onclick="return confirm('¿Seguro que deseas borrar este usuario?');">Borrar</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
