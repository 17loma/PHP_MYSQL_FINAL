<?php
session_start();

if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: ../usuarios/login.php");
    exit();
}

include '../menu.php';

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "concesionario";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

$sql = "SELECT * FROM coches";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listar Coches</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h1>Listado de Coches</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Precio (€)</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['modelo']); ?></td>
                    <td><?php echo htmlspecialchars($row['marca']); ?></td>
                    <td><?php echo htmlspecialchars($row['precio']); ?></td>
                    <td><?php echo $row['alquilado'] == 0 ? 'Disponible' : 'Alquilado'; ?></td>
                    <td>
                        <?php if ($_SESSION['tipo_usuario'] == 'comprador' && $row['alquilado'] == 0) : ?>
                            <a href="../alquileres/alquilar.php?id_coche=<?php echo $row['id_coche']; ?>">Alquilar</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

