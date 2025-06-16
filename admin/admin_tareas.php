<?php
// Iniciar sesión para validar si el usuario es administrador
session_start();

// Verificar si el usuario está autenticado y tiene el rol de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirigir al login si no es admin
    exit();
}

// Incluir la configuración de la base de datos
include '../db/config.php';

// Importar PHPMailer para el envío de correos electrónicos
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar la biblioteca de PHPMailer (verifica que la ruta sea correcta)
require '../vendor/autoload.php';

// Procesar la actualización del estado de la tarea cuando se envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tarea_id'])) {
    $tarea_id = $_POST['tarea_id'];
    $nuevo_estado = $_POST['estado'];
    $anotacion = $_POST['anotacion'];

    // Obtener el email y el nombre del usuario asociado a la tarea
    $stmt_user = $conn->prepare("SELECT u.email, u.nombre FROM usuarios u JOIN tareas t ON u.id = t.usuario_id WHERE t.id = ?");
    $stmt_user->bind_param("i", $tarea_id);
    $stmt_user->execute();
    $stmt_user->bind_result($email_usuario, $nombre_usuario);
    $stmt_user->fetch();
    $stmt_user->close();

    // Actualizar el estado de la tarea en la base de datos
    $stmt_update = $conn->prepare("UPDATE tareas SET estado = ?, anotacion = ? WHERE id = ?");
    $stmt_update->bind_param("ssi", $nuevo_estado, $anotacion, $tarea_id);
    $stmt_update->execute();
    $stmt_update->close();

    // Enviar email de notificación al usuario con PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP para enviar correos electrónicos
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8'; // Codificación en UTF-8
        $mail->setLanguage('es', __DIR__ . '/../vendor/phpmailer/phpmailer/language/');
        $mail->Host = 'smtp.buzondecorreo.com'; // Servidor SMTP
        $mail->SMTPAuth = true; // Habilitar autenticación SMTP
        $mail->Username = 'informacion@jenva.es'; // Usuario SMTP
        $mail->Password = 'Informacion1234'; // Contraseña SMTP (¡No deberías dejarlo visible en código!)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Encriptación segura
        $mail->Port = 465; // Puerto SMTP seguro

        // Configuración del remitente y destinatario del correo
        $mail->setFrom('informacion@jenva.es', 'JenVA - Notificaciones');
        $mail->addAddress($email_usuario, $nombre_usuario);

        // Contenido del correo con estado actualizado de la tarea
        $mail->isHTML(true);
        $mail->Subject = "Actualización del estado de tu tarea";
        $mail->Body    = "
                        Hola <strong>{$nombre_usuario}</strong>,<br><br>
                        El estado de tu tarea ha sido actualizado a: <strong>{$nuevo_estado}</strong>.<br>
                        <strong>Anotación del administrador:</strong><br>
                        {$anotacion}<br><br>
                        Saludos,<br>
                        <em>Equipo JenVA</em><br><br>
                        <small>Este es un mensaje automático, por favor no respondas.</small>";

        // Intentar enviar el correo
        $mail->send();
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error al enviar el correo: {$mail->ErrorInfo}</div>";
    }
}

// Obtener todas las tareas con el nombre del usuario asociado
$stmt = $conn->prepare("
    SELECT t.id, t.usuario_id, u.nombre AS usuario_nombre, t.titulo, t.descripcion, t.estado, t.creado_en, t.anotacion
    FROM tareas t
    JOIN usuarios u ON t.usuario_id = u.id 
    ORDER BY t.creado_en DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Tareas - JenVA</title>
    
    <!-- Estilos de Bootstrap y CSS personalizado -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/styles_admin.css"> <!-- Estilos exclusivos para el panel de admin -->

    <script>
        // Función de confirmación antes de actualizar una tarea
        function confirmarCambio() {
            return confirm("¿Estás seguro de que deseas actualizar esta tarea?");
        }
    </script>
</head>
<body>
    <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">JenVA - Admin</a>
            <div class="ml-auto">
                <span class="text-white me-3">Administrador: <?php echo $_SESSION['user_name']; ?></span>
                <a href="/JENVA/logout.php" class="btn btn-sesion">Cerrar Sesión</a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="text-center">Administración de Tareas</h2>

        <!-- Tabla de tareas -->
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                    <th>Anotaciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['usuario_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado']); ?></td>
                        <td><?php echo htmlspecialchars($row['creado_en']); ?></td>

                        <!-- Columna de actualización de estado -->
                        <td>
                            <form action="admin_tareas.php" method="POST" onsubmit="return confirmarCambio();">
                                <input type="hidden" name="tarea_id" value="<?php echo $row['id']; ?>">
                                
                                <label class="form-label fw-bold">Estado</label>
                                <select name="estado" class="form-select form-select-sm mb-2 w-100">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Pendiente de cliente">Pendiente de cliente</option>
                                    <option value="Pendiente de terceros">Pendiente de terceros</option>
                                    <option value="Completada">Completada</option>
                                </select>

                                <button type="submit" class="btn btn-primary btn-sm w-100">Actualizar</button>
                            </form>
                        </td>

                        <!-- Columna de anotaciones -->
                        <td>
                            <textarea name="anotacion" class="form-control form-control-sm mb-2" rows="3"><?php echo htmlspecialchars($row['anotacion']); ?></textarea>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
