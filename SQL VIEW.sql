CREATE VIEW resumen_pedidos AS SELECT 
    p.id AS id_pedido,
    u.nombre_completo AS nombre_cliente,
    u.mail AS email_cliente,
    prod.nombre AS producto,
    prod.categoria AS categoria_producto,
    p.cantidad_producto AS cantidad,
    prod.precio AS precio_uni,
    (p.cantidad_producto * prod.precio) AS total_pedido,
    p.fecha AS fecha_pedido
FROM pedidos p
INNER JOIN clientes c ON p.id_cliente = c.id
INNER JOIN usuarios u ON c.id_usuario = u.id
INNER JOIN productos prod ON p.id_producto = prod.id;

