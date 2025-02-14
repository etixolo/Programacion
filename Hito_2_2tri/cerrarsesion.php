<?php
session_start(); // Inicia la sesión
include 'autentificacion.php'; // Incluye el archivo con la función cerrarSesion
cerrarSesion(); // Llama a la función para cerrar la sesión
?>