<?php
session_start();
if (!isset($_SESSION['tipo_usuario']) || ($_SESSION['tipo_usuario'] !== 'vendedor' && $_SESSION['tipo_usuario'] !== 'admin' && $_SESSION['tipo_usuario'] !== 'comprador')) {
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
    <title>Gestión de Coches</title>
    <link rel="stylesheet" href="../index.css">
</head>
<body>
    <h2>Gestión de Coches</h2>
    <p>Selecciona una opción:</p>
    
    <ul>
        <li><a href="listar.php">Listar Coches</a></li>
        <li><a href="buscar.php">Buscar Coches</a></li>
        
        <?php if ($tipo_usuario === 'admin' || $tipo_usuario === 'vendedor') : ?>
            <li><a href="añadir.php">Registrar Coche</a></li>
            <li><a href="modificar.php">Modificar Coche</a></li>
            <li><a href="borrar.php">Borrar Coche</a></li>
        <?php endif; ?>
    </ul>
</body>
</html>