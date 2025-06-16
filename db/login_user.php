<?php
session_start();  // Inicia la sesión
include '../db/config.php';  // Incluye la configuración de la base de datos

// Verifica si los datos fueron enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];  // Recibe el correo
    $password = $_POST['password'];  // Recibe la contraseña

    // Prepara la consulta SQL para verificar si el usuario existe
    $stmt = $conn->prepare("SELECT id, nombre, email, password, role FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $user_name, $user_email, $user_password, $user_role);
    $stmt->fetch();

    // Verifica si el usuario existe y si la contraseña es correcta
    if ($stmt->num_rows == 1 && password_verify($password, $user_password)) {
        // Si es correcto, crea las variables de sesión
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $_SESSION['user_email'] = $user_email;
        $_SESSION['role'] = $user_role; // Guardamos el rol en la sesión

        session_write_close(); // Esto evita que la sesión se pierda

        // Redirige según el rol
        if ($user_role === "admin") {
            header("Location:" . $_SERVER['DOCUMENT_ROOT'] . "/JENVA/admin/admin_dashboard.php"); // Página del administrador
        } else {
            header("Location:" . $_SERVER['DOCUMENT_ROOT'] . "/JENVA/pages/dashboard.php"); // Página del usuario normal
        }
        exit();
    } else {
        // Si las credenciales son incorrectas, muestra un mensaje de error
        $error_message = "Correo electrónico o contraseña incorrectos. Intenta de nuevo.";
    }

    // Cierra la consulta
    $stmt->close();
    $conn->close();
}

?>

<!-- Si hay un error en el inicio de sesión, lo mostramos -->
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>
