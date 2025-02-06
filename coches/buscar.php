<?php

session_start();

// Verificar si el usuario tiene permisos para buscar (comprador, admin o vendedor)
if (!isset($_SESSION['tipo_usuario']) || !in_array($_SESSION['tipo_usuario'], ['comprador', 'vendedor', 'admin'])) {
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

// Inicializar variables para búsqueda
$criterio = $_POST['criterio'] ?? '';
$busqueda = $_POST['busqueda'] ?? '';
$resultados = [];
$busqueda_realizada = false;

// Procesar búsqueda si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($criterio) && !empty($busqueda)) {
    $busqueda_realizada = true;
    $sql = "SELECT * FROM coches WHERE $criterio LIKE '%$busqueda%'";
    if ($_SESSION['tipo_usuario'] == 'comprador') {
        $sql .= " AND alquilado = 0"; // Solo coches disponibles para los compradores
    }

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
    <title>Buscar Coches</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Formulario de Búsqueda</h2>
    <form action="" method="POST">
        <label for="criterio">Buscar por:</label>
        <select name="criterio" required>
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
            <option value="color">Color</option>
        </select>
        <input type="text" name="busqueda" required>
        <input type="submit" value="Buscar">
    </form>

    <?php if ($busqueda_realizada) : ?>
        <h2>Resultados</h2>
        <?php if (!empty($resultados)) : ?>
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
                    <?php foreach ($resultados as $coche) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($coche['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($coche['marca']); ?></td>
                            <td><?php echo htmlspecialchars($coche['precio']); ?></td>
                            <td><?php echo $coche['alquilado'] == 0 ? 'Disponible' : 'Alquilado'; ?></td>
                            <td>
                                <?php if ($_SESSION['tipo_usuario'] == 'comprador' && $coche['alquilado'] == 0) : ?>
                                    <a href="../alquileres/alquilar.php?id_coche=<?php echo $coche['id_coche']; ?>">Alquilar</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No se encontraron resultados.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
