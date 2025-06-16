<?php
session_start();
session_unset(); // Eliminar todas las variables de sesión
session_destroy(); // Destruir la sesión
ob_start(); // Inicia el buffer de salida
header("Location: /JENVA/index.php"); // Redirigir al login
exit();
?>
