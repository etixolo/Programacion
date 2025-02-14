<?php
// Función para registrar un nuevo usuario.
function registrarUsuario($nombre_usuario, $correo, $password, $conexion) {
    // Verifica si el correo ya está registrado.
    $consulta = $conexion->prepare("SELECT id FROM usuarios WHERE correo = :correo");
    $consulta->bindParam(':correo', $correo);
    $consulta->execute();

    // Si el correo ya existe, devuelve un mensaje de error.
    if ($consulta->rowCount() > 0) {
        return "El correo electrónico ya está registrado.";
    } else {
        // Hashea la contraseña para almacenarla de forma segura.
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Inserta el nuevo usuario en la base de datos.
        $consulta = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo, password) VALUES (:nombre_usuario, :correo, :password)");
        $consulta->bindParam(':nombre_usuario', $nombre_usuario);
        $consulta->bindParam(':correo', $correo);
        $consulta->bindParam(':password', $password_hash);

        // Si la inserción es exitosa, devuelve true.
        if ($consulta->execute()) {
            return true;
        } else {
            return "Error al registrar el usuario.";
        }
    }
}

// Función para iniciar sesión.
function iniciarSesion($correo, $password, $conexion) {
    // Busca el usuario por su correo.
    $consulta = $conexion->prepare("SELECT id, password FROM usuarios WHERE correo = :correo");
    $consulta->bindParam(':correo', $correo);
    $consulta->execute();

    // Si el usuario existe, verifica la contraseña.
    if ($consulta->rowCount() == 1) {
        $usuario = $consulta->fetch(PDO::FETCH_ASSOC);
        // Compara la contraseña ingresada con el hash almacenado.
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id']; // Guarda el ID del usuario en la sesión.
            return true; // Inicio de sesión exitoso.
        } else {
            return "Contraseña incorrecta.";
        }
    } else {
        return "El correo electrónico no está registrado.";
    }
}

// Función para cerrar sesión.
function cerrarSesion() {
    session_unset(); // Elimina todas las variables de sesión.
    session_destroy(); // Destruye la sesión.
    header('Location: index.php'); // Redirige al usuario a la página de inicio.
    exit; // Termina el script.
}
?>