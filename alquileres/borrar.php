<!DOCTYPE html>
<html lang="es">
	<head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="../icon.png" sizes="32x32">
		<link rel="stylesheet" href="../index.css">
		<title>Pagina de Automoviles</title>
	</head>
	<body>
		<header class="header">
            <h1></h1>
        </header>
        <nav class="menu">
            <ul>
                <li>
                    <a href="../coches/coches.html">Coches</a>
                     <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../coches/añadir.html">Añadir</a></li>
                        <li><a href="../coches/listar.php">Listar</a></li>
                        <li><a href="../coches/buscar.html">Buscar</a></li>
                        <li><a href="../coches/modificar.html">Modificar</a></li>
                        <li><a href="../coches/borrar.php">Borrar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../usuarios/usuarios.html">Usuarios</a>
                    <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../usuarios/añadir.html">Añadir</a></li>
                        <li><a href="../usuarios/listar.php">Listar</a></li>
                        <li><a href="../usuarios/buscar.html">Buscar</a></li>
                        <li><a href="../usuarios/modificar.html">Modificar</a></li>
                        <li><a href="../usuarios/borrar.php">Borrar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../alquileres/alquileres.html">Alquileres</a>
                    <ul>
                        <li><a href="../index.html">Inicio</a></li>
                        <li><a href="../alquileres/listar.php">Listar</a></li>
                        <li><a href="../alquileres/borrar.php">Borrar</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <main class="contenido">
            <h2>ALQUILERES</h2>
            <?php

$conexion = mysqli_connect("localhost", "root", "root", "concesionario");
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}


$sql = "select id_alquiler, id_coche, prestado, devuelto from alquileres";
$consulta = mysqli_query($conexion, $sql);
?>

<form method="POST" action="borrar.php">
    <table>
        <tr>
            <th>Seleccionar</th>
            <th>ID Alquiler</th>
            <th>ID Coche</th>
            <th>Fecha Prestado</th>
            <th>Fecha Devuelto</th>
        </tr>

        <?php
       
        while ($row = mysqli_fetch_assoc($consulta)) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='alquileres[]' value='".$row['id_alquiler']."'></td>";
            echo "<td>".$row['id_alquiler']."</td>";
            echo "<td>".$row['id_coche']."</td>";
            echo "<td>".$row['prestado']."</td>";
            echo "<td>".$row['devuelto']."</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <br>
    <input type="submit" name="borrar" value="Borrar alquileres seleccionados">
</form>

<?php

if (isset($_POST['borrar']) && isset($_POST['alquileres'])) {
    
    $ids_alquileres = $_POST['alquileres'];

    foreach ($ids_alquileres as $id_alquiler) {
        // Eliminar alquiler
        $sql_delete = "DELETE FROM alquileres WHERE id_alquiler = $id_alquiler";
        if (mysqli_query($conexion, $sql_delete)) {
            echo "Alquiler con ID $id_alquiler eliminado correctamente.<br>";
        } 
        else {
            echo "Error al eliminar el alquiler con ID $id_alquiler: " . mysqli_error($conexion) . "<br>";
        }
    }
}


mysqli_close($conexion);
?>


        </main>
        <footer class="footer">
            <p> © 2024. All rights reserved.</p>
        </footer>
	</body>
</html>
