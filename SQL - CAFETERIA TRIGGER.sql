DELIMITER //

CREATE TRIGGER usuario_ins
AFTER INSERT ON usuarios
FOR EACH ROW
BEGIN
    INSERT INTO clientes (id_usuario) 
    VALUES (NEW.id_usuario);
END //

DELIMITER //