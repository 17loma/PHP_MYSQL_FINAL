<?php
session_start();
require_once __DIR__ . '../config.php'; // Cargar configuración de la URL base

// Redirigir al login si el usuario no está autenticado
if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: " . BASE_URL . "login.php");
    exit();
}
?>

<nav class="menu">
    <ul>
        <li><a href="<?php echo BASE_URL; ?>index.php">Inicio</a></li>
        <li><a href="<?php echo BASE_URL; ?>coches/index.php">Coches</a></li>

        <?php if ($_SESSION['tipo_usuario'] === 'vendedor' || $_SESSION['tipo_usuario'] === 'admin') : ?>
            <li><a href="<?php echo BASE_URL; ?>usuarios/index.php">Usuarios</a></li>
        <?php endif; ?>

        <li><a href="<?php echo BASE_URL; ?>alquileres/index.php">Alquileres</a></li>
        <li><a href="<?php echo BASE_URL; ?>logout.php">Cerrar Sesión</a></li>
    </ul>
</nav>