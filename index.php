<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del usuario desde la sesión
$tipo_usuario = $_SESSION['tipo_usuario'];
$nombre_usuario = $_SESSION['nombre'];

include 'menu.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Concesionario - Inicio</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header class="header">
        <h1>Bienvenido a Concesionarios Loma</h1>
        <h2>Hola, <?php echo htmlspecialchars($nombre_usuario); ?> (<?php echo htmlspecialchars($tipo_usuario); ?>)</h2>
    </header>

    <main class="contenido">
        <h2>Sistema de Gestión de Coches</h2>
        <p>Controla nuestra base de datos de automóviles según tu rol. Aquí puedes:</p>
        <ul>
            <?php if ($tipo_usuario === 'comprador') : ?>
                <li>Buscar coches y alquilarlos.</li>
            <?php elseif ($tipo_usuario === 'vendedor') : ?>
                <li>Agregar, modificar y borrar coches.</li>
            <?php elseif ($tipo_usuario === 'admin') : ?>
                <li>Gestionar coches, usuarios y alquileres.</li>
            <?php endif; ?>
        </ul>
        <br>
        <img src="coches/coches.webp" alt="Imagen de coches" width="800" style="display: block; margin: 0 auto;">
    </main>

    <footer class="footer">
        <p>© 2024. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
