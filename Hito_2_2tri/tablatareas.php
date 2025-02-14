<?php
// Inicia la sesión.
session_start();

// Si el usuario no está logueado, lo manda a la página de inicio de sesión.
if (!isset($_SESSION['usuario_id'])) {
    header('Location: iniciosesion.php');
    exit; // Termina el script.
}

// Incluye los archivos necesarios para la conexión y autenticación.
include 'conexion.php'; // Conexión a la base de datos.
include 'autentificacion.php'; // Funciones de autenticación.

// Obtiene el ID del usuario desde la sesión.
$usuario_id = $_SESSION['usuario_id'];

// Si se envió el formulario para agregar una nueva tarea.
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nombre_tarea'])) {
    // Obtiene y limpia el nombre de la tarea.
    $nombre_tarea = trim($_POST['nombre_tarea']);

    // Si el nombre de la tarea no está vacío.
    if (!empty($nombre_tarea)) {
        // Prepara la consulta para insertar la tarea en la base de datos.
        $consulta = $conexion->prepare("INSERT INTO tareas (usuario_id, nombre_tarea) VALUES (:usuario_id, :nombre_tarea)");
        // Asocia los valores a los parámetros de la consulta.
        $consulta->bindParam(':usuario_id', $usuario_id);
        $consulta->bindParam(':nombre_tarea', $nombre_tarea);
        // Ejecuta la consulta.
        $consulta->execute();
    }
}

// Obtiene las tareas del usuario actual.
$consulta = $conexion->prepare("SELECT id, nombre_tarea, completada FROM tareas WHERE usuario_id = :usuario_id");
// Asocia el ID del usuario al parámetro de la consulta.
$consulta->bindParam(':usuario_id', $usuario_id);
// Ejecuta la consulta.
$consulta->execute();
// Obtiene todas las tareas como un array asociativo.
$tareas = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Tareas - Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center mb-4">Mis Tareas</h1>
                <form action="tablatareas.php" method="POST" class="bg-white p-4 rounded shadow mb-4">
                    <div class="mb-3">
                        <label for="nombre_tarea" class="form-label">Nueva Tarea:</label>
                        <input type="text" name="nombre_tarea" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Agregar Tarea</button>
                </form>
                <ul class="list-group">
                    <?php foreach ($tareas as $tarea): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo htmlspecialchars($tarea['nombre_tarea']); ?>
                            <div>
                                <?php if ($tarea['completada']): ?>
                                    <span class="badge bg-success">Completada</span>
                                <?php else: ?>
                                    <a href="completartarea.php?id=<?php echo $tarea['id']; ?>" class="btn btn-sm btn-success">Marcar como Completada</a>
                                <?php endif; ?>
                                <a href="eliminartarea.php?id=<?php echo $tarea['id']; ?>" class="btn btn-sm btn-danger">Eliminar</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="text-center mt-4">
                    <a href="cerrarsesion.php" class="btn btn-warning">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>