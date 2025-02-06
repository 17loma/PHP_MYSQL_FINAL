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

        $sql = "select 
                    alquileres.id_alquiler, 
                    coches.modelo AS coche_modelo, 
                    alquileres.prestado
                from alquileres
                join coches on alquileres.id_coche = coches.id_coche";

        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>
                    <tr>
                        <th>ID Alquiler</th>
                        <th>Coche Modelo</th>
                        <th>Fecha Prestado</th>
                        
                    </tr>";
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>" . $row['id_alquiler'] . "</td>
                        <td>" . $row['coche_modelo'] . "</td>
                        <td>" . $row['prestado'] . "</td>
                        
                    </tr>";
            }

            echo "</table>";
        } 
        else {
            echo "No hay alquileres registrados.";
        }

        mysqli_close($conexion);
        ?>
        </main>
        <footer class="footer">
            <p> © 2024. All rights reserved.</p>
        </footer>
	</body>
</html>