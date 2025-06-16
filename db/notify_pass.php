<?php
// Establecer el encabezado de la respuesta como JSON para las solicitudes API
header('Content-Type: application/json');

// Cargar la biblioteca PHPMailer para el envío de correos electrónicos
require __DIR__ . '/../vendor/autoload.php';

// Importar las clases necesarias de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Leer el JSON enviado por el cliente
$raw = file_get_contents('php://input'); // Captura los datos enviados en el cuerpo de la solicitud
$data = json_decode($raw, true); // Decodifica el JSON a un array asociativo

// Validar que el campo 'email' esté presente y sea un formato válido
if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400); // Código de error 400 (Solicitud incorrecta)
    echo json_encode(['ok' => false, 'msg' => 'Email inválido']); // Respuesta en JSON
    exit;
}

$user_email = $data['email'] ?? null; // Capturar el email del usuario

// Conectar con la base de datos para buscar al usuario
require __DIR__ . '/config.php'; // Cargar la configuración de la base de datos

// Preparar la consulta SQL para obtener el nombre del usuario basado en su email
$stmt = $conn->prepare("SELECT nombre FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($nombre_usuario);

// Si el correo no está registrado, responder con un código 404
if (! $stmt->fetch()) {
    http_response_code(404); // Código de error 404 (No encontrado)
    echo json_encode(['ok'=>false,'msg'=>'Correo no registrado']);
    exit;
}

$stmt->close(); // Cerrar la consulta

// Configurar el correo con PHPMailer
$mail = new PHPMailer(true);
try {
    // Configuración SMTP para el envío de correos
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8'; // Codificar todo el mensaje en UTF-8
    $mail->setLanguage('es', __DIR__ . '/../vendor/phpmailer/phpmailer/language/');
    $mail->Host       = 'smtp.buzondecorreo.com'; // Servidor SMTP
    $mail->SMTPAuth   = true; // Activar autenticación SMTP
    $mail->Username   = 'informacion@jenva.es'; // Nombre de usuario SMTP
    $mail->Password   = 'Informacion1234'; // ⚠️ Nota: Nunca dejes contraseñas visibles en el código fuente.
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usar encriptación segura
    $mail->Port       = 465; // Puerto seguro para SMTP

    // Configuración del remitente y destinatario
    $mail->setFrom('informacion@jenva.es', 'JenVA - Notificaciones'); // Remitente
    $mail->addAddress($user_email, $nombre_usuario); // Destinatario

    // Configurar el contenido del correo
    $mail->isHTML(true); // Definir que el cuerpo del mensaje es HTML
    $mail->Subject = 'Recuperación de contraseña'; // Asunto del correo
    $mail->Body    = "
      Estimado/a <strong>{$nombre_usuario}</strong>,<br><br>
      Hemos recibido tu petición de recuperación de contraseña.
      <br>En estos momentos estamos trabajando en mejoras,
      pronto te contactaremos con más detalles.<br><br>
      Saludos,<br>
      <em>Equipo JenVA</em><br><br>
      <small>Respuesta automática, por favor no contestes este e-mail.</small>
    ";

    // Enviar el correo
    $mail->send();
    echo json_encode(['ok'=>true,'msg'=>'Email enviado']); // Responder con éxito en JSON
} catch (Exception $e) {
    http_response_code(500); // Código de error 500 (Error interno del servidor)
    echo json_encode(['ok'=>false,'msg'=>$mail->ErrorInfo]); // Mostrar error de PHPMailer en JSON
}
