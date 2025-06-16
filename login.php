<?php
session_start(); // Inicia la sesión para poder usar $_SESSION

include 'db/config.php'; // Conecta a la base de datos usando tus datos en config.php

// Si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos email y password del formulario
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Preparamos y ejecutamos la consulta para obtener usuario
    $stmt = $conn->prepare("SELECT id, nombre, password, role FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    // Enlazamos resultados
    $stmt->bind_result($user_id, $user_name, $hashed_password, $role);
    $stmt->fetch();
    $stmt->close();

    // Verificamos existencia de usuario y validez de la contraseña
    if ($user_id && password_verify($password, $hashed_password)) {
        // Guardamos en sesión los datos del usuario
        $_SESSION['user_id']    = $user_id;
        $_SESSION['user_name']  = $user_name;
        $_SESSION['role']       = $role;
        $_SESSION['user_email'] = $email; // necesario para recover

        // Redirigimos según rol
        if ($role === 'admin') {
            header("Location: /JENVA/admin/admin_dashboard.php");
        } else {
            header("Location: /JENVA/pages/dashboard.php");
        }
        exit();
    } else {
        // Si algo falla, preparamos mensaje de error
        $error_message = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - JenVA</title>
    <!-- Carga Bootstrap desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Tus estilos personalizados -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">JenVA</a>
        </div>
    </nav>
    
    <div class="container mt-5">
        <h2 class="text-center">Iniciar Sesión</h2>
        <!-- Formulario de login -->
        <form action="" method="POST" class="mx-auto" style="max-width: 400px;">
            <!-- Mostramos error si existe -->
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <!-- Campo email -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Campo contraseña con botón para mostrar/ocultar -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input 
                        type="password"
                        class="form-control"
                        id="password"
                        name="password"
                        required
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                        title="Debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números."
                    >
                    <!-- Botón que alterna visibilidad -->
                    <button 
                        class="btn btn-outline-secondary"
                        type="button"
                        id="toggle-password"
                        title="Mostrar / Ocultar contraseña"
                    >👁️</button>
                </div>
            </div>

            <!-- Botón enviar -->
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>

        <!-- Enlace “¿Olvidaste tu contraseña?” -->
        <p class="text-center mt-2">
            <a href="#" id="forgot-link">¿Olvidaste tu contraseña?</a>
        </p>

        <!-- Script para manejar “olvidé mi contraseña” -->
        <script>
        document.getElementById('forgot-link').addEventListener('click', function(e) {
          e.preventDefault();

          // 1) Leemos el email ya escrito en el formulario
          const userEmail = document.getElementById('email').value.trim();
          if (!userEmail) {
            return alert('Por favor, escribe tu correo en el campo de arriba primero.');
          }

          alert('Se enviará un email al correo: ' + userEmail + '. Revise su buzón.');

          // 2) Lanzamos fetch POST a notify_pass.php, enviando JSON con { email }
          fetch('db/notify_pass.php', {
            method: 'POST',
            credentials: 'same-origin',       // envía cookies de sesión
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ email: userEmail })
          })
          .then(response => {
            if (!response.ok) throw new Error('HTTP ' + response.status);
            return response.json();          // esperamos JSON de respuesta
          })
          .then(json => {
            if (!json.ok) {
              // si ok==false, mostramos error
              console.error('Notify error:', json.msg);
              alert('No se pudo enviar el email: ' + json.msg);
            } else {
              // éxito
              console.log('Email enviado correctamente');
              alert('Email de recuperación enviado con éxito.');
            }
          })
          .catch(err => {
            // capturamos cualquier fallo de red o parseo
            console.error('Fetch error:', err);
            alert('Error en la petición de recuperación.');
          });
        });
        </script>

        <!-- Enlace a registro -->
        <p class="text-center mt-3">
            ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
        </p>
    </div>

    <!-- Carga Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para alternar visibilidad de contraseña -->
    <script>
    // Referencias al input y botón
    const pwdInput  = document.getElementById('password');
    const toggleBtn = document.getElementById('toggle-password');

    toggleBtn.addEventListener('click', () => {
      if (pwdInput.type === 'password') {
        pwdInput.type = 'text';          // lo volvemos visible
        toggleBtn.textContent = '🚫👁️';  // ojo tachado
      } else {
        pwdInput.type = 'password';      // lo volvemos oculto
        toggleBtn.textContent = '👁️';    // ojo normal
      }
    });
    </script>
</body>
</html>
