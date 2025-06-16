<?php
// Iniciar sesión para validar si el usuario está autenticado
session_start();

// Verificar si el usuario está autenticado antes de permitir el acceso
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirigir al login si no hay sesión activa
    exit(); // Detener ejecución del script
}

// Incluir el archivo de configuración para la conexión a la base de datos
include '../db/config.php';

// Capturar el ID del usuario desde la sesión
$usuario_id = $_SESSION['user_id'];

// Preparar la consulta SQL para obtener el historial de tareas del usuario
$stmt = $conn->prepare("
    SELECT id, titulo, descripcion, estado, creado_en 
    FROM tareas 
    WHERE usuario_id = ? 
    ORDER BY creado_en DESC");
$stmt->bind_param("i", $usuario_id); // Vincular el ID del usuario a la consulta SQL
$stmt->execute();
$result = $stmt->get_result(); // Obtener los resultados de la consulta
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- Configuración de la vista en dispositivos móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Tareas - JenVA</title>

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
                <a href="/JENVA/logout.php" class="btn btn-sesion">Cerrar Sesión</a>
            </div>
        </div>
    </nav>

    
        <div class="container mt-5">
        <h2 class="text-center">Historial de Tareas</h2>

        <!-- Tabla con el historial de tareas del usuario -->
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iteración sobre los resultados obtenidos de la base de datos -->
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <!-- Mostrar título de la tarea -->
                    <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                    <!-- Mostrar descripción de la tarea -->
                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                    <!-- Mostrar estado con formato visual -->
                    <td>
                        <span class="badge 
                            <?php 
                                echo ($row['estado'] == 'Pendiente') ? 'bg-warning' : 
                                     (($row['estado'] == 'En Proceso') ? 'bg-primary' : 'bg-success');
                            ?>">
                            <?php echo htmlspecialchars($row['estado']); ?>
                        </span>
                    </td>
                    <!-- Mostrar fecha de creación -->
                    <td><?php echo htmlspecialchars($row['creado_en']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    
    <!-- Importación de Bootstrap Bundle para funcionalidad de componentes como botones y menús -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();// Cerrar la consulta preparada
$conn->close();// Cerrar la conexión con la base de datos
?>
