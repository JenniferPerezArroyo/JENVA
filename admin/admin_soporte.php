<?php
session_start();

// Verifica si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");// Redirige al login si no es admin
    exit();
}

include '../db/config.php'; // Conexión a la base de datos

// Procesa la respuesta del administrador cuando se envía el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['soporte_id'])) {
    $soporte_id = $_POST['soporte_id'];// ID de la consulta
    $respuesta = trim($_POST['respuesta_admin']);// Texto de la respuesta

    // Prepara y ejecuta la actualización en la tabla 'soporte'
    $stmt_update = $conn->prepare("UPDATE soporte SET respuesta_admin = ?, respondido = 1 WHERE id = ?");
    $stmt_update->bind_param("si", $respuesta, $soporte_id);
    $stmt_update->execute();
    $stmt_update->close();
}

// Consulta para obtener todas las solicitudes de soporte junto con datos del usuario
$stmt = $conn->prepare("SELECT s.id, s.asunto, s.mensaje, s.creado_en, s.respondido, s.respuesta_admin, u.nombre, u.email
                        FROM soporte s
                        JOIN usuarios u ON s.usuario_id = u.id
                        ORDER BY s.creado_en DESC");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte Técnico - Admin | JenVA</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Estilos generales -->
    <link rel="stylesheet" href="../css/styles.css">
    <!-- Estilos específicos para admin -->
    <link rel="stylesheet" href="../css/styles_admin.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Enlace al dashboard de admin -->
        <a class="navbar-brand" href="admin_dashboard.php">JenVA - Admin</a>
        <div class="ml-auto">
            <!-- Muestra el nombre del administrador en la barra -->
            <span class="text-white me-3">Administrador: <?php echo $_SESSION['user_name']; ?> </span>
            <!-- Botón para cerrar sesión -->
            <a href="/JENVA/logout.php" class="btn btn-sesion">Cerrar Sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Consultas de Soporte Técnico</h2>

    <table class="table table-bordered mt-4">
        <thead class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Email</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Respuesta</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
             <!-- Itera cada fila de resultado -->
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                     <!-- Datos del cliente que solicitó soporte -->
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['mensaje'])); ?></td>
                    <td><?php echo $row['creado_en']; ?></td>
                    <!-- Columna de respuesta: muestra textarea si está pendiente -->
                    <td>
                        <?php if (!$row['respondido']): ?>
                            <form method="POST" action="admin_soporte.php">
                                <!-- ID oculto para identificar la consulta -->
                                <input type="hidden" name="soporte_id" value="<?php echo $row['id']; ?>">
                                <!-- Área de texto para que el admin escriba la respuesta -->
                                <textarea name="respuesta_admin" class="form-control mb-2" rows="3" required></textarea>
                                 <!-- Botón para enviar la respuesta y marcar como respondido -->
                                <button type="submit" class="btn btn-success btn-sm">Enviar Respuesta</button>
                            </form>
                        <?php else: ?>
                            <!-- Si ya fue respondido, muestra el texto guardado -->
                            <?php echo nl2br(htmlspecialchars($row['respuesta_admin'])); ?>
                        <?php endif; ?>
                    </td>
                    <!-- Estado de la consulta -->
                    <td>
                        <?php echo $row['respondido'] ? '<span class="text-success">Respondido</span>' : '<span class="text-warning">Pendiente</span>'; ?>
                    </td>
                    <!-- Acción extraible: si ya respondido deshabilita botón -->
                    <td>
                        <?php if ($row['respondido']): ?>
                            <button class="btn btn-secondary btn-sm" disabled>Ya respondido</button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<!-- Bootstrap JS bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
$stmt->close();// Cierra la consulta
$conn->close();// Cierra la conexión
?>
