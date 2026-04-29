DROP DATABASE IF EXISTS `cafeteria`;
CREATE DATABASE `cafeteria`;
USE `cafeteria`;

CREATE TABLE `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `apellido` varchar(50) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `contraseña` varchar(50) DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
);

CREATE TABLE `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio` int DEFAULT NULL,
  `IMG` varchar(100) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_producto`)
);

CREATE TABLE `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int DEFAULT NULL,
  `id_producto` int DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cantidad_producto` int DEFAULT NULL,
  PRIMARY KEY (`id_pedido`),
FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`)
);

INSERT INTO `clientes` (`nombre`, `apellido`, `mail`, `contraseña`, `domicilio`) VALUES
('Carlos', 'Gómez', 'carlos.g@mail.com', 'pass101', 'Av. Rivadavia 1234'),
('Ana', 'Martínez', 'ana_mtz@mail.com', 'secure202', 'Calle Corrientes 567'),
('Luis', 'Rodríguez', 'luis.ro@mail.com', 'lucho303', 'Belgrano 890'),
('Sofía', 'López', 'sofi.lopez@mail.com', 'sof404', 'Santa Fe 2100'),
('Diego', 'Fernández', 'diego.f@mail.com', 'df505', 'Pueyrredón 432'),
('Lucía', 'Sánchez', 'lucia.s@mail.com', 'luc606', 'Maipú 765'),
('Marcos', 'Pérez', 'marcos.p@mail.com', 'm707', 'Florida 101'),
('Elena', 'Díaz', 'elena.d@mail.com', 'ed808', 'San Martín 333'),
('Javier', 'Torres', 'javi.t@mail.com', 'jt909', 'Alberdi 1500'),
('Valeria', 'Ruiz', 'vale.ruiz@mail.com', 'vr000', 'Libertador 4500');

INSERT INTO `productos` (`nombre`, `cantidad`, `precio`, `IMG`, `categoria`) VALUES
('Café Espresso', 100, 1500, NULL, NULL),
('Medialuna Manteca', 200, 450, NULL, NULL),
('Capuchino', 80, 1800, NULL, NULL),
('Tostado Jamón y Queso', 50, 3200, NULL, NULL),
('Muffin Arándanos', 40, 1200, NULL, NULL),
('Té en Hebras', 60, 1100, NULL, NULL),
('Jugo de Naranja', 30, 1600, NULL, NULL),
('Alfajor de Maicena', 100, 900, NULL, NULL),
('Cheesecake', 15, 4500, NULL, NULL),
('Café Latte', 90, 1700, NULL, NULL);

INSERT INTO `pedidos` (`id_cliente`, `id_producto`, `fecha`, `cantidad_producto`) VALUES
(1, 1, '2024-05-21', 1),
(2, 2, '2024-05-21', 6),
(3, 4, '2024-05-21', 1),
(4, 3, '2024-05-22', 2),
(5, 5, '2024-05-22', 4),
(6, 8, '2024-05-23', 2),
(7, 10, '2024-05-23', 1),
(8, 2, '2024-05-24', 12),
(9, 6, '2024-05-24', 1),
(10, 9, '2024-05-24', 2);


/*
--------------------------------------------------------------------------------
1- Recibe cliente, producto y cantidad. Registra el pedido y descuenta el stock
--------------------------------------------------------------------------------
*/

DELIMITER // 

CREATE PROCEDURE RegistrarPedido(IN p_id_cliente INT, p_id_producto INT, IN producto_cantidad INT)
BEGIN
	INSERT INTO pedidos (id_cliente, id_producto, fecha, cantidad_producto)
    VALUES (p_id_cliente, p_id_producto, CURDATE(), producto_cantidad);

    UPDATE productos SET cantidad = cantidad - producto_cantidad WHERE id_producto = p_id_producto;

END //

DELIMITER // 

/*
-----------------------------------------------------------------------
2- Recibe el ID de un producto y el nuevo precio. Lo actualiza y listo.
-----------------------------------------------------------------------
*/

DELIMITER // 

CREATE PROCEDURE ActualizarPrecio(IN p_id_prod INT, IN p_nuevo_precio INT)
BEGIN
	UPDATE productos SET precio = p_nuevo_precio
	WHERE id_producto = p_id_prod;
END //

DELIMITER // 

/*
------------------------------------------------------------
3- Recibe el ID de un cliente y muestra qué compró y cuándo.
------------------------------------------------------------
*/

DELIMITER // 

CREATE PROCEDURE ConsultarHistorialCliente(IN c_id_cliente INT)
BEGIN
	SELECT * FROM pedidos 
    WHERE id_cliente = c_id_cliente;
    
END //

DELIMITER // 

/*
----------------------------------------------------------------
4- Recibe el ID de un producto y te devuelve su nombre y precio.
----------------------------------------------------------------
*/

DELIMITER // 

CREATE PROCEDURE ObtenerInfoProducto(IN p_id_producto INT)
BEGIN
	SELECT nombre, precio FROM productos 
    WHERE id_producto = p_id_producto;
    
END //

DELIMITER // 

/*
---------------------------------------------------------------------
5- Recibe los datos de una persona y los guarda en la tabla clientes.
---------------------------------------------------------------------
*/

DELIMITER // 

CREATE PROCEDURE InsertarCliente(IN c_nom VARCHAR(50), IN c_ape VARCHAR(50), IN c_mail VARCHAR(50), IN c_contra VARCHAR(50), c_dom VARCHAR(50))
BEGIN
    INSERT INTO clientes (nombre, apellido, mail, contraseña, domicilio) 
    VALUES (c_nom, c_ape, c_mail, c_contra, c_dom);
END //

DELIMITER // 
