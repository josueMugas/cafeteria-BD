DROP DATABASE IF EXISTS `cafeteria`;
CREATE DATABASE `cafeteria`;
USE `cafeteria`;

-- 1. TABLA USUARIOS
CREATE TABLE `usuarios` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `mail` varchar(50) UNIQUE DEFAULT NULL,
  `contraseña` varchar(50) DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
);

-- 2. TABLA CLIENTES
CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_cliente`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

-- 3. TABLA EMPLEADOS
CREATE TABLE `empleados` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id_empleado`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

-- 4. TABLA PRODUCTOS
CREATE TABLE `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `IMG` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
);

-- 5. TABLA PEDIDOS
CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad_producto` int DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
  FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
 FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

-- 6. TABLA RESEÑAS
CREATE TABLE `reseñas` (
  `id_reseña` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `texto` VARCHAR(200) DEFAULT NULL,
  `fecha` DATE,
  PRIMARY KEY (`id_reseña`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`)
);

USE `cafeteria`;

-- 1. INSERTAR USUARIOS
INSERT INTO `usuarios` (`nombre`, `apellido`, `mail`, `contraseña`, `domicilio`) VALUES
('Juan', 'Pérez', 'juan.perez@email.com', '1234', 'Av. Siempreviva 123'),
('María', 'García', 'maria.g@email.com', 'admin789', 'Calle Falsa 456'),
('Carlos', 'López', 'carlos.l@email.com', 'pass111', 'Ruta 9 Km 20'),
('Ana', 'Torres', 'ana.t@email.com', 'ana2024', 'Boulevard Central 789'),
('Lucía', 'Gómez', 'lucia.g@email.com', 'lucia_psw', 'Pasaje Olivos 12');

-- 2. INSERTAR CLIENTES
INSERT INTO `clientes` (`id_usuario`) VALUES (1), (3), (5);

-- 3. INSERTAR EMPLEADOS
INSERT INTO `empleados` (`id_usuario`) VALUES (2), (4);

-- 4. INSERTAR PRODUCTOS
INSERT INTO `productos` (`nombre`, `cantidad`, `precio`, `IMG`, `categoria`) VALUES
('Espresso', 100, 1500.00, 'espresso.jpg', 'Café'),
('Cappuccino', 80, 2200.00, 'cappuccino.png', 'Café'),
('Medialuna de manteca', 50, 800.00, 'medialuna.jpg', 'Pastelería'),
('Tostado de Jamón y Queso', 30, 3500.00, 'tostado.jpg', 'Salado'),
('Muffin de Arándanos', 20, 1200.00, 'muffin.jpg', 'Pastelería');

-- 5. INSERTAR PEDIDOS
INSERT INTO `pedidos` (`id_usuario`, `id_producto`, `fecha`, `cantidad_producto`) VALUES
(1, 1, '2024-04-20', 2),
(3, 4, '2024-04-21', 1),
(5, 3, '2024-04-22', 3),
(1, 2, '2024-04-25', 1);

-- 6. INSERTAR RESEÑAS
INSERT INTO `reseñas` (`id_usuario`, `texto`, `fecha`) VALUES
(1, 'El espresso tiene un aroma increíble, muy recomendado.', '2024-04-20'),
(3, 'El tostado llegó un poco frío, pero el sabor era bueno.', '2024-04-21'),
(5, '¡Las mejores medialunas del barrio!', '2024-04-23');
