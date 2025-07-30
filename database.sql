-- Script para crear la base de datos del sistema de registro de asistentes
-- IASD del Marqués - Sistema de Control de Asistencia

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS iasd_asistencia;
USE iasd_asistencia;

-- Tabla para usuarios del sistema (administradores)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla para registrar asistentes
CREATE TABLE asistentes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_completo VARCHAR(150) NOT NULL,
    tipo_asistente ENUM('miembro', 'visitante', 'interesado') NOT NULL,
    edad INT NOT NULL,
    observaciones TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    usuario_registro VARCHAR(50),
    FOREIGN KEY (usuario_registro) REFERENCES usuarios(usuario)
);

-- Insertar un usuario administrador por defecto
-- Usuario: admin, Contraseña: admin123
INSERT INTO usuarios (usuario, password, nombre) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador IASD');

-- Insertar algunos datos de ejemplo para pruebas
INSERT INTO asistentes (nombre_completo, tipo_asistente, edad, observaciones, usuario_registro) VALUES
('María González', 'miembro', 35, 'Miembro activo desde 2020', 'admin'),
('Juan Pérez', 'visitante', 28, 'Primera visita', 'admin'),
('Ana López', 'interesado', 42, 'Interesada en estudios bíblicos', 'admin');