<?php
// Iniciar sesión para gestionar el estado del usuario
session_start();

// Incluir el archivo de configuración para la conexión a la base de datos
include 'config.php';

// Verificar si la solicitud proviene de un formulario mediante el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar la entrada de datos para eliminar espacios en blanco innecesarios
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);

    // Cifrar la contraseña utilizando password_hash para mayor seguridad
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verificar si el correo electrónico ya está registrado en la base de datos
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // Si el correo ya está registrado, almacenar un mensaje de error en la sesión y redirigir al usuario
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "El correo ya está registrado. Intenta con otro.";
        header("Location: ../register.php");
        exit();
    }

    // Cerrar la consulta antes de realizar la inserción
    $stmt->close();

    // Insertar el nuevo usuario en la base de datos con una consulta preparada
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $password);
    
    // Ejecutar la consulta de inserción y verificar el resultado
    if ($stmt->execute()) {
        // Si el registro es exitoso, almacenar mensaje de éxito en la sesión y redirigir a login
        $_SESSION['success'] = "Registro exitoso. Ahora puedes iniciar sesión.";
        header("Location: ../login.php");
    } else {
        // Si hay un error en el registro, almacenar mensaje en la sesión y redirigir a la página de registro
        $_SESSION['error'] = "Hubo un error en el registro. Inténtalo de nuevo.";
        header("Location: ../register.php");
    }

    // Cerrar la consulta y la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Si la solicitud no es POST, redirigir al usuario a la página de registro
    header("Location: ../register.php");
    exit();
}
