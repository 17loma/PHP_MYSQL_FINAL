<?php
// Detectar automáticamente la URL base en localhost
$project_folder = "/PHP/PHP_2EVAU/practica final"; // Ajusta esto según tu estructura
$base_url = "http://localhost" . $project_folder . "/";

// Definir una constante con la URL base
define("BASE_URL", rtrim($base_url, '/') . "/");
?>
