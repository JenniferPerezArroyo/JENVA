<?php
// Asegúrate de que esta ruta sea correcta, ya que la ruta 'vendor/autoload.php' depende de tu estructura de carpetas
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    $mail = new PHPMailer(true);
    echo "PHPMailer está funcionando correctamente.";
} catch (Exception $e) {
    echo "Error al cargar PHPMailer: " . $e->getMessage();
}
