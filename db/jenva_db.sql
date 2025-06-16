
-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS jenva_db;
USE jenva_db;

-- Crear la tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente', -- Nuevo campo 'role'
    acepta_privacidad TINYINT(1) NOT NULL DEFAULT 0, -- Nuevo campo para consentimiento
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear la tabla de tareas
CREATE TABLE IF NOT EXISTS tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    estado ENUM('Pendiente', 'En Proceso','Pendiente de cliente','Pendiente de terceros', 'Completada') DEFAULT 'Pendiente',
    anotacion TEXT, -- Nueva columna para anotaciones del administrador
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Insertar usuario administrador por defecto
INSERT INTO usuarios (nombre, email, password, role, acepta_privacidad) 
VALUES ('Administrador', 'admin@jenva.es', '$2y$10$QWEiZrK6LlUIJ0vXwhzGmOshHR3c5WSxWCFu6D.MsD3Rvg9eOKB82', 'admin', 1)
ON DUPLICATE KEY UPDATE email=email;
