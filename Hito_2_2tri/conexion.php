<?php
$host = 'localhost';
$dbname = 'gestor_tareas';
$usuario = 'root';
$password = '1234';

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>