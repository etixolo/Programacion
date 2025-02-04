<?php
class Conexion {
    private $servidor = 'localhost';
    private $usuario = 'root';
    private $password = '1234';
    private $base_datos = 'StreamWeb';
    public $conexion;

    public function __construct() {
        // Crear la conexión a la base de datos
        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->password, $this->base_datos);

        // Verificar si hay errores en la conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function cerrar() {
        // Cerrar la conexión
        $this->conexion->close();
    }
}
?>