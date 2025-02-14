<?php
if (isset($_SESSION['usuario_id'])) {
    header('Location: tablatareas.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1 class="mb-4">Bienvenido al Gestor de Tareas</h1>
                <a href="registro.php" class="btn btn-primary me-2">Registrarse</a>
                <a href="iniciosesion.php" class="btn btn-success">Iniciar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>