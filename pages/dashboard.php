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
    <title>Panel de Cliente - JenVA</title>

    <!-- Importación de estilos de Bootstrap para mejorar el diseño -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Importación de estilos personalizados -->
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles_pages.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Logo y enlace a la página principal -->
            <a class="navbar-brand" href="../index.php">JenVA</a>

            <!-- Sección de usuario y cierre de sesión -->
            <div class="ml-auto">
                <span class="text-white me-3">Bienvenido, <?php echo $_SESSION['user_name']; ?> </span>
                <a href="/JENVA/logout.php" class="btn btn-sesion">Cerrar Sesión</a>
                
                <!-- Si el usuario es administrador, mostrar acceso al panel de administración -->
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                    <a href="../admin/admin_dashboard.php" class="btn btn-secondary ms-2">Admin Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="text-center">Área de Cliente</h2>
        <p class="text-center">Aquí puedes gestionar tus servicios y tareas.</p>

        <!-- Tarjetas con opciones de gestión -->
        <div class="row mt-4">
            <!-- Tarjeta para solicitar tarea -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Solicitar Tarea</h5>
                        <p class="card-text">Envía una nueva solicitud de tarea administrativa.</p>
                        <a href="../pages/solicitar_tarea.php" class="btn btn-primary">Nueva Solicitud</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta para ver historial de servicios -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Historial de Servicios</h5>
                        <p class="card-text">Consulta tus tareas solicitadas y su estado.</p>
                        <a href="../pages/historial.php" class="btn btn-primary">Ver Historial</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta para soporte -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Soporte</h5>
                        <p class="card-text">Contáctanos si necesitas ayuda.</p>
                        <a href="../pages/soporte_clientes.php" class="btn btn-primary">Contactar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
       <!-- Importación de Bootstrap Bundle para funcionalidad de componentes como botones y menús -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 


