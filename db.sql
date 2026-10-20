CREATE DATABASE examen_mvc;
USE examen_mvc;

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    precio DECIMAL(7,2)
);