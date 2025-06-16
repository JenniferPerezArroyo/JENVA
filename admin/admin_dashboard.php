<?php
session_start(); 
// Verifica que haya sesión iniciada y que sea un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Si no es admin, redirige al login
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - JenVA</title>
    
    <!-- Bootstrap CSS desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos globales de la aplicación -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Estilos específicos para la sección de administración -->
    <link rel="stylesheet" href="../css/styles_admin.css">
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <!-- Logo/enlace principal -->
            <a class="navbar-brand" href="admin_dashboard.php">JenVA - Administración</a>
            <div class="ml-auto">
                <!-- Saludo con el nombre del admin -->
                <span class="text-white me-3">Bienvenido, <?php echo $_SESSION['user_name']; ?> </span>
                <!-- Botón de cierre de sesión -->
                <a href="../logout.php" class="btn btn-sesion">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    
    <!-- Contenedor principal -->
    <div class="container mt-5 admin-container">
        <!-- Título y descripción -->
        <h2 class="text-center">Área de Administración</h2>
        <p class="text-center">Gestiona tareas, documentos, facturación y usuarios.</p>
        
        <!-- Fila de tarjetas -->
        <div class="row mt-4 g-4">

            <!-- Tarjeta: Gestionar Tareas -->
            <div class="col-md-3 d-flex">
                <div class="card h-100 d-flex flex-column justify-content-between">
                    <div class="card-body text-center">
                        <h5 class="card-title">Gestionar Tareas</h5>
                        <p class="card-text">Modifica el estado de las tareas de los usuarios.</p>
                    </div>
                    <div class="text-center pb-3">
                        <!-- Enlace a admin_tareas.php -->
                        <a href="admin_tareas.php" class="btn btn-primary">Ver Tareas</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Documentos de Clientes -->
            <div class="col-md-3 d-flex">
                <div class="card h-100 d-flex flex-column justify-content-between">
                    <div class="card-body text-center">
                        <h5 class="card-title">Documentos de Clientes</h5>
                        <p class="card-text">Gestiona los documentos enviados por los clientes.</p>
                    </div>
                    <div class="text-center pb-3">
                        <!-- Enlace a admin_doc.php -->
                        <a href="admin_doc.php" class="btn btn-primary">Ver Documentos</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Facturación -->
            <div class="col-md-3 d-flex">
                <div class="card h-100 d-flex flex-column justify-content-between">
                    <div class="card-body text-center">
                        <h5 class="card-title">Facturación</h5>
                        <p class="card-text">Consulta facturas emitidas y pendientes.</p>
                    </div>
                    <div class="text-center pb-3">
                        <!-- Enlace a admin_facturas.php -->
                        <a href="admin_facturas.php" class="btn btn-primary">Ver Facturas</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Gestión de Usuarios -->
            <div class="col-md-3 d-flex">
                <div class="card h-100 d-flex flex-column justify-content-between">
                    <div class="card-body text-center">
                        <h5 class="card-title">Gestión de Usuarios</h5>
                        <p class="card-text">Administra cuentas de clientes y administradores.</p>
                    </div>
                    <div class="text-center pb-3">
                        <!-- Enlace a admin_usuarios.php -->
                        <a href="admin_usuarios.php" class="btn btn-primary">Ver Usuarios</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Soporte -->
            <div class="col-md-3 d-flex">
                <div class="card h-100 d-flex flex-column justify-content-between">
                    <div class="card-body text-center">
                        <h5 class="card-title">Soporte</h5>
                        <p class="card-text">Revisa solicitudes de soporte de los clientes.</p>
                    </div>
                    <div class="text-center pb-3">
                        <!-- Enlace a admin_soporte.php -->
                        <a href="admin_soporte.php" class="btn btn-primary">Ver Soporte</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <!-- Bootstrap JS desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
