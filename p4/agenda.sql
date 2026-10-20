CREATE DATABASE IF NOT EXISTS agenda
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agenda;
CREATE TABLE IF NOT EXISTS contacto (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_apellido VARCHAR(255) NOT NULL,
    genero VARCHAR(6) NOT NULL,
    telefono VARCHAR(75) NOT NULL,
    email VARCHAR(255) NOT NULL,
    ciudad VARCHAR(255) NOT NULL,
    pais VARCHAR(255) NOT NULL
);
INSERT INTO contacto
    (nombre_apellido, genero, telefono, email, ciudad, pais)
VALUES
    ('Samuel Lopez', 'hombre', '052883377', 'sm@mt.co', 'Rosario', 'Argentina'),
    ('Ana Gabriel', 'mujer', '988344433', 'ag@mt.co', 'Barranquilla', 'Colombia'),
    ('Juan Vera', 'hombre', '945003783', 'jv@pt.co', 'Santa Marta', 'Colombia'),
    ('Veronica Lopez', 'mujer', '987256432','vl@pt.co', 'Parana', 'Argentina');