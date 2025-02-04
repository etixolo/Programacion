<?php
require_once 'class_conexion.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function agregarUsuario($nombre, $apellido, $email, $telefono, $fecha_nacimiento, $plan_base, $paquetes_adicionales, $duracion_suscripcion) {

        // Determinamos el costo total según el plan y los paquetes
        $costo_base = $this->getCostoBase($plan_base);
        $costo_paquetes = $this->getCostoPaquetes($paquetes_adicionales);
        $costo_total = $costo_base + $costo_paquetes;

        // Insertamos el nuevo usuario
        $query = "INSERT INTO usuarios (nombre, apellido, email, telefono, fecha_nacimiento, edad, plan_base, paquetes_adicionales, duracion_suscripcion, costo_total) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $sentencia = $this->conexion->conexion->prepare($query);
        $sentencia->bind_param("sssssssssd", $nombre, $apellido, $email, $telefono, $fecha_nacimiento, $edad, $plan_base, json_encode($paquetes_adicionales), $duracion_suscripcion, $costo_total);
        
        if ($sentencia->execute()) {
            echo "Usuario agregado con éxito.";
        } else {
            echo "Error al agregar usuario: " . $sentencia->error;
        }
        
        $sentencia->close();
    }

    // Obtener el costo base de acuerdo con el plan
    private function getCostoBase($plan_base) {
        $costos = [
            'Básico' => 5.99,
            'Estándar' => 9.99,
            'Premium' => 14.99
        ];
        return $costos[$plan_base];
    }

    // Obtener el costo de los paquetes adicionales
    public function getCostoPaquetes($paquetes_adicionales) {
        // Definir los costos de los paquetes adicionales
        $costos_paquetes = [
            'Deporte' => 2.99,
            'Cine' => 3.99,
            'Infantil' => 1.99
        ];
    
        // Calcular el costo total de los paquetes seleccionados
        $costo_total = 0;
        foreach ($paquetes_adicionales as $paquete) {
            if (isset($costos_paquetes[$paquete])) {
                $costo_total += $costos_paquetes[$paquete];
            }
        }
    
        return $costo_total;
    }

    // Otros métodos para obtener, actualizar y eliminar usuarios
    public function obtenerUsuarios() {
        $query = "SELECT * FROM usuarios";
        $resultado = $this->conexion->conexion->query($query);
        $usuarios = [];
        
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }
        
        return $usuarios;
    }
}
?>