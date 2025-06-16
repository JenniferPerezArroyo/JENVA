<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Tareas - JenVA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Estilos específicos para admin -->
    <link rel="stylesheet" href="../css/styles_admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">JenVA - Admin</a>
            <div class="ml-auto">
                <span class="text-white me-3">Administrador: <?php echo $_SESSION['user_name']; ?> </span>
                <a href="/JENVA/logout.php" class="btn btn-sesion">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    <h3>página en construción</h3>
    <img src="../img/construccion.jpg" class="card-img" alt="construccion">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>