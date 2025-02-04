<?php
require_once 'class_conexion.php';
require_once 'usuarios_controller.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuarioController = new UsuariosController();
    $usuario = $usuarioController->obtenerUsuarioPorId($id);

    if ($usuario) {
        // Calcular el costo desglosado
        $costo_base = $usuarioController->getCostoBase($usuario['plan_base']);
        $paquetes = json_decode($usuario['paquetes'], true);
        $costo_paquetes = $usuarioController->getCostoPaquetes($paquetes);
        $costo_total = $costo_base + $costo_paquetes;
    } else {
        echo "Usuario no encontrado.";
        exit;
    }
} else {
    echo "ID de usuario no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h1 class="mb-4 text-center">Detalles del Usuario</h1>
        <ul class="list-group mb-3">
            <li class="list-group-item"><strong>Nombre:</strong> <?php echo $usuario['nombre']; ?></li>
            <li class="list-group-item"><strong>Apellidos:</strong> <?php echo $usuario['apellidos']; ?></li>
            <li class="list-group-item"><strong>Correo:</strong> <?php echo $usuario['correo']; ?></li>
            <li class="list-group-item"><strong>Edad:</strong> <?php echo $usuario['edad']; ?></li>
            <li class="list-group-item"><strong>Plan Base:</strong> <?php echo $usuario['plan_base']; ?> ($<?php echo number_format($costo_base, 2); ?>)</li>
        </ul>
        <h5>Paquetes Adicionales:</h5>
        <ul class="list-group mb-3">
            <?php
            if (!empty($paquetes)) {
                foreach ($paquetes as $paquete) {
                    $costo_paquete = $usuarioController->getCostoPaquetes([$paquete]);
                    echo "<li class='list-group-item'>$paquete ($" . number_format($costo_paquete, 2) . ")</li>";
                }
            } else {
                echo "<li class='list-group-item text-muted'>No se seleccionaron paquetes adicionales.</li>";
            }
            ?>
        </ul>
        <p class="fw-bold">Costo Total Mensual: $<?php echo number_format($costo_total, 2); ?></p>
        <a href="lista_usuarios.php" class="btn btn-primary">Volver a la lista de usuarios</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
