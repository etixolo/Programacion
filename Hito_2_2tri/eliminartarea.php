<?php
// Inicia la sesión.
session_start();

// Si el usuario no está logueado, lo manda a la página de inicio de sesión.
if (!isset($_SESSION['usuario_id'])) {
    header('Location: iniciosesion.php');
    exit; // Termina el script.
}

// Incluye el archivo de conexión a la base de datos.
include 'conexion.php';

// Si se proporciona un ID de tarea en la URL.
if (isset($_GET['id'])) {
    // Obtiene el ID de la tarea desde la URL.
    $tarea_id = $_GET['id'];
    // Obtiene el ID del usuario desde la sesión.
    $usuario_id = $_SESSION['usuario_id'];

    // Verifica que la tarea pertenece al usuario actual.
    $consulta = $conexion->prepare("SELECT id FROM tareas WHERE id = :tarea_id AND usuario_id = :usuario_id");
    $consulta->bindParam(':tarea_id', $tarea_id); // Asocia el ID de la tarea.
    $consulta->bindParam(':usuario_id', $usuario_id); // Asocia el ID del usuario.
    $consulta->execute(); // Ejecuta la consulta.

    // Si la tarea existe y pertenece al usuario.
    if ($consulta->rowCount() == 1) {
        // Elimina la tarea de la base de datos.
        $consulta = $conexion->prepare("DELETE FROM tareas WHERE id = :tarea_id");
        $consulta->bindParam(':tarea_id', $tarea_id); // Asocia el ID de la tarea.
        $consulta->execute(); // Ejecuta la consulta.
    }
}

// Redirige al usuario a la página de tareas.
header('Location: tablatareas.php');
exit; // Termina el script.
?>