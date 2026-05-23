<?php
include("conexion.php");
session_start();

$carrito_vacio = !isset($_SESSION['carrito']) || empty($_SESSION['carrito']);

$total_carrito = 0;
$productos_detalle = [];

if (!$carrito_vacio) {
    foreach ($_SESSION['carrito'] as $id => $cantidad_comprar) {
        $stmtProd = mysqli_prepare($conexion, "CALL ObtenerInfoProducto(?)");
        mysqli_stmt_bind_param($stmtProd, "i", $id);
        mysqli_stmt_execute($stmtProd);
        $resProd = mysqli_stmt_get_result($stmtProd);

        if ($prod = mysqli_fetch_assoc($resProd)) {
            $subtotal = $prod['precio'] * $cantidad_comprar;
            $total_carrito += $subtotal;
            
            $productos_detalle[] = [
                'id' => $id,
                'nombre' => $prod['nombre'],
                'precio' => $prod['precio'],
                'cantidad' => $cantidad_comprar,
                'subtotal' => $subtotal
            ];
        }
        mysqli_stmt_close($stmtProd);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito de Compras</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body style="background-color: #f5f5dc; padding-top: 80px;">

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: var(--cafe-oscuro);">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">☕ Mi Cafetería</a>
        <a href="index.php" class="btn btn-outline-light btn-sm">Volver al Menú</a>
    </div>
</nav>

<div class="container p-4 rounded shadow-sm mt-4" style="max-width: 900px;">
    <h2 class="mb-4">🛒 Tu Carrito de Compras</h2>

    <?php if ($carrito_vacio): ?>
        <div class="alert alert-warning text-center my-4">
            <h5>Tu carrito está vacío</h5>
            <p>¿Qué tal si te sumás un rico café para empezar?</p>
            <a href="index.php" class="btn btn-primary mt-2">Ver el Menú</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th class="text-center">Precio Unitario</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Subtotal</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos_detalle as $item): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($item['nombre']); ?></strong></td>
                            <td class="text-center">$<?php echo number_format($item['precio'], 2); ?></td>
                            <td class="text-center">
                                <span class="badge bg-secondary p-2fs-6"><?php echo $item['cantidad']; ?></span>
                            </td>
                            <td class="text-center fw-bold">$<?php echo number_format($item['subtotal'], 2); ?></td>
                            <td class="text-center">
                                <a href="carrito.php?accion=agregar1&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-success">Sumar</a>
                                <a href="carrito.php?accion=sacar1&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning">Restar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-4 align-items-center">
            <div class="col-md-6">
                <a href="carrito.php?accion=vaciar" class="btn btn-outline-danger btn-sm">🗑️ Vaciar por completo</a>
            </div>
            <div class="col-md-6 text-end">
                <h4 class="fw-bold mb-3">Total a pagar: <span class="text-success">$<?php echo number_format($total_carrito, 2); ?></span></h4>
                
                <a href="index.php" class="btn btn-secondary me-2">Seguir Comprando</a>
                
                <?php if (isset($_SESSION['usuario'])): ?>
                    <a href="finalizar_compra.php" class="btn btn-success px-4 fw-bold">Confirmar y Pagar</a>
                <?php endif; ?>
            </div>
        </div>
        
    <?php endif; ?>  
</div>
</body>
</html>