<?php
session_start(); // Inicia la sesión para poder acceder a $_SESSION

// Si no hay usuario logueado, redirige al login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

include '../db/config.php'; // Incluye la configuración de conexión ($conn)

// Obtiene el ID del usuario logueado
$usuario_id = $_SESSION['user_id'];

// Prepara la consulta para recuperar todas sus solicitudes de soporte
$stmt = $conn->prepare("
    SELECT asunto, mensaje, respuesta_admin, creado_en 
    FROM soporte 
    WHERE usuario_id = ? 
    ORDER BY creado_en DESC
");
$stmt->bind_param("i", $usuario_id); // Vincula el ID
$stmt->execute();                     // Ejecuta la consulta
$result = $stmt->get_result();        // Obtiene el resultado
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Técnico - Cliente | JenVA</title>
    <!-- Importación de estilos de Bootstrap para mejorar el diseño -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos generales -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Estilos específicos de páginas -->
    <link rel="stylesheet" href="../css/styles_pages.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Enlace al dashboard de cliente -->
        <a class="navbar-brand" href="dashboard.php">JenVA Clientes</a>
        <div class="ml-auto">
            <!-- Muestra el nombre del usuario -->
            <span class="text-white me-3">Bienvenido, <?php echo $_SESSION['user_name']; ?></span>
            <!-- Botón para cerrar sesión -->
            <a href="/JENVA/logout.php" class="btn btn-sesion">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Soporte Técnico</h2>
    
    <!-- Formulario para enviar nueva consulta -->
    <div class="card mt-4 mb-5 soporte-card border-azul">
        <div class="card-header">Enviar una nueva consulta</div>
        <div class="card-body">
            <form action="../db/procesar_soporte.php" method="POST">
                <!-- Campo de asunto -->
                <div class="mb-3">
                    <label for="asunto" class="form-label">Asunto</label>
                    <input type="text" id="asunto" name="asunto" class="form-control" required>
                </div>
                <!-- Campo de mensaje -->
                <div class="mb-3">
                    <label for="mensaje" class="form-label">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" class="form-control" rows="4" required></textarea>
                </div>
                <!-- Botón de envío -->
                <button type="submit" class="btn btn-primary">Enviar Consulta</button>
            </form>
        </div>
    </div>

    <!-- Historial de consultas enviadas -->
    <h4 class="text-center mb-3">Mis consultas</h4>
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Asunto</th>
                        <th>Mensaje</th>
                        <th>Respuesta del equipo</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Itera cada consulta -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <!-- Fecha de creación -->
                            <td><?php echo $row['creado_en']; ?></td>
                            <!-- Asunto de la consulta -->
                            <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                            <!-- Mensaje original -->
                            <td><?php echo nl2br(htmlspecialchars($row['mensaje'])); ?></td>
                            <!-- Respuesta, si existe -->
                            <td>
                                <?php if (!empty($row['respuesta_admin'])): ?>
                                    <?php echo nl2br(htmlspecialchars($row['respuesta_admin'])); ?>
                                <?php else: ?>
                                    <span class="text-muted">En revisión</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <!-- Mensaje si no hay consultas -->
        <p class="text-center">Aún no has enviado ninguna consulta.</p>
    <?php endif; ?>
</div>

 <!-- Importación de Bootstrap Bundle para funcionalidad de componentes como botones y menús -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Libera recursos
$stmt->close();// Cerrar la consulta preparada
$conn->close();// Cerrar la conexión con la base de datos
?>

