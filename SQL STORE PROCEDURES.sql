DELIMITER //

-- 1. Recibe usuario, producto y cantidad. Registra el pedido y descuenta el stock (Obsoleto).
/*
CREATE PROCEDURE RegistrarPedido(IN p_id_usuario INT, IN p_id_producto INT, IN producto_cantidad INT)
BEGIN
    INSERT INTO pedidos (id_usuario, id_producto, fecha, cantidad_producto)
    VALUES (p_id_usuario, p_id_producto, CURDATE(), producto_cantidad);

    UPDATE productos SET cantidad = cantidad - producto_cantidad 
    WHERE id_producto = p_id_producto;
END //

DELIMITER //
*/
    
-- 2. Recibe el ID de un producto y el nuevo precio. Lo actualiza.
CREATE PROCEDURE ActualizarPrecio(IN p_id_prod INT, IN p_nuevo_precio DECIMAL(10,2))
BEGIN
    UPDATE productos SET precio = p_nuevo_precio
    WHERE id_producto = p_id_prod;
END //

DELIMITER //

-- 3. Recibe el ID de un usuario y muestra su historial de pedidos.
CREATE PROCEDURE ConsultarHistorialCliente(IN p_id_usuario INT)
BEGIN
    SELECT * FROM pedidos
    WHERE id_usuario = p_id_usuario;
END //

DELIMITER //

-- 4. Recibe el ID de un producto y devuelve su nombre y precio.
CREATE PROCEDURE ObtenerInfoProducto(IN p_id_producto INT)
BEGIN
    SELECT nombre, precio FROM productos
    WHERE id_producto = p_id_producto;
END //

DELIMITER //

-- 5- Recibe los datos de una persona y los guarda en la tabla clientes.
DELIMITER //
CREATE PROCEDURE InsertarCliente(c_nom VARCHAR(50), c_ape VARCHAR(50), c_mail VARCHAR(50), c_contra VARCHAR(50), c_dom VARCHAR(50))
BEGIN
    INSERT INTO usuarios (nombre, apellido, mail, contraseña, domicilio) 
    VALUES (c_nom, c_ape, c_mail, c_contra, c_dom);

    INSERT INTO clientes (id_usuario) 
    VALUES ((SELECT id_usuario FROM usuarios WHERE mail = c_mail));

    INSERT INTO cartera (id_usuario, saldo) 
    VALUES ((SELECT id_usuario FROM usuarios WHERE mail = c_mail), 0.00);
END //
DELIMITER //

