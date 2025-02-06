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

if (!isset($_GET['id_usuario'])) {
    header("Location: buscar.php");
    exit();
}

$id_usuario = $_GET['id_usuario'];

// Obtener datos del usuario actual
$sql = "SELECT nombre, apellidos, dni, correo, tipo_usuario, saldo FROM usuarios WHERE id_usuario='$id_usuario'";
$result = mysqli_query($conn, $sql);
$usuario = mysqli_fetch_assoc($result);
if (!$usuario) {
    die("Usuario no encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];
    $saldo = $_POST['saldo'];
    
    $sql = "UPDATE usuarios SET nombre='$nombre', apellidos='$apellidos', dni='$dni', correo='$correo', tipo_usuario='$tipo_usuario', saldo='$saldo' WHERE id_usuario='$id_usuario'";
    if (mysqli_query($conn, $sql)) {
        $mensaje = "Usuario actualizado correctamente.";
        
    } 
    else {
        $mensaje = "Error al actualizar el usuario.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Usuario</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Modificar Usuario</h2>
    <?php if (!empty($mensaje)) echo "<p>$mensaje</p>"; ?>
    <form action="" method="post">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>
        <label>Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required><br>
        <label>DNI:</label>
        <input type="text" name="dni" value="<?php echo htmlspecialchars($usuario['dni']); ?>" required><br>
        <label>Correo:</label>
        <input type="email" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required><br>
        <label>Tipo de Usuario:</label>
        <select name="tipo_usuario" required>
            <option value="comprador" <?php if ($usuario['tipo_usuario'] == 'comprador') echo 'selected'; ?>>Comprador</option>
            <option value="vendedor" <?php if ($usuario['tipo_usuario'] == 'vendedor') echo 'selected'; ?>>Vendedor</option>
            <option value="admin" <?php if ($usuario['tipo_usuario'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select><br>
        <label>Saldo (€):</label>
        <input type="number" name="saldo" step="0.01" value="<?php echo htmlspecialchars($usuario['saldo']); ?>" required><br>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
