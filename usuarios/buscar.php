<?php
session_start();
if (!isset($_SESSION['tipo_usuario'])) {
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

$criterio = $_POST['criterio'] ?? '';
$busqueda = $_POST['busqueda'] ?? '';
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sql = "SELECT id_usuario, nombre, apellidos, dni, correo, tipo_usuario, saldo FROM usuarios WHERE $criterio LIKE '%$busqueda%'";
    $query_result = mysqli_query($conn, $sql);
    if ($query_result) {
        $resultados = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar Usuarios</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Buscar Usuario</h2>
    <form action="" method="POST">
        <label for="criterio">Buscar por:</label>
        <select name="criterio" required>
            <option value="nombre">Nombre</option>
            <option value="apellidos">Apellidos</option>
            <option value="dni">DNI</option>
            <option value="correo">Correo</option>
        </select>
        <input type="text" name="busqueda" required>
        <input type="submit" value="Buscar">
    </form>
    
    <h2>Resultados</h2>
    <?php if (!empty($resultados)) : ?>
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
            <?php foreach ($resultados as $usuario) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['apellidos']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['dni']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                    <td><?php echo htmlspecialchars($usuario['tipo_usuario']); ?></td>
                    <td><?php echo number_format($usuario['saldo'], 2); ?> €</td>
                    <td>
                        <a href="modificar.php?id_usuario=<?php echo $usuario['id_usuario']; ?>">Modificar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
