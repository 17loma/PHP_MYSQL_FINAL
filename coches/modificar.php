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

$criterio = $_POST['criterio'] ?? '';
$busqueda = $_POST['busqueda'] ?? '';
$resultados = [];
$busqueda_realizada = false;
$seleccionado = false;
$coche_seleccionado = null;
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buscar']) && !empty($criterio) && !empty($busqueda)) {
    $busqueda_realizada = true;
    $criterio = mysqli_real_escape_string($conn, $criterio);
    $busqueda = mysqli_real_escape_string($conn, $busqueda);
    $sql = "SELECT * FROM coches WHERE $criterio LIKE '%$busqueda%'";
    $query_result = mysqli_query($conn, $sql);
    if ($query_result) {
        $resultados = mysqli_fetch_all($query_result, MYSQLI_ASSOC);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['seleccionar'])) {
    $id_coche = $_POST['id_coche'];
    $sql = "SELECT * FROM coches WHERE id_coche='$id_coche'";
    $query_result = mysqli_query($conn, $sql);
    if ($query_result) {
        $coche_seleccionado = mysqli_fetch_assoc($query_result);
        $seleccionado = true;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['modificar'])) {
    $id_coche = $_POST['id_coche'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $año = $_POST['año'];
    $precio = $_POST['precio'];
    $color = $_POST['color'];
    $alquilado = $_POST['alquilado'];
    
    $sql = "UPDATE coches SET marca='$marca', modelo='$modelo', precio='$precio', color='$color', alquilado='$alquilado' 
    WHERE id_coche='$id_coche'";
    if (mysqli_query($conn, $sql)) {
        $mensaje = "Coche actualizado correctamente.";
       
    } 
    else {
        $mensaje = "Error al actualizar el coche.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Coches</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Formulario de Búsqueda</h2>
    <form action="" method="POST">
        <label for="criterio">Buscar por:</label>
        <select name="criterio" required>
            <option value="modelo">Modelo</option>
            <option value="marca">Marca</option>
        </select>
        <input type="text" name="busqueda" required>
        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>
    
    <?php if ($busqueda_realizada && !empty($resultados)) : ?>
        <h2>Seleccionar Coche</h2>
        <form action="" method="POST">
            <table border="1">
                <thead>
                    <tr>
                        <th>Seleccionar</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Precio (€)</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $coche) : ?>
                        <tr>
                            <td><input type="radio" name="id_coche" value="<?php echo htmlspecialchars($coche['id_coche']); ?>" required></td>
                            <td><?php echo htmlspecialchars($coche['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($coche['marca']); ?></td>
                            <td><?php echo htmlspecialchars($coche['precio']); ?></td>
                            <td><?php echo $coche['alquilado'] == 0 ? 'Disponible' : 'Alquilado'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="seleccionar">Modificar Seleccionado</button>
        </form>
    <?php endif; ?>

    <?php if ($seleccionado && $coche_seleccionado) : ?>
        <h2>Modificar Coche</h2>
        <form action="" method="POST">
            <input type="hidden" name="id_coche" value="<?php echo htmlspecialchars($coche_seleccionado['id_coche']); ?>">
            <label>Marca:</label>
            <input type="text" name="marca" value="<?php echo htmlspecialchars($coche_seleccionado['marca']); ?>" required><br>
            <label>Modelo:</label>
            <input type="text" name="modelo" value="<?php echo htmlspecialchars($coche_seleccionado['modelo']); ?>" required><br>
            
            <label>Precio (€):</label>
            <input type="number" name="precio" step="0.01" value="<?php echo htmlspecialchars($coche_seleccionado['precio']); ?>" required><br>
            <label>Color:</label>
            <input type="text" name="color" value="<?php echo htmlspecialchars($coche_seleccionado['color']); ?>" required><br>
            <label>Estado:</label>
            <select name="alquilado" required>
                <option value="0" <?php if ($coche_seleccionado['alquilado'] == 0) echo 'selected'; ?>>Disponible</option>
                <option value="1" <?php if ($coche_seleccionado['alquilado'] == 1) echo 'selected'; ?>>Alquilado</option>
            </select><br>
            <button type="submit" name="modificar">Actualizar</button>
        </form>
    <?php endif; ?>
</body>
</html>

