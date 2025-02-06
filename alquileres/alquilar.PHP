
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Coche</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <header class="header">
        <h1>Añadir Coche al Concesionario</h1>
    </header>
    <nav class="menu">
        <ul>
            <li>
                <a href="../coches/coches.html">Coches</a>
                <ul>
                    <li><a href="../coches/añadir.php">Añadir</a></li>
                    <li><a href="../coches/modificar.php">Modificar</a></li>
                    <li><a href="../coches/borrar.php">Borrar</a></li>
                    <li><a href="../coches/listar.php">Listar</a></li>
                    <li><a href="../coches/buscar.php">Buscar</a></li>
                </ul>
            </li>
            <li>
                <a href="../usuarios/usuarios.html">Usuarios</a>
                <ul>
                    <li><a href="../usuarios/añadir.php">Registrar</a></li>
                    <li><a href="../usuarios/listar.php">Listar</a></li>
                    <li><a href="../usuarios/buscar.php">Buscar</a></li>
                </ul>
            </li>
            <li>
                <a href="../alquileres/alquileres.html">Alquileres</a>
                <ul>
                    <li><a href="../alquileres/listar.php">Listar</a></li>
                    <li><a href="../alquileres/borrar.php">Borrar</a></li>
                </ul>
            </li>
            <li><a href="../usuarios/logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
<?php
session_start();

// Verificar si el usuario ha iniciado sesión como comprador
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] != 'comprador') {
    header("Location: ../usuarios/login.php");
    exit();
}

// Verificar si se proporcionó un ID de coche
if (!isset($_GET['id_coche']) || empty($_GET['id_coche'])) {
    echo "Error: No se proporcionó un ID de coche válido.";
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "concesionario";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el ID del coche desde la URL
$id_coche = mysqli_real_escape_string($conn, $_GET['id_coche']);

// Verificar si el coche está disponible para alquilar
$sql_verificar = "SELECT * FROM coches WHERE id_coche = '$id_coche' AND alquilado = 0";
$result_verificar = mysqli_query($conn, $sql_verificar);

if (mysqli_num_rows($result_verificar) > 0) {
    // Marcar el coche como alquilado
    $sql_alquilar = "UPDATE coches SET alquilado = 1 WHERE id_coche = '$id_coche'";
    if (mysqli_query($conn, $sql_alquilar)) {
        echo "<p>Coche alquilado con éxito.</p>";
        echo "<a href='listar.php'>Volver al listado de coches</a>";
    } else {
        echo "<p>Error al alquilar el coche: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>El coche no está disponible para alquilar o ya está alquilado.</p>";
}

mysqli_close($conn);
?>

    <footer class="footer">
        <p>© 2024. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
