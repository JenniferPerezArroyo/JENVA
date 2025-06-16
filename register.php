<?php
include 'db/config.php';

// Verificar si la solicitud es de tipo POST (formulario enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    // Hashear la contraseña para mayor seguridad antes de almacenarla
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar contraseña
    // Asignar un rol predeterminado al usuario nuevo
    $role = "cliente"; // Rol predeterminado
    // Verificar si el usuario ha aceptado la política de privacidad (checkbox)
    $acepta_privacidad = isset($_POST['privacidad']) ? 1 : 0; // Verificamos si marcó la casilla

   
   // Preparar una consulta para verificar si el correo electrónico ya está registrado 
    $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    // Si el correo ya existe, mostrar un mensaje de error
    if ($stmt_check->num_rows > 0) {
        $error_message = "Este correo ya está registrado.";
    } else {
        // Insertar el nuevo usuario incluyendo el consentimiento
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, role, acepta_privacidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombre, $email, $password, $role, $acepta_privacidad);
        
        // Ejecutar la consulta de inserción y verificar si fue exitosa
        if ($stmt->execute()) {
            // Redirigir al usuario a la página de login con un mensaje de éxito
            header("Location: login.php?registro=exitoso");
            exit();
        } else {
            // Mostrar mensaje de error en caso de fallo en la inserción
            $error_message = "Error al registrar. Inténtalo de nuevo.";
        }

       // Cerrar la consulta de inserción
        $stmt->close();
    }
    // Cerrar la consulta de verificación de correo
    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - JenVA</title>
    <!-- Enlace a Bootstrap para estilos mejorados -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
     <!-- Barra de navegación superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">JenVA</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="text-center">Registro de Usuario</h2>
        <!-- Formulario de registro -->
        <form action="" method="POST" class="mx-auto" style="max-width: 400px;">
            <!-- Mostrar mensaje de error si existe -->
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            <!-- Campo para ingresar el nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <!-- Campo para ingresar el correo electrónico -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" requiredpattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números.">
                        <button class="btn btn-outline-secondary" type="button" id="toggle-password"
                        title="Mostrar / Ocultar contraseña">👁️ </button>        
                </div>
            </div>
          

            <!-- Casilla de aceptación de la política de privacidad -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="privacidad" name="privacidad" required>
                <label class="form-check-label" for="privacidad">
                    Acepto la <a href="legal/politica_privacidad.php" target="_blank">Política de Privacidad</a>.
                </label>
            </div>
            <!-- Botón para enviar el formulario -->
            <button type="submit" class="btn btn-primary w-100">Registrarse</button>
        </form>
        <!-- Enlace para redirigir al usuario si ya tiene cuenta -->
        <p class="text-center mt-3">¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
    </div>
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Capturar el campo de contraseña y el botón de alternancia
        const pwdInput  = document.getElementById('password');
        const toggleBtn = document.getElementById('toggle-password');
        // Evento para cambiar el tipo de input y mostrar/ocultar contraseña
        toggleBtn.addEventListener('click', () => {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                toggleBtn.textContent = '🚫👁️';  // ojo tachado
            } else {
                pwdInput.type = 'password';
                toggleBtn.textContent = '👁️';    // ojo normal
            }
        });
    </script>
</body>
</html>
