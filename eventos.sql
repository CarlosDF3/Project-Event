-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-04-2026 a las 19:06:35
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `event`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(200) NOT NULL,
  `nomevent` varchar(50) NOT NULL,
  `categoria` varchar(25) NOT NULL,
  `fecha` date NOT NULL,
  `localizacion` varchar(50) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `imagen` varchar(200) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `max_asistentes` int(10) UNSIGNED DEFAULT NULL,
  `entrada` enum('gratis','pago') NOT NULL DEFAULT 'gratis',
  `usuario_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `nomevent`, `categoria`, `fecha`, `localizacion`, `descripcion`, `imagen`, `usuario`, `correo`, `max_asistentes`, `entrada`, `usuario_id`) VALUES
(32, 'Ruta de senderismo por el Val D\'Aran', 'viajes', '2023-05-26', 'Circuito de los 7 lagos de Colomèrs.', 'Estamos haciendo una quedada para hacer esta ruta increíble de senderismo. Somos 5 amigos y querríamos que mas gente se apuntase.', 'Imagenes/senderismo.jpg', 'event', '', NULL, 'gratis', NULL),
(33, 'Fiesta en la playa', 'conciertos', '2023-06-05', 'Playa de Mareas en Alicante', 'Estamos montando una fiesta con equipos de música y DJ. Hay que pagar una pequeña entrada, pero esperamos que se una mucha gente.', 'Imagenes/viva_el_rave.jpg', 'Ana', '', NULL, 'gratis', NULL),
(34, 'Mundial de Resistencia de Karts', 'deportes', '2023-04-27', 'Circuito de Fuensalida, Toledo.', 'Estamos montando un evento de karts, cada uno debe pagar su entrada. Pero necesitamos ser mínimo 20 personas.', 'Imagenes/karts.jpg', 'event', '', NULL, 'gratis', NULL),
(35, 'Pachanga de Baloncesto', 'deportes', '2023-04-21', 'Polideportivo de Móstoles', 'Estamos montando un torneíllo de baloncesto. Buscamos mas gente para el evento y luego publicaríamos los días de partido.', 'Imagenes/baloncesto.jpg', 'Fran', '', NULL, 'gratis', NULL),
(36, 'Turismo por Santiago de Compostela', 'viajes', '2023-04-30', 'Santiago de Compostela', 'Una amigas y yo vamos a hacer un viaje a Santiago y buscamos gente de allí que nos quiera enseñar la ciudad.', 'Imagenes/santiago-de-compostela.jpg', 'Helena', '', NULL, 'gratis', NULL),
(41, 'Free Tour por el casco viejo de Toledo', 'cultura', '2026-04-23', 'Plaza Zocodover, calle del comercio nº21', 'El Free Tour de Toledo empieza todos los días en la Plaza de Zocodover y es la mejor introducción a la ciudad y su historia.  Toledo es conocida como la Ciudad de las tres culturas. Una maravillosa mezcla de tres de las más importantes civilizaciones que ', 'Imagenes/back3.jpg', 'Juan', '', NULL, 'gratis', NULL),
(42, 'Ciclismo de montaña', 'deportes', '2026-04-25', 'Gerona', 'Estamos buscando gente para formar un grupo para hacer ciclismo en la montaña', 'Imagenes/imagen7.jpg', 'Carlos', '', NULL, 'gratis', NULL),
(45, 'Macro Fiesta Festival', 'otros', '2026-04-30', 'Asturias', 'Macro concierto en la playa de el pueblo de asturias de cangas de onis', 'Imagenes/viva_el_rave.jpg', 'Carlos', '', NULL, 'pago', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario` (`usuario_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
