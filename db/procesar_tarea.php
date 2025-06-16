<?php
// Iniciar sesión para verificar si el usuario está autenticado
session_start();

include '../db/config.php';

// Si el usuario no está autenticado, redirigirlo a la página de login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirección al login si no hay sesión activa
    exit(); // Finalizar la ejecución del script
}

// Verificar si la solicitud proviene de un formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar el ID del usuario desde la sesión
    $usuario_id = $_SESSION['user_id'];

    // Limpiar el título y la descripción eliminando espacios en blanco al inicio y al final
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);

    // Validar que los campos no estén vacíos
    if (empty($titulo) || empty($descripcion)) {
        // Guardar mensaje de error en la sesión y redirigir de vuelta al formulario
        $_SESSION['error'] = "Todos los campos son obligatorios.";
        header("Location: ../pages/solicitar_tarea.php");
        exit();
    }

    // Preparar una consulta SQL para insertar la tarea en la base de datos
    $stmt = $conn->prepare("INSERT INTO tareas (usuario_id, titulo, descripcion, estado, creado_en) VALUES (?, ?, ?, 'Pendiente', NOW())");
    $stmt->bind_param("iss", $usuario_id, $titulo, $descripcion); // Evitar SQL Injection con parámetros preparados
    
    // Ejecutar la consulta y verificar si se insertó correctamente
    if ($stmt->execute()) {
        // Guardar mensaje de éxito en la sesión y redirigir al panel del usuario
        $_SESSION['success'] = "Tarea solicitada con éxito.";
        header("Location: ../pages/dashboard.php");
    } else {
        // Guardar mensaje de error en la sesión y redirigir de vuelta al formulario
        $_SESSION['error'] = "Hubo un error al registrar la tarea.";
        header("Location: ../pages/solicitar_tarea.php");
    }

    // Cerrar la consulta preparada y la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Si la solicitud no es POST, redirigir al usuario a la página de solicitud
    header("Location: ../pages/solicitar_tarea.php");
    exit();
}
