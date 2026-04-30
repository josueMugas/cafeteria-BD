<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería - Registro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="sa.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center mb-4">☕ Nuevo Cliente</h2>
                <form action="insertar.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej. Pedro Pérez" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control" placeholder="juan@ejemplo.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contraseña</label>
                        <input type="password" name="pass" class="form-control" placeholder="password1234" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Domicilio</label>
                        <input type="text" name="domicilio" class="form-control" placeholder="Dirección de entrega" required>
                    </div>
                    <button type="submit">Registrar y Ver Menú</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>