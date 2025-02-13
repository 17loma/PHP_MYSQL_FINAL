-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 13-02-2025 a las 21:24:12
-- Versión del servidor: 8.0.17
-- Versión de PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `concesionario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquileres`
--

CREATE TABLE `alquileres` (
  `id_alquiler` int(10) UNSIGNED NOT NULL,
  `id_usuario` int(10) UNSIGNED DEFAULT NULL,
  `id_coche` int(10) UNSIGNED DEFAULT NULL,
  `prestado` datetime DEFAULT NULL,
  `devuelto` datetime DEFAULT NULL,
  `fecha_devolucion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `alquileres`
--

INSERT INTO `alquileres` (`id_alquiler`, `id_usuario`, `id_coche`, `prestado`, `devuelto`, `fecha_devolucion`) VALUES
(2, 4, 20, NULL, NULL, NULL),
(6, 4, 21, '2025-02-09 17:02:19', NULL, NULL),
(9, 1, 24, '2025-02-10 00:24:09', NULL, NULL),
(12, 1, 26, '2025-02-10 10:25:10', NULL, NULL),
(13, 1, 28, '2025-02-10 10:41:31', NULL, NULL),
(16, 3, 25, '2025-02-10 11:14:51', '2025-02-10 12:17:03', '2025-02-10 12:17:03'),
(17, 3, 25, '2025-02-10 11:17:20', NULL, NULL),
(18, 3, 30, '2025-02-10 11:21:09', '2025-02-10 12:21:35', '2025-02-10 12:21:35'),
(20, 1, 34, '2025-02-10 23:16:49', NULL, NULL),
(21, 1, 35, '2025-02-11 00:34:08', '2025-02-11 08:47:19', '2025-02-11 08:47:19'),
(22, 3, 35, '2025-02-11 08:34:26', NULL, NULL),
(23, 3, 36, '2025-02-11 09:01:44', '2025-02-11 10:03:46', '2025-02-11 10:03:46'),
(24, 3, 36, '2025-02-11 09:52:04', '2025-02-13 10:43:52', '2025-02-13 10:43:52'),
(30, 8, 49, '2025-02-13 20:48:52', NULL, NULL),
(31, 8, 50, '2025-02-13 20:49:20', '2025-02-13 19:49:36', NULL),
(34, 3, 36, '2025-02-13 20:48:53', NULL, NULL),
(35, 3, 37, '2025-02-13 20:57:39', NULL, NULL),
(37, 9, 55, '2025-02-13 22:05:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `coches`
--

CREATE TABLE `coches` (
  `id_coche` int(10) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) NOT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `precio` float DEFAULT NULL,
  `alquilado` tinyint(1) DEFAULT NULL,
  `foto` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `coches`
--

INSERT INTO `coches` (`id_coche`, `id_usuario`, `modelo`, `marca`, `color`, `precio`, `alquilado`, `foto`) VALUES
(36, 0, 'GTR - R34', 'Nissan', 'Azul - Mate', 10000, 1, 'fotos/DALL·E 2025-02-11 09.41.04 - A highly detailed, realistic image of a Nissan GT-R R34 sports car. The car is parked on a scenic, urban street at sunset, with a glossy blue finish a.webp'),
(37, 0, 'R8', 'Audi', 'Blanco', 1100, 1, 'fotos/DALL·E 2025-02-11 09.42.21 - A highly detailed, realistic image of an Audi R8 sports car. The car is parked in a modern city environment at twilight, with a striking silver finish.webp'),
(38, 0, '350 - Z', 'Nissan', 'Rojo', 1200, 0, 'fotos/DALL·E 2025-02-11 09.47.25 - A highly detailed, realistic image of a classic red Nissan 350Z sports car, showcasing the vintage design of the early 2000s. The car is parked on an .webp'),
(39, 0, 'Celica', 'Toyota', 'Azul', 1100, 0, 'fotos/DALL·E 2025-02-11 09.50.18 - A highly detailed, realistic image of a Toyota Celica with a sporty, aggressive style. The car features a custom body kit with wide fenders, a lowered.webp'),
(40, 0, 'Mustang', 'Ford', 'Gris', 1500, 0, 'fotos/DALL·E 2025-02-11 09.52.19 - A highly detailed, realistic image of a Ford Mustang, with a sleek and aggressive design. The car features a custom wide-body kit, a lowered stance, a.webp'),
(41, 0, '320d - e46', 'BMW', 'Gris-Plata', 1600, 0, 'fotos/DALL·E 2025-02-11 09.54.04 - A highly detailed, realistic image of a BMW 320d E46 model. The car features a classic silver finish with clean lines and a sleek, sporty look. It has.webp'),
(42, 0, 'Clase C (2004) ', 'Mercedes-Benz ', 'Negro', 1700, 0, 'fotos/DALL·E 2025-02-11 09.56.04 - A highly detailed, realistic image of a 2004 Mercedes-Benz C-Class (W203) in a sleek black color. The car has a refined, elegant design with a well-ma.webp'),
(55, 9, '12', '12', '12', 12, 1, 'fotos/default.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(10) UNSIGNED NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(9) NOT NULL,
  `correo` varchar(150) NOT NULL,
  `tipo_usuario` enum('comprador','vendedor','admin') NOT NULL,
  `saldo` float DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `password`, `nombre`, `apellidos`, `dni`, `correo`, `tipo_usuario`, `saldo`) VALUES
(1, '$2y$10$vjfeCBqTKcxQNkEueh5Bk.CD/deJwsFiIyA2Vl75Py5.mDLspMLZG', 'Administrador', 'Supremo', '11111111A', 'admin@1.com', 'admin', 1e18),
(3, '$2y$10$Ia/Sz6M7wZzrk0gFNR65d.EIYOSsaxck1ojFZBtKpZAz4Rq50HhPu', 'Comprador', 'Compra', '33333333C', 'compra@3.com', 'comprador', 100000000),
(7, '$2y$10$/BREgU9enW2Dt7b7CfYYZ.DU3Re0dQgB1GdHBllJrSzvf1APqozfG', 'Loma', 'Loma', '02751666Q', 'loma@prueba.com', 'vendedor', 1000),
(8, '$2y$10$qQUoYff/PIzPKa.otpRi5ODBsYdICj8/PNm7dGIR6z6vbgVaqL.g2', 'vendedor', 'prueba', '99999999Z', 'vende@prueba.com', 'vendedor', 10000),
(9, '$2y$10$GPwZE8uGtYZppmbVnI6F0O3cVbhxpTjTV.oXwtcDIQvyQVHP0seb6', 'Vendedor', 'vende', '22222222B', 'vende@2.com', 'vendedor', 1000);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  ADD PRIMARY KEY (`id_alquiler`);

--
-- Indices de la tabla `coches`
--
ALTER TABLE `coches`
  ADD PRIMARY KEY (`id_coche`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `dni` (`dni`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alquileres`
--
ALTER TABLE `alquileres`
  MODIFY `id_alquiler` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `coches`
--
ALTER TABLE `coches`
  MODIFY `id_coche` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
