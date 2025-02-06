<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'vendedor') {
    header("Location: ../login.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "concesionario";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $modelo = $_POST['modelo'];
    $marca = $_POST['marca'];
    $color = $_POST['color'];
    $precio = $_POST['precio'];

    $sql = "INSERT INTO coches (modelo, marca, color, precio) VALUES ('$modelo', '$marca', '$color', '$precio')";
    if (mysqli_query($conn, $sql)) {
        $mensaje = "Coche añadido con éxito.";
    } else {
        $mensaje = "Error al añadir coche.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Coche</title>
</head>
<body>
    <h2>Añadir Coche</h2>
    <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>
    <form action="" method="post">
        <label>Modelo:</label>
        <input type="text" name="modelo" required><br>
        <label>Marca:</label>
        <input type="text" name="marca" required><br>
        <label>Color:</label>
        <input type="text" name="color" required><br>
        <label>Precio:</label>
        <input type="number" name="precio" step="0.01" required><br>
        <button type="submit">Añadir</button>
    </form>
</body>
</html>
