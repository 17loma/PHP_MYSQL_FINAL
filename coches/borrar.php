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

// Procesar búsqueda si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar'])) {
    $sql = "SELECT * FROM coches WHERE $criterio LIKE '%$busqueda%'";
    if ($_SESSION['tipo_usuario'] == 'comprador') {
        $sql .= " AND alquilado = 0"; // Solo coches disponibles para los compradores
    }

    $query_result = mysqli_query($conn, $sql);

    if ($query_result) {
        $resultados = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    }
}

// Procesar eliminación si se envía el formulario de eliminar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar']) && isset($_POST['coches'])) {
    $cochesSeleccionados = $_POST['coches'];
    $cochesLista = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($cochesSeleccionados), $conn), $cochesSeleccionados));
    
    $sql = "DELETE FROM coches WHERE id_coche IN ('$cochesLista')";
    if (mysqli_query($conn, $sql)) {
        $mensaje = "Coches eliminados correctamente.";
    } else {
        $mensaje = "Error al eliminar los coches.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar y Borrar Coches</title>
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
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <h2>Resultados</h2>
    <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>
    <?php if (!empty($resultados)) : ?>
        <form action="" method="POST">
            <table border="1">
                <tr>
                    <th>Seleccionar</th>
                    <th>Modelo</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Acción</th>
                </tr>
                <?php foreach ($resultados as $coche) : ?>
                    <tr>
                        <td><input type="checkbox" name="coches[]" value="<?php echo htmlspecialchars($coche['id_coche']); ?>"></td>
                        <td><?php echo htmlspecialchars($coche['modelo']); ?></td>
                        <td><?php echo htmlspecialchars($coche['marca']); ?></td>
                        <td><?php echo htmlspecialchars($coche['precio']); ?> €</td>
                        <td>
                            <?php if ($_SESSION['tipo_usuario'] == 'comprador') : ?>
                                <a href="../alquileres/alquilar.php?id_coche=<?php echo $coche['id_coche']; ?>">Alquilar</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <button type="submit" name="eliminar" onclick="return confirm('¿Seguro que deseas eliminar los coches seleccionados?');">Eliminar Seleccionados</button>
        </form>
    <?php else : ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>
</body>
</html>
