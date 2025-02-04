<?php
require_once 'class_conexion.php';

class UsuariosController {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    // Método para crear un nuevo usuario
    public function crearUsuario($nombre, $apellidos, $correo, $edad, $plan_base, $paquetes_adicionales, $duracion) {
        // Determinamos el costo total de acuerdo al plan base y los paquetes adicionales
        $costo_base = $this->getCostoBase($plan_base);
        $costo_paquetes = $this->getCostoPaquetes($paquetes_adicionales);
        $costo_total = $costo_base + $costo_paquetes;

        // Insertamos el nuevo usuario en la base de datos
        $query = "INSERT INTO usuarios (nombre, apellidos, correo, edad, plan_base, paquetes_adicionales, duracion, costo_total)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $sentencia = $this->conexion->conexion->prepare($query);
        $sentencia->bind_param("ssssssss", $nombre, $apellidos, $correo, $edad, $plan_base, json_encode($paquetes_adicionales), $duracion, $costo_total);

        if ($sentencia->execute()) {
            echo "Usuario creado con éxito.";
        } else {
            echo "Error al crear el usuario: " . $sentencia->error;
        }

        $sentencia->close();
    }

    // Método para editar un usuario
    public function editarUsuario($id, $nombre, $apellidos, $correo, $edad, $plan_base, $paquetes_adicionales, $duracion) {
        // Asegurar que paquetes_adicionales sea un array
        if (!is_array($paquetes_adicionales)) {
            $paquetes_adicionales = explode(',', $paquetes_adicionales);
        }
    
        // Calcular el costo base según el plan seleccionado
        $costo_base = $this->getCostoBase($plan_base);
    
        // Calcular el costo de los paquetes adicionales
        $costo_paquetes = $this->getCostoPaquetes($paquetes_adicionales);
    
        // Calcular el costo total (costo base + costo de paquetes)
        $costo_total = $costo_base + $costo_paquetes;
    
        // Convertir los paquetes adicionales a JSON para almacenarlos en la base de datos
        $paquetes_json = json_encode($paquetes_adicionales);
    
        // Query de actualización
        $query = "UPDATE usuarios 
                  SET nombre = ?, apellidos = ?, correo = ?, edad = ?, plan_base = ?, paquetes = ?, duracion = ?, costo_total = ? 
                  WHERE id = ?";
        $sentencia = $this->conexion->conexion->prepare($query);
    
        if (!$sentencia) {
            die("Error en la consulta SQL: " . $this->conexion->conexion->error);
        }
    
        // Pasar las variables a la consulta
        $sentencia->bind_param(
            "sssisssdi",
            $nombre, 
            $apellidos, 
            $correo, 
            $edad, 
            $plan_base, 
            $paquetes_json, 
            $duracion, 
            $costo_total, 
            $id
        );
    
        if ($sentencia->execute()) {
            // Redirigir a la lista de usuarios después de una actualización exitosa
            header('Location: lista_usuarios.php');
            exit(); // Detener la ejecución del script
        } else {
            echo "Error al actualizar el usuario: " . $sentencia->error;
        }
    
        $sentencia->close();
    }
    

    // Método para eliminar un usuario
    public function eliminarUsuario($id) {
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Usuario eliminado con éxito.";
        } else {
            echo "Error al eliminar el usuario.";
        }

        $stmt->close();
    }

    // Obtener el costo base de acuerdo con el plan
    public function getCostoBase($plan_base) {
        $costos = [
            'Básico' => 5.99,
            'Estándar' => 9.99,
            'Premium' => 14.99
        ];
        return $costos[$plan_base];
    }

    // Obtener el costo de los paquetes adicionales
    public function getCostoPaquetes($paquetes_adicionales) {
        $costos_paquetes = [
            'Deporte' => 2.99,
            'Cine' => 3.99,
            'Infantil' => 1.99
        ];
        $costo_total = 0;
        foreach ($paquetes_adicionales as $paquete) {
            $costo_total += $costos_paquetes[$paquete];
        }
        return $costo_total;
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios() {
        $query = "SELECT * FROM usuarios";
        $resultado = $this->conexion->conexion->query($query);
        return $resultado;
    }

    public function obtenerUsuarioPorId($id) {
        $query = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $this->conexion->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>


