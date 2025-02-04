<?php
require_once 'class_conexion.php';

// Crear una instancia de la clase Conexion
$conexion = new Conexion();

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $edad = $_POST['edad'];
    $plan_base = $_POST['plan_base'];
    $duracion = $_POST['duracion'];

    // Verificar si se seleccionaron paquetes adicionales
    $paquetes = isset($_POST['paquetes']) ? implode(',', $_POST['paquetes']) : ''; // Si no se seleccionaron, será un string vacío

    // Verificar si el correo ya existe en la base de datos
    $query = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conexion->conexion->prepare($query);
    $stmt->bind_param("s", $correo); // "s" para string (correo)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "El correo ya está registrado.";
        exit;
    }

    // Insertar usuario en la base de datos
    $insertQuery = "INSERT INTO usuarios (nombre, apellidos, correo, edad, plan_base, duracion, paquetes) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $conexion->conexion->prepare($insertQuery);
    $insertStmt->bind_param("sssssss", $nombre, $apellidos, $correo, $edad, $plan_base, $duracion, $paquetes); // "s" para string, "i" para entero
    $insertStmt->execute();

    if ($insertStmt->affected_rows > 0) {
        // Redirigir a la lista de usuarios
        header('Location: lista_usuarios.php'); // Asegúrate de que "lista_usuarios.php" sea el archivo de listado
        exit; // Detener la ejecución del script después de la redirección
    } else {
        echo "Error al registrar usuario.";
    }

    // Cerrar el statement
    $stmt->close();
    $insertStmt->close();

    // Cerrar la conexión
    $conexion->cerrar();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir el archivo de validaciones -->
    <script src="validaciones.js" defer></script>
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Formulario de Registro</h1>
    <form method="POST" class="card p-4">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Apellidos:</label>
            <input type="text" name="apellidos" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Edad:</label>
            <input type="number" name="edad" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Plan Base:</label>
            <select name="plan_base" class="form-select">
                <option value="Básico">Básico</option>
                <option value="Estándar">Estándar</option>
                <option value="Premium">Premium</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Paquetes Adicionales:</label><br>
            <div class="form-check">
                <input type="checkbox" name="paquetes[]" value="Deporte" class="form-check-input"> Deporte
            </div>
            <div class="form-check">
                <input type="checkbox" name="paquetes[]" value="Cine" class="form-check-input"> Cine
            </div>
            <div class="form-check">
                <input type="checkbox" name="paquetes[]" value="Infantil" class="form-check-input"> Infantil
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Duración de suscripción:</label>
            <select name="duracion" class="form-select">
                <option value="Mensual">Mensual</option>
                <option value="Anual">Anual</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>