<?php
require_once 'class_conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conexion = new Conexion();
    $query = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conexion->conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Usuario eliminado con éxito.";
    } else {
        echo "Error al eliminar usuario.";
    }
    $stmt->close();
    $conexion->cerrar();

    // Redirigir de vuelta a la lista de usuarios
    header('Location: lista_usuarios.php');
    exit();
}
?>
