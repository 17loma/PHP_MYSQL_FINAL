<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || ($_SESSION['tipo_usuario'] !== 'vendedor' && $_SESSION['tipo_usuario'] !== 'admin')) {
    header("Location: ../login.php");
    exit();
}

include '../menu.php';

$tipo_usuario = $_SESSION['tipo_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Gestión de Usuarios</h2>
    <p>Selecciona una opción:</p>
    
    <ul>
        <li><a href="listar.php">Listar Usuarios</a></li>
        <li><a href="buscar.php">Buscar Usuarios</a></li>

        <?php if ($tipo_usuario === 'admin') : ?>
            <li><a href="añadir.php">Registrar Usuario</a></li>
            <li><a href="modificar.php">Modificar Usuario</a></li>
            <li><a href="borrar.php">Borrar Usuario</a></li>
        <?php endif; ?>
    </ul>
</body>
</html>

