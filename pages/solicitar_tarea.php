<?php
// Iniciar sesión para validar si el usuario está autenticado
session_start();

// Verificar si el usuario está autenticado antes de permitir el acceso
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirigir al login si no hay sesión activa
    exit(); // Detener ejecución del script
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Configuración de la vista en dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Tarea - JenVA</title>

    <!-- Importación de estilos de Bootstrap para mejorar el diseño -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Importación de estilos personalizados -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles_pages.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Logo y enlace al panel de cliente -->
            <a class="navbar-brand" href="dashboard.php">JenVA Clientes</a>

            <!-- Sección de usuario y cierre de sesión -->
            <div class="ml-auto">
                <span class="text-white me-3">Bienvenido, <?php echo $_SESSION['user_name']; ?> </span>
                <a href="logout.php" class="btn btn-sesion">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Solicitar Nueva Tarea</h2>

        <!-- Formulario para enviar solicitud de tarea -->
        <form action="../db/procesar_tarea.php" method="POST" class="mx-auto" style="max-width: 600px;">
            <!-- Campo para el título de la tarea -->
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la tarea</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <!-- Campo para la descripción de la tarea -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="4" required></textarea>
            </div>

            <!-- Botón para enviar la solicitud -->
            <button type="submit" class="btn btn-primary w-100">Enviar Solicitud</button>
        </form>
    </div>

    <!-- Importación de Bootstrap Bundle para funcionalidad de componentes como botones y menús -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
