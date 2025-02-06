<?php
include '../menu.php'; // Incluir el menú dinámico

// Verificar si el usuario tiene permisos (solo vendedores y administradores)
session_start();
if (!isset($_SESSION['tipo_usuario']) || !in_array($_SESSION['tipo_usuario'], ['vendedor', 'admin'])) {
    header("Location: ../usuarios/login.php");
    exit();
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "concesionario";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Recoger datos del formulario
    $modelo = mysqli_real_escape_string($conn, $_POST['modelo']);
    $marca = mysqli_real_escape_string($conn, $_POST['marca']);
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $precio = floatval($_POST['precio']);
    $alquilado = isset($_POST['alquilado']) ? intval($_POST['alquilado']) : 0;

    // Subida de imagen
    $foto = $_FILES['imagen']['name'];
    $foto_tmp = $_FILES['imagen']['tmp_name'];
    $directorio_destino = "../coches/fotos/";
    $ruta_foto = $directorio_destino . basename($foto);

    // Verificar que la imagen se haya subido correctamente
    if (move_uploaded_file($foto_tmp, $ruta_foto)) {
        // Insertar el coche en la base de datos
        $sql = "INSERT INTO coches (modelo, marca, color, precio, alquilado, foto) 
                VALUES ('$modelo', '$marca', '$color', '$precio', '$alquilado', '$ruta_foto')";

        if (mysqli_query($conn, $sql)) {
            echo "<p style='color:green;'>Coche añadido con éxito.</p>";
        } else {
            echo "<p style='color:red;'>Error al añadir el coche: " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Error al subir la imagen.</p>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Coche</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <header class="header">
        <h1>Añadir Coche</h1>
    </header>

    <main class="contenido">
        <form action="" method="post" enctype="multipart/form-data">
            <label for="modelo">Modelo:</label>
            <input type="text" name="modelo" required><br>

            <label for="marca">Marca:</label>
            <input type="text" name="marca" required><br>

            <label for="color">Color:</label>
            <input type="text" name="color" required><br>

            <label for="precio">Precio:</label>
            <input type="number" name="precio" step="0.01" required><br>

            <label for="alquilado">Estado:</label>
            <select name="alquilado">
                <option value="0">Disponible</option>
                <option value="1">Alquilado</option>
            </select><br>

            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" accept="image/*" required><br>

            <button type="submit">Añadir Coche</button>
        </form>
    </main>

    <footer class="footer">
        <p>© 2024. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

