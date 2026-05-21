DELIMITER //

CREATE PROCEDURE `Registrar_Compra`(
    IN p_id_usuario INT,
    IN p_id_producto INT,
    IN p_cantidad INT
)
BEGIN
    START TRANSACTION;
    
    IF NOT EXISTS (
        SELECT * FROM productos 
        WHERE id_producto = p_id_producto AND cantidad >= p_cantidad
    ) THEN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stock insuficiente.';

    ELSEIF NOT EXISTS (
        SELECT * FROM clientes c
        JOIN productos p ON p.id_producto = p_id_producto
        WHERE c.id_usuario = p_id_usuario AND c.fondos >= (p.precio * p_cantidad)
    ) THEN
        ROLLBACK;
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Saldo insuficiente.';

    ELSE
        UPDATE productos 
        SET cantidad = cantidad - p_cantidad 
        WHERE id_producto = p_id_producto;

        UPDATE clientes c
        JOIN productos p ON p.id_producto = p_id_producto
        SET c.fondos = c.fondos - (p.precio * p_cantidad)
        WHERE c.id_usuario = p_id_usuario;

        INSERT INTO pedidos (id_usuario, id_producto, fecha, cantidad_producto) 
        VALUES (p_id_usuario, p_id_producto, CURDATE(), p_cantidad);
        
        COMMIT;
    END IF;
END //
DELIMITER //
