DROP DATABASE IF EXISTS `cafeteria`;
CREATE DATABASE `cafeteria`;
USE `cafeteria`;

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `mail` varchar(50) UNIQUE DEFAULT NULL,
  `contraseña` varchar(50) DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `fondos` decimal(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
);

CREATE TABLE `empleados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
);

CREATE TABLE `productos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `IMG` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `pedidos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad_producto` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`),
  FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`)
);

CREATE TABLE `reseñas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int DEFAULT NULL,
  `texto` VARCHAR(200) DEFAULT NULL,
  `fecha` DATE,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
);

INSERT INTO `usuarios` (`nombre_completo`, `mail`, `contraseña`, `domicilio`) VALUES
('Juan Pérez', 'juan.perez@email.com', '1234', 'Av. Siempreviva 123'),
('María García', 'maria.g@email.com', 'admin789', 'Calle Falsa 456'),
('Carlos López', 'carlos.l@email.com', 'pass111', 'Ruta 9 Km 20'),
('Ana Torres', 'ana.t@email.com', 'ana2024', 'Boulevard Central 789'),
('Lucía Gómez', 'lucia.g@email.com', 'lucia_psw', 'Pasaje Olivos 12');

INSERT INTO `clientes` (`id_usuario`, `fondos`) VALUES 
(1, 5000.00), 
(3, 0.00), 
(5, 1200.50);

INSERT INTO `empleados` (`id_usuario`) VALUES (2), (4);

INSERT INTO `productos` (`nombre`, `cantidad`, `precio`, `IMG`, `categoria`) VALUES
('Espresso', 100, 1500.00, 'espresso.jpg', 'Café'),
('Cappuccino', 80, 2200.00, 'cappuccino.png', 'Café'),
('Medialuna de manteca', 50, 800.00, 'medialuna.jpg', 'Pastelería'),
('Tostado de Jamón y Queso', 30, 3500.00, 'tostado.jpg', 'Salado'),
('Muffin de Arándanos', 20, 1200.00, 'muffin.jpg', 'Pasatelería');

INSERT INTO `pedidos` (`id_cliente`, `id_producto`, `fecha`, `cantidad_producto`) VALUES
(1, 1, '2024-04-20', 2), 
(2, 4, '2024-04-21', 1), 
(3, 3, '2024-04-22', 3), 
(1, 2, '2024-04-25', 1);

INSERT INTO `reseñas` (`id_usuario`, `texto`, `fecha`) VALUES
(1, 'El espresso tiene un aroma increíble, muy recomendado.', '2024-04-20'),
(3, 'El tostado llegó un poco frío, pero el sabor era bueno.', '2024-04-21'),
(5, '¡Las mejores medialunas del barrio!', '2024-04-23');
