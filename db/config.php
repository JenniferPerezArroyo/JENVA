<?php
$host = "localhost"; // Dirección del servidor MySQL local
$user = "root"; // Usuario de MySQL en XAMPP
$pass = ""; // Contrasena (por defecto en XAMPP es vacia)
$dbname = "jenva_db"; // Nombre de tu base de datos

//Crear conexion - Puerto opcional. El puerto estándar es 3306, pero uso 3307
$conn = new mysqli($host, $user, $pass, $dbname,3307);

// Verificar la conexion
if ($conn->connect_error) {
    die("Error de conexion: " . $conn->connect_error);
}
?>
