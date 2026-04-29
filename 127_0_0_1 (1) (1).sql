-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-04-2026 a las 20:38:42
-- Versión del servidor: 8.0.33
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cafeteria`
--
DROP DATABASE IF EXISTS `cafeteria`;
CREATE DATABASE IF NOT EXISTS `cafeteria` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cafeteria`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE `clientes` (
  `id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contraseña` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `domicilio` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `mail`, `contraseña`, `domicilio`) VALUES
(1, 'Carlos', 'Gómez', 'carlos.g@mail.com', 'pass101', 'Av. Rivadavia 1234'),
(2, 'Ana', 'Martínez', 'ana_mtz@mail.com', 'secure202', 'Calle Corrientes 567'),
(3, 'Luis', 'Rodríguez', 'luis.ro@mail.com', 'lucho303', 'Belgrano 890'),
(4, 'Sofía', 'López', 'sofi.lopez@mail.com', 'sof404', 'Santa Fe 2100'),
(5, 'Diego', 'Fernández', 'diego.f@mail.com', 'df505', 'Pueyrredón 432'),
(6, 'Lucía', 'Sánchez', 'lucia.s@mail.com', 'luc606', 'Maipú 765'),
(7, 'Marcos', 'Pérez', 'marcos.p@mail.com', 'm707', 'Florida 101'),
(8, 'Elena', 'Díaz', 'elena.d@mail.com', 'ed808', 'San Martín 333'),
(9, 'Javier', 'Torres', 'javi.t@mail.com', 'jt909', 'Alberdi 1500'),
(10, 'Valeria', 'Ruiz', 'vale.ruiz@mail.com', 'vr000', 'Libertador 4500');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id` int NOT NULL,
  `id_cliente` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad_producto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_cliente`, `id_producto`, `fecha`, `cantidad_producto`) VALUES
(1, 1, 1, '2024-05-21', 1),
(2, 2, 2, '2024-05-21', 6),
(3, 3, 4, '2024-05-21', 1),
(4, 4, 3, '2024-05-22', 2),
(5, 5, 5, '2024-05-22', 4),
(6, 6, 8, '2024-05-23', 2),
(7, 7, 10, '2024-05-23', 1),
(8, 8, 2, '2024-05-24', 12),
(9, 9, 6, '2024-05-24', 1),
(10, 10, 9, '2024-05-24', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` int DEFAULT NULL,
  `IMG` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `cantidad`, `precio`, `IMG`, `categoria`) VALUES
(1, 'Café Espresso', 100, 1500, NULL, NULL),
(2, 'Medialuna Manteca', 200, 450, NULL, NULL),
(3, 'Capuchino', 80, 1800, NULL, NULL),
(4, 'Tostado Jamón y Queso', 50, 3200, NULL, NULL),
(5, 'Muffin Arándanos', 40, 1200, NULL, NULL),
(6, 'Té en Hebras', 60, 1100, NULL, NULL),
(7, 'Jugo de Naranja', 30, 1600, NULL, NULL),
(8, 'Alfajor de Maicena', 100, 900, NULL, NULL),
(9, 'Cheesecake', 15, 4500, NULL, NULL),
(10, 'Café Latte', 90, 1700, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ingrediente` (`id_producto`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
