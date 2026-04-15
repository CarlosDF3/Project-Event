-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-04-2026 a las 11:09:32
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
(45, 'Macro Fiesta Festival', 'otros', '2026-04-30', 'Asturias', 'Macro concierto en la playa de el pueblo de asturias de cangas de onis', 'Imagenes/viva_el_rave.jpg', 'Carlos', '', NULL, 'pago', NULL),
(46, 'Prueba', 'viajes', '2026-04-29', 'Francia', 'Viaje a Francia', 'Imagenes/cultura.jpg', '', '', 0, 'gratis', 13),
(53, 'Quedada en el retiro', 'otros', '2026-04-14', 'Madrid, Parque del retiro', 'Quedada', 'Imagenes/imagen5.jpg', '', '', NULL, 'gratis', 13),
(54, 'Viaje a china', 'viajes', '2026-06-30', 'Beijin', 'Estamos realizando un viaje a china', 'Imagenes/1776097095_china_montana.jpg', '', '', 4, '', 16),
(57, 'Rutas de senderismo de Ordesa', 'viajes', '2026-04-25', 'Huesca', 'Vamos a realizar rutas de senderismo con un grupo de amigos y buscamos gente que quiera apuntarse.', 'Imagenes/1776158224_senderismo.jpg', '', '', 0, 'gratis', 17),
(58, 'Torneo de Karting', 'deportes', '2026-04-25', 'Toledo, Fuensalida', 'Estamos preparando un pequeño torneo un grupo de personas que disfrutamos del karting.', 'Imagenes/1776161444_karts.jpg', '', '', 15, 'pago', 16);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `join_event`
--

CREATE TABLE `join_event` (
  `id_evento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `join_action` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `join_event`
--

INSERT INTO `join_event` (`id_evento`, `id_usuario`, `join_action`) VALUES
(0, 13, 'unirse'),
(23, 4, 'unirse'),
(23, 6, 'unirse'),
(23, 8, 'unirse'),
(23, 9, 'unirse'),
(27, 3, 'unirse'),
(27, 5, 'unirse'),
(27, 6, 'unirse'),
(27, 14, 'unirse'),
(29, 14, 'unirse'),
(30, 3, 'unirse'),
(30, 8, 'unirse'),
(30, 9, 'unirse'),
(30, 14, 'unirse'),
(31, 5, 'unirse'),
(31, 6, 'unirse'),
(31, 8, 'unirse'),
(31, 9, 'unirse'),
(31, 14, 'unirse'),
(32, 14, 'unirse'),
(33, 5, 'unirse'),
(33, 6, 'unirse'),
(33, 8, 'unirse'),
(33, 9, 'unirse'),
(33, 13, 'unirse'),
(33, 14, 'unirse'),
(34, 3, 'unirse'),
(34, 6, 'unirse'),
(34, 13, 'unirse'),
(34, 14, 'unirse'),
(35, 13, 'unirse'),
(35, 14, 'unirse'),
(36, 3, 'unirse'),
(36, 4, 'unirse'),
(36, 5, 'unirse'),
(36, 6, 'unirse'),
(36, 8, 'unirse'),
(36, 13, 'unirse'),
(36, 14, 'unirse'),
(38, 3, 'unirse'),
(38, 4, 'unirse'),
(38, 5, 'unirse'),
(38, 6, 'unirse'),
(38, 13, 'unirse'),
(40, 13, 'unirse'),
(41, 7, 'unirse'),
(41, 13, 'unirse'),
(41, 14, 'unirse'),
(42, 13, 'unirse'),
(42, 14, 'unirse'),
(45, 13, 'unirse'),
(46, 4, 'unirse'),
(46, 16, 'unirse'),
(46, 17, 'unirse'),
(48, 4, 'unirse'),
(48, 16, 'unirse'),
(48, 17, 'unirse'),
(53, 16, 'unirse'),
(54, 16, 'unirse'),
(57, 17, 'unirse');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `contraseña` varchar(60) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `fecha` date NOT NULL,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuario_id`, `contraseña`, `correo`, `nombre`, `fecha`, `imagen`) VALUES
(8, '123', 'ana2@gmail.com', 'Ana', '2023-04-16', NULL),
(9, '123', 'Fran@hotmail.com', 'Fran', '2023-04-17', NULL),
(10, '123', 'Helena@gmail.com', 'Helena', '2023-04-17', NULL),
(13, '123', 'carlos@ifp.es', 'Carlos', '2023-05-11', 'imagenes_perfil/1775834179_0_chica_de_fantasia_7_jgf_mysterious__delicate_by_josegomezfreelance_dh3mhxl-pre.jpg'),
(16, '$2y$10$9JVetBw1Zj.LtuVLkemLY.8EUQaPvXVVXFUKpWjV5AX3rFVWLRkt2', 'carlosdf@gmail.com', 'Carlos', '2026-04-13', 'imagenes_perfil/1776161044_karts.jpg'),
(17, '$2y$10$l600j0ExhtToZikwCAD0cOIDyKCB07l7m5azXZY2WmTa0K8lu/dDK', 'marta@gmail.com', 'Marta', '2026-04-14', NULL);

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
-- Indices de la tabla `join_event`
--
ALTER TABLE `join_event`
  ADD UNIQUE KEY `id_evento` (`id_evento`,`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`),
  ADD UNIQUE KEY `event_id` (`usuario_id`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`usuario_id`) ON DELETE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `Borrar_Eventos` ON SCHEDULE EVERY 1 DAY STARTS '2023-04-30 00:00:00' ON COMPLETION PRESERVE ENABLE DO DELETE FROM eventos WHERE fecha < CURDATE()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
