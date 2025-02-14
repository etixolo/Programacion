<?php
// Inicia la sesión.
session_start();

// Si el usuario ya está logueado, lo manda a la página de tareas.
if (isset($_SESSION['usuario_id'])) {
    header('Location: tablatareas.php');
    exit; // Termina el script.
}

// Incluye los archivos necesarios para la conexión y autenticación.
include 'conexion.php'; // Conexión a la base de datos.
include 'autentificacion.php'; // Funciones de autenticación.

// Variable para guardar mensajes de error.
$error = '';

// Si el formulario se envió (método POST).
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene y limpia los datos del formulario.
    $correo = trim($_POST['correo']); // Correo electrónico.
    $password = trim($_POST['password']); // Contraseña.

    // Intenta iniciar sesión con los datos proporcionados.
    $resultado = iniciarSesion($correo, $password, $conexion);

    // Si el inicio de sesión fue exitoso.
    if ($resultado === true) {
        header('Location: tablatareas.php'); // Redirige a la página de tareas.
        exit; // Termina el script.
    } else {
        // Si hubo un error, lo guarda para mostrarlo.
        $error = $resultado;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Iniciar Sesión</h1>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="iniciosesion.php" method="POST" class="bg-white p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Iniciar Sesión</button>
                </form>
                <p class="text-center mt-3">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
            </div>
        </div>
    </div>
</body>
</html>