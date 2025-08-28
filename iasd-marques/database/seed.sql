USE `iasd_marques`;

-- intereses base
INSERT INTO intereses (nombre) VALUES
('Escuela Sabática'),
('Ministerio Joven'),
('Dorcas / ASA'),
('Música'),
('Evangelismo'),
('Deportes')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

-- usuario admin (password: Admin123!)
INSERT INTO usuarios (nombre, email, pass_hash, rol, activo)
VALUES ('Administrador', 'admin@demo.local',
        '$2y$10$d1J3j6u3a0pQ4xXy0z1S3O80mV6S4v1D8E3h2P9n4l2s7k9u8q1z2', 'admin', 1)
ON DUPLICATE KEY UPDATE email = email;
-- Nota: el hash corresponde a "Admin123!" generado con password_hash por defecto (bcrypt)

-- asistentes de ejemplo
INSERT INTO asistentes (nombre, apellido, telefono, email, edad, sexo, direccion, estatus, notas)
VALUES
('Juan', 'Pérez', '584121234567', 'juan.perez@example.com', 32, 'M', 'Av. Sanz del Marqués', 'miembro', 'Líder de música'),
('María', 'Gómez', '584149876543', 'maria.gomez@example.com', 28, 'F', 'Calle 3, El Marqués', 'visitante', 'Interesada en Escuela Sabática'),
('Luis', 'Rojas', '584126661111', NULL, 19, 'M', 'La California', 'nuevo_interesado', 'Vino por invitación');

-- relaciones intereses
INSERT INTO asistente_interes (asistente_id, interes_id)
SELECT a.id, i.id FROM asistentes a, intereses i WHERE a.nombre='María' AND i.nombre='Escuela Sabática'
ON DUPLICATE KEY UPDATE asistente_id = asistente_id;

-- eventos de ejemplo
INSERT INTO eventos (titulo, tipo, fecha, hora, lugar, notas) VALUES
('Culto de Sábado', 'eclesiastico', DATE_ADD(CURDATE(), INTERVAL 2 DAY), '09:00:00', 'Templo Principal', 'Servicio regular'),
('Jornada de Salud', 'jornada_salud', DATE_ADD(CURDATE(), INTERVAL 10 DAY), '08:00:00', 'Salón Multiusos', 'Chequeos básicos');

-- plantillas WhatsApp
INSERT INTO plantillas_wa (nombre, cuerpo_texto) VALUES
('Bienvenida', 'Hola {{nombre}}, ¡bienvenido a la IASD del Marqués!'),
('Recordatorio', 'Hola {{nombre}}, te recordamos el evento {{evento}} el {{fecha}}');

