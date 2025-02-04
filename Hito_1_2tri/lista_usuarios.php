<?php
// Incluir el archivo de la clase Conexion
require_once 'class_conexion.php';

// Crear una instancia de la clase Conexion
$conexion = new Conexion();

// Consulta SQL para obtener los usuarios
$query = "SELECT id, nombre, apellidos, correo, edad, plan_base, paquetes, duracion, costo_total FROM usuarios";
$resultado = $conexion->conexion->query($query);

// Verificar si la consulta fue exitosa
if (!$resultado) {
    die("Error en la consulta SQL: " . $conexion->conexion->error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Usuarios Registrados</h1>
    <a href="alta_usuario.php" class="btn btn-primary mb-3">Insertar Nuevo Usuario</a>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Edad</th>
                <th>Plan Base</th>
                <th>Paquetes</th>
                <th>Duración</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($resultado->num_rows > 0) {
                while ($row = $resultado->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['apellidos']; ?></td>
                        <td><?php echo $row['correo']; ?></td>
                        <td><?php echo $row['edad']; ?></td>
                        <td><?php echo $row['plan_base']; ?></td>
                        <td><?php echo $row['paquetes']; ?></td>
                        <td><?php echo $row['duracion']; ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                            <a href="detalles_usuario.php?id=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">Detalles</a>
                        </td>
                    </tr>
                <?php }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No se encontraron usuarios.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>