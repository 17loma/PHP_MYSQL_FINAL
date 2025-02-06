<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "concesionario";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $correo = $_POST['correo'];
    $password = $_POST['password']; // ⚠️ Si quieres seguridad, usa password_hash()
    $tipo_usuario = $_POST['tipo_usuario'];
    $saldo = $_POST['saldo'];

    // Verificar si el usuario ya existe por DNI o correo
    $sql_verificar = "SELECT * FROM usuarios WHERE dni='$dni' OR correo='$correo'";
    $resultado = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado) > 0) {
        $mensaje = "El usuario con ese DNI o correo ya está registrado.";
    } else {
        // Insertar usuario en la base de datos
        $sql = "INSERT INTO usuarios (nombre, apellidos, dni, correo, password, tipo_usuario, saldo) 
                VALUES ('$nombre', '$apellidos', '$dni', '$correo', '$password', '$tipo_usuario', '$saldo')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php"); // Redirigir a login después del registro
            exit();
        } else {
            $mensaje = "Error al registrar usuario: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h2>Registro de Usuario</h2>
    <?php if (!empty($mensaje)) echo "<p style='color:red;'>$mensaje</p>"; ?>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" required><br>
        
        <label for="dni">DNI:</label>
        <input type="text" name="dni" required><br>
        
        <label for="correo">Correo:</label>
        <input type="email" name="correo" required><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>
        
        <label for="tipo_usuario">Rol:</label>
        <select name="tipo_usuario" required>
            <option value="comprador">Comprador</option>
            <option value="vendedor">Vendedor</option>
        </select><br>
        
        <label for="saldo">Saldo Inicial:</label>
        <input type="number" name="saldo" value="0" step="0.01" required><br>
        
        <button type="submit">Registrar</button>
    </form>
</body>
</html>
