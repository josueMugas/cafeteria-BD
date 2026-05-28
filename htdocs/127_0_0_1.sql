-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2026 a las 21:11:24
-- Versión del servidor: 8.0.33
-- Versión de PHP: 8.2.12

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
  `id_cliente` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `fondos` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_usuario`, `fondos`) VALUES
(1, 1, 50000.00),
(2, 3, 50000.00),
(3, 5, 50000.00),
(6, 7, 50000.00),
(10, 11, 9997969.00),
(12, 13, 50000.00),
(13, 14, 0.00),
(14, 15, 0.00),
(16, 17, 0.00),
(17, 18, 6200.00),
(18, 19, 0.00),
(19, 20, 0.00),
(20, 21, 0.00),
(21, 22, 9963240.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id_empleado` int NOT NULL,
  `id_usuario` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_usuario`) VALUES
(1, 2),
(2, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad_producto` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `id_producto`, `fecha`, `cantidad_producto`) VALUES
(1, 1, 1, '2024-04-20', 2),
(2, 3, 4, '2024-04-21', 1),
(3, 5, 3, '2024-04-22', 3),
(4, 1, 2, '2024-04-25', 1),
(5, 11, 1, '2026-05-10', 3),
(6, 11, 1, '2026-05-10', 1),
(7, 11, 2, '2026-05-10', 2),
(8, 11, 1, '2026-05-10', 1),
(9, 11, 1, '2026-05-10', 1),
(10, 11, 2, '2026-05-10', 1),
(11, 11, 3, '2026-05-10', 1),
(12, 11, 2, '2026-05-10', 1),
(13, 11, 2, '2026-05-10', 1),
(14, 11, 1, '2026-05-10', 1),
(15, 11, 3, '2026-05-10', 1),
(16, 18, 3, '2026-05-28', 2),
(17, 18, 2, '2026-05-28', 1),
(18, 22, 1, '2026-05-28', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id_producto` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `IMG` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `cantidad`, `precio`, `IMG`, `categoria`) VALUES
(1, 'Americano', 200, 2600.00, 'americano.webp', 'Café'),
(2, 'Cappuccino', 200, 3200.00, 'capu.jpg', 'Café'),
(3, 'Medialuna de manteca', 200, 1100.00, 'man.jpg', 'Pastelería'),
(4, 'Tostado de Jamón y Queso', 100, 4500.00, 'tos.webp', 'Salado'),
(5, 'Muffin de Arándanos', 2500, 1200.00, 'muf.webp', 'Pastelería'),
(22, 'Espresso', 200, 2400.00, 'espresso-2.jpg', 'Café'),
(23, 'Latte', 200, 3100.00, 'lat.webp', 'Café'),
(24, 'Iced Latte', 200, 3300.00, 'ice.webp', 'Café'),
(25, 'Macchiato', 200, 2700.00, 'mac.webp', 'Café'),
(26, 'Exprimido de naranja', 200, 2900.00, 'nara.jpg', 'Bebidas'),
(27, 'Limonada', 200, 2400.00, 'limo.jpg', 'Bebidas'),
(28, 'Té', 200, 2000.00, 'te.jpg', 'Bebidas'),
(29, 'Chipá', 300, 2200.00, 'chip.jpg', 'Salado'),
(30, 'Avocado Toast', 200, 5400.00, 'avo.webp', 'Salado'),
(31, 'Medialuna de grasa', 100, 1100.00, 'gra.jpg', 'Salado'),
(32, 'Tostado de Árabe', 210, 4999.00, 'ara.jpg', 'Salado'),
(33, 'Medialuna JYQ', 322, 1600.00, 'me.jpg', 'Salado'),
(34, 'Cookie con Chips', 120, 1800.00, 'chips.avif', 'Pasteleria'),
(35, 'Brownie con Nueces (Porción)', 230, 3200.00, 'beo.webp', 'Pasteleria'),
(36, 'Queque Chocolate (Porción)', 541, 3500.00, 'quecho.jpg', 'Pasteleria'),
(37, 'Queque de Vainilla (Porción)', 125, 3400.00, 'qeuva.jpg', 'Pasteleria'),
(39, 'Chocotorta (Porcion)', 545, 2400.00, 'choco.avif', 'Pasteleria'),
(40, 'Queque Lechoso (Porción)', 321, 3800.00, 'queque_lechoso.jpg', 'Pasteleria'),
(41, 'Alfajor de Maicena', 321, 1900.00, 'alfam.jpg', 'Pasteleria'),
(42, 'Cheesecake (Porción)', 541, 3800.00, 'chee.jpg', 'Pasteleria'),
(43, 'Queque Volcánico con Frutos del Bosque (Porción)', 4552, 7000.00, 'volca.avif', 'Pasteleria'),
(44, 'Mega Queque Final Dorado 24QLT (Entero)', 1, 99999999.00, 'dios', 'Pasteleria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

DROP TABLE IF EXISTS `reseñas`;
CREATE TABLE `reseñas` (
  `id_reseña` int NOT NULL,
  `id_usuario` int DEFAULT NULL,
  `reseña` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `reseñas`
--

INSERT INTO `reseñas` (`id_reseña`, `id_usuario`, `reseña`, `fecha`) VALUES
(1, 1, 'El espresso tiene un aroma increíble, muy recomendado.', '2024-04-20'),
(2, 3, 'El tostado llegó un poco frío, pero el sabor era bueno.', '2024-04-21'),
(3, 5, '¡Las mejores medialunas del barrio!', '2024-04-23'),
(4, 11, 'asdasdasd', NULL),
(5, 11, 'asdasdasd', '2026-05-11'),
(6, 18, 'muy bueno', '2026-05-28'),
(7, 22, 'jksadjkhasdjkhasdajkhasdjhsadjkhasdajhsadjhasdjkh', '2026-05-28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mail` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contraseña` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `domicilio` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Rol` varchar(11) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `mail`, `contraseña`, `domicilio`, `Rol`) VALUES
(1, 'Juan', 'juan.perez@email.com', '1234', 'Av. Siempreviva 123', 'Cliente'),
(2, 'María', 'maria.g@email.com', 'admin789', 'Calle Falsa 456', 'Cliente'),
(3, 'Carlos', 'carlos.l@email.com', 'pass111', 'Ruta 9 Km 20', 'Cliente'),
(4, 'Ana', 'ana.t@email.com', 'ana2024', 'Boulevard Central 789', 'Cliente'),
(5, 'Lucía', 'lucia.g@email.com', 'lucia_psw', 'Pasaje Olivos 12', 'Cliente'),
(7, 'asdasda', 'asd@asd.com', 'asdd', 'quesada 2286', 'Cliente'),
(11, 'asdasda', 'josue.mugaset32@gmail.com', '$2y$10$KidZWrb.pyHQcki4wxH6BuGY/V559Lw0EjLVply0QrcYEIerq.MtS', 'quesada 2286', 'Admin'),
(13, 'asdasda', 'josue1.mugaset32@gmail.com', '$2y$10$pWSd4fYQIJKHx215pyu8iOCLhD4RwLatYRsk7wHVaebuSCdIUgkI6', 'quesada 2286', 'Cliente'),
(14, 'asdasda', 'josue3.mugaset32@gmail.com', '$2y$10$V0cCx.mD9CCG6r4lQwD5hueAY9pLopT/GtBQOaKkiNyKa5puxnb4K', 'quesada 2286', 'Cliente'),
(15, 'asdasda', 'josue4.mugaset32@gmail.com', '$2y$10$Zd/rwIG2XXAQpCs/ORKfiOc8PdMcdvscLWTnalqjLEHLaBnGvbfbm', 'quesada 2286', 'Cliente'),
(17, 'asdasda', 'mugasjosue07@gmail.com', '$2y$10$fLNc2rObXqOMFgiW0BKFGOd0i9j/rgdLcj5pMHTNHtEwtyKgNz4UW', 'quesada 2286', 'Cliente'),
(18, 'matias', 'mati@gmail.com', '$2y$10$jUX0xJ5xLkkkEz1gy/MlaOXgq0x1QjsTcnFERE0wCyXEua0j/8DpC', 'cava', 'Cliente'),
(19, 'matias', 'supermati@gmail.com', '$2y$10$YmaIXoIhKOxN6KWUGkP5oevWOx0jE5J0adpy1SbRK3zb034Su3JIG', 'cava', 'Admin'),
(20, 'matias12', 'mat12i@gmail.com', '$2y$10$AbJehMTn5WO2SVnmsdENROv4IVTFze0WDruGr4iZ8.RQCuCfYrJJy', 'cava', 'Cliente'),
(21, 'matias12', 'supermati1@gmail.com', '$2y$10$4EBYyIwFJFgv75udPwlTi.Yq7PQriNoxanO/Wbrm7oDY6cVap00/W', 'cava', 'Cliente'),
(22, '113232', 'a@gmail.com', '$2y$10$/iH0SgCidafTM4WJAat71OuJwHbN8NLUlNtKreXFFo9.VM/DvXVm6', '32331', 'Cliente');

--
-- Disparadores `usuarios`
--
DROP TRIGGER IF EXISTS `usuario_ins`;
DELIMITER $$
CREATE TRIGGER `usuario_ins` AFTER INSERT ON `usuarios` FOR EACH ROW BEGIN
    INSERT INTO clientes (id_usuario, fondos) 
    VALUES (NEW.id_usuario, 0.00);
END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id_reseña`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id_reseña` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `reseñas`
--
ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
