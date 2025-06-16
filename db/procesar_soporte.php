<?php
// Iniciar sesión para verificar si el usuario está autenticado
session_start();

// Si el usuario no está autenticado, redirigirlo a la página de login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirección al login si no hay sesión activa
    exit(); // Finalizar la ejecución del script
}

// Incluir el archivo de configuración para la conexión a la base de datos
include 'config.php';

// Verificar si la solicitud proviene de un formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del usuario autenticado desde la sesión
    $usuario_id = $_SESSION['user_id'];

    // Capturar y limpiar los datos del formulario para evitar espacios innecesarios
    $asunto = trim($_POST['asunto']); // Eliminar espacios en blanco al inicio y al final
    $mensaje = trim($_POST['mensaje']);

    // Verificar que los campos no estén vacíos
    if (!empty($asunto) && !empty($mensaje)) {
        // Preparar una consulta SQL para insertar el mensaje de soporte en la base de datos
        $stmt = $conn->prepare("INSERT INTO soporte (usuario_id, asunto, mensaje) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $usuario_id, $asunto, $mensaje); // Evitar SQL Injection con parámetros preparados

        // Ejecutar la consulta y verificar si se insertó correctamente
        if ($stmt->execute()) {
            // Si la consulta es exitosa, redirigir a la página de soporte con mensaje de éxito
            header("Location: ../pages/soporte_clientes.php?enviado=ok");
        } else {
            echo "Error al guardar la consulta. Inténtalo más tarde.";
        }

        $stmt->close();// Cerrar la consulta preparada para liberar recursos
    } else {
        echo "Por favor, completa todos los campos.";
    }

    $conn->close();// Cerrar la conexión a la base de datos para liberar recursos
} else {
    // Si la solicitud no es POST, redirigir al usuario a la página de soporte
    header("Location: ../pages/soporte.php");
    exit();
}
