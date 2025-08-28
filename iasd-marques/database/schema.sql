-- Database schema for IASD Marqués Attendance System
-- Charset and collation
SET NAMES utf8mb4;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS `iasd_marques` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `iasd_marques`;

-- usuarios
CREATE TABLE IF NOT EXISTS usuarios (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  pass_hash VARCHAR(255) NOT NULL,
  rol ENUM('admin','editor','viewer') NOT NULL DEFAULT 'viewer',
  activo TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- asistentes
CREATE TABLE IF NOT EXISTS asistentes (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  apellido VARCHAR(120) NOT NULL,
  telefono VARCHAR(30) NULL,
  email VARCHAR(160) NULL,
  edad INT NULL,
  sexo ENUM('M','F','O') NULL,
  direccion VARCHAR(255) NULL,
  estatus ENUM('miembro','visitante','nuevo_interesado') NOT NULL DEFAULT 'visitante',
  notas TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_asistentes_nombre (nombre, apellido),
  INDEX idx_asistentes_estatus (estatus),
  INDEX idx_asistentes_telefono (telefono),
  INDEX idx_asistentes_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- intereses (catalog)
CREATE TABLE IF NOT EXISTS intereses (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- asistente_interes (N:M)
CREATE TABLE IF NOT EXISTS asistente_interes (
  asistente_id INT UNSIGNED NOT NULL,
  interes_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (asistente_id, interes_id),
  CONSTRAINT fk_ai_asistente FOREIGN KEY (asistente_id) REFERENCES asistentes(id) ON DELETE CASCADE,
  CONSTRAINT fk_ai_interes FOREIGN KEY (interes_id) REFERENCES intereses(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- eventos
CREATE TABLE IF NOT EXISTS eventos (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(160) NOT NULL,
  tipo ENUM('regular','deportivo','eclesiastico','jornada_salud','otro') NOT NULL DEFAULT 'regular',
  fecha DATE NOT NULL,
  hora TIME NOT NULL,
  lugar VARCHAR(160) NOT NULL,
  notas TEXT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_eventos_fecha (fecha),
  INDEX idx_eventos_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- asistencias
CREATE TABLE IF NOT EXISTS asistencias (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  evento_id INT UNSIGNED NOT NULL,
  asistente_id INT UNSIGNED NOT NULL,
  presente TINYINT(1) NOT NULL DEFAULT 0,
  observacion VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uk_evento_asistente (evento_id, asistente_id),
  CONSTRAINT fk_asistencias_evento FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
  CONSTRAINT fk_asistencias_asistente FOREIGN KEY (asistente_id) REFERENCES asistentes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- plantillas WhatsApp
CREATE TABLE IF NOT EXISTS plantillas_wa (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL UNIQUE,
  cuerpo_texto TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- cola de WhatsApp simulada
CREATE TABLE IF NOT EXISTS wa_queue (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  asistente_id INT UNSIGNED NOT NULL,
  plantilla_id INT UNSIGNED NOT NULL,
  fecha_programada DATETIME NOT NULL,
  estado ENUM('pendiente','enviado','fallido') NOT NULL DEFAULT 'pendiente',
  intento INT NOT NULL DEFAULT 0,
  last_error VARCHAR(255) NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_wa_estado (estado),
  INDEX idx_wa_fecha (fecha_programada),
  CONSTRAINT fk_wa_asistente FOREIGN KEY (asistente_id) REFERENCES asistentes(id) ON DELETE CASCADE,
  CONSTRAINT fk_wa_plantilla FOREIGN KEY (plantilla_id) REFERENCES plantillas_wa(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- password resets
CREATE TABLE IF NOT EXISTS password_resets (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT UNSIGNED NOT NULL,
  token VARCHAR(64) NOT NULL UNIQUE,
  expira_en DATETIME NOT NULL,
  usado TINYINT(1) NOT NULL DEFAULT 0,
  CONSTRAINT fk_pr_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  INDEX idx_pr_token (token),
  INDEX idx_pr_expira (expira_en)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

