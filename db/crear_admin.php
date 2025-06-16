<?php
// Conectar a la base de datos
include 'config.php';

$admin_email = "admin@jenva.es";
$admin_password = password_hash("Admin1234", PASSWORD_DEFAULT); // Encriptamos la contraseña
$admin_name = "Administrador";
$admin_role = "admin";

// Insertar usuario administrador con la contraseña encriptada
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, role) 
                        VALUES (?, ?, ?, ?) 
                        ON DUPLICATE KEY UPDATE password = VALUES(password)");
$stmt->bind_param("ssss", $admin_name, $admin_email, $admin_password, $admin_role);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Administrador insertado correctamente.";
?>
