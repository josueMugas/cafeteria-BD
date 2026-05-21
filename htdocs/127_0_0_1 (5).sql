-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 05:12:36
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
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fondos` decimal(10,2) DEFAULT 0.00
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
(16, 17, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

DROP TABLE IF EXISTS `empleados`;
CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL
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
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad_producto` int(11) DEFAULT NULL
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
(15, 11, 3, '2026-05-10', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `IMG` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `cantidad`, `precio`, `IMG`, `categoria`) VALUES
(1, 'asd', 116, 1231.00, 'espresso-macchiato.jpg', 'Café'),
(2, 'Cappuccino', 195, 2200.00, 'capuccino.jpg', 'Café'),
(3, 'Medialuna de manteca', 198, 800.00, 'medialunas-romanas_web.jpg.webp', 'Pastelería'),
(4, 'Tostado de Jamón y Queso', 100, 3500.00, 'tostadoQJ.jpg', 'Salado'),
(5, 'Muffin de Arándanos', 80, 1200.00, 'Muffin-web.jpg', 'Pastelería');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reseñas`
--

DROP TABLE IF EXISTS `reseñas`;
CREATE TABLE `reseñas` (
  `id_reseña` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `reseña` varchar(200) DEFAULT NULL,
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
(5, 11, 'asdasdasd', '2026-05-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `Rol` varchar(11) NOT NULL DEFAULT 'Cliente'
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
(8, 'matias', 'supermati@gmail.com', '123', 'papa', 'Cliente'),
(11, 'asdasda', 'josue.mugaset32@gmail.com', '$2y$10$KidZWrb.pyHQcki4wxH6BuGY/V559Lw0EjLVply0QrcYEIerq.MtS', 'quesada 2286', 'Admin'),
(13, 'asdasda', 'josue1.mugaset32@gmail.com', '$2y$10$pWSd4fYQIJKHx215pyu8iOCLhD4RwLatYRsk7wHVaebuSCdIUgkI6', 'quesada 2286', 'Cliente'),
(14, 'asdasda', 'josue3.mugaset32@gmail.com', '$2y$10$V0cCx.mD9CCG6r4lQwD5hueAY9pLopT/GtBQOaKkiNyKa5puxnb4K', 'quesada 2286', 'Cliente'),
(15, 'asdasda', 'josue4.mugaset32@gmail.com', '$2y$10$Zd/rwIG2XXAQpCs/ORKfiOc8PdMcdvscLWTnalqjLEHLaBnGvbfbm', 'quesada 2286', 'Cliente'),
(17, 'asdasda', 'mugasjosue07@gmail.com', '$2y$10$fLNc2rObXqOMFgiW0BKFGOd0i9j/rgdLcj5pMHTNHtEwtyKgNz4UW', 'quesada 2286', 'Cliente');

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `reseñas`
--
ALTER TABLE `reseñas`
  MODIFY `id_reseña` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarProducto`(
    IN p_id_prod INT,
    IN p_nuevo_nombre VARCHAR(50),
    IN p_nuevo_precio DECIMAL(10,2),
    IN p_nueva_cantidad INT
)
BEGIN
    UPDATE productos 
    SET nombre = p_nuevo_nombre,
        precio = p_nuevo_precio,
        cantidad = p_nueva_cantidad
    WHERE id_producto = p_id_prod;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarHistorialCliente`(
    IN p_id_user INT
)
BEGIN
    SELECT p.id_pedido, p.fecha, pr.nombre AS producto, p.cantidad_producto, pr.precio
    FROM pedidos p
    INNER JOIN productos pr ON p.id_producto = pr.id_producto
    WHERE p.id_usuario = p_id_user;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarCliente`(
    IN c_nom VARCHAR(50), 
    IN c_mail VARCHAR(50), 
    IN c_contra VARCHAR(255), 
    IN c_dom VARCHAR(50)
)
BEGIN
    INSERT INTO usuarios (nombre, mail, contraseña, domicilio, Rol) 
    VALUES (c_nom, c_mail, c_contra, c_dom, 'Cliente');
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerInfoProducto`(
    IN p_id_producto INT
)
BEGIN
    SELECT nombre, precio 
    FROM productos
    WHERE id_producto = p_id_producto;
END$$
DELIMITER ;

DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `Registrar_Compra`(
    IN p_id_usuario INT,
    IN p_id_producto INT,
    IN p_cantidad INT
)
BEGIN
    DECLARE v_precio DECIMAL(10,2);
    DECLARE v_stock INT;
    DECLARE v_fondos DECIMAL(10,2);

    START TRANSACTION;
    
    -- Obtenemos datos actuales del producto
    SELECT precio, cantidad INTO v_precio, v_stock 
    FROM productos WHERE id_producto = p_id_producto;
    
    -- Obtenemos fondos del cliente
    SELECT fondos INTO v_fondos 
    FROM clientes WHERE id_usuario = p_id_usuario;

    -- Validaciones
    IF v_stock IS NULL OR v_stock < p_cantidad THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuficiente.';
    ELSEIF v_fondos IS NULL OR v_fondos < (v_precio * p_cantidad) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Saldo insuficiente.';
    ELSE
        -- Descontar stock
        UPDATE productos 
        SET cantidad = cantidad - p_cantidad 
        WHERE id_producto = p_id_producto;

        -- Descontar fondos
        UPDATE clientes 
        SET fondos = fondos - (v_precio * p_cantidad)
        WHERE id_usuario = p_id_usuario;

        -- Registrar pedido (Usamos CURDATE())
        INSERT INTO pedidos (id_usuario, id_producto, fecha, cantidad_producto) 
        VALUES (p_id_usuario, p_id_producto, CURDATE(), p_cantidad);
        
        COMMIT;
    END IF;
END$$
DELIMITER ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
