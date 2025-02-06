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
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE dni='$dni'";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);

        // Comprobación de contraseña sin encriptación (si usas `password_hash`, cambia esta parte)
        if ($password == $usuario['password']) {
            // Iniciar sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];

            // Redirigir según el tipo de usuario
            if ($usuario['tipo_usuario'] == "comprador") {
                header("Location: ./coches/buscar.php");
            } elseif ($usuario['tipo_usuario'] == "vendedor") {
                header("Location: ./index.php");
            } elseif ($usuario['tipo_usuario'] == "admin") {
                header("Location: ./index.php");
            }
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <?php if (!empty($mensaje)) echo "<p style='color:red;'>$mensaje</p>"; ?>
    
    <form method="POST" action="">
        <label for="dni">DNI:</label>
        <input type="text" name="dni" required><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br>
        
        <button type="submit">Iniciar Sesión</button> <br>

        <h1>¿No te has registrado todavía?<br>
        <a href="registro.php">Regístrate</a></h1>
    </form>
</body>
</html>
