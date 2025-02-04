<?php
require_once 'class_conexion.php';
include 'usuarios_controller.php';

// Instancia de Usuario
$usuario = new UsuariosController();

// Obtener datos del usuario si se pasa un ID por GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuarioData = $usuario->obtenerUsuarioPorId($id);
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    if (!$id) {
        die("Error: ID del usuario no proporcionado.");
    }

    // Obtener los datos
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $plan_base = $_POST['plan_base'];
    $duracion = $_POST['duracion'];
    $paquetes = isset($_POST['paquetes']) ? $_POST['paquetes'] : [];

    // Editar usuario
    $usuario->editarUsuario($id, $nombre, $apellidos, $correo, $edad, $plan_base, $paquetes, $duracion);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir el archivo de validaciones -->
    <script src="validaciones.js" defer></script>
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Formulario de Edición de Usuario</h1>
    <form method="POST" class="card p-4">
        <input type="hidden" name="id" value="<?php echo $usuarioData['id']; ?>">
        
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $usuarioData['nombre']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellidos:</label>
            <input type="text" name="apellidos" value="<?php echo $usuarioData['apellidos']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" name="correo" value="<?php echo $usuarioData['correo']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Edad:</label>
            <input type="number" name="edad" value="<?php echo $usuarioData['edad']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Plan Base:</label>
            <select name="plan_base" class="form-select">
                <option value="Básico" <?php if ($usuarioData['plan_base'] == 'Básico') echo 'selected'; ?>>Básico</option>
                <option value="Estándar" <?php if ($usuarioData['plan_base'] == 'Estándar') echo 'selected'; ?>>Estándar</option>
                <option value="Premium" <?php if ($usuarioData['plan_base'] == 'Premium') echo 'selected'; ?>>Premium</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Paquetes Adicionales:</label><br>
            <?php
            $paquetes_seleccionados = explode(',', $usuarioData['paquetes']);
            ?>
            <div class="form-check">
                <input type="checkbox" name="paquetes[]" value="Deporte" class="form-check-input" <?php if (in_array('Deporte', $paquetes_seleccionados)) echo 'checked'; ?>> Deporte
            </div>
            <div class="form-check">
                <input type="checkbox" name="paquetes[]" value="Cine" class="form-check-input" <?php if (in_array('Cine', $paquetes_seleccionados)) echo 'checked'; ?>> Cine
            </div>
            <div class="form-check">
                <input type="checkbox" name="paquetes[]" value="Infantil" class="form-check-input" <?php if (in_array('Infantil', $paquetes_seleccionados)) echo 'checked'; ?>> Infantil
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Duración de suscripción:</label>
            <select name="duracion" class="form-select">
                <option value="Mensual" <?php if ($usuarioData['duracion'] == 'Mensual') echo 'selected'; ?>>Mensual</option>
                <option value="Anual" <?php if ($usuarioData['duracion'] == 'Anual') echo 'selected'; ?>>Anual</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>