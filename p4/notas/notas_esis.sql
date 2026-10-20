CREATE DATABASE notas_esis
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE notas_esis;

CREATE TABLE estudiante (
id_estudiante INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
codigo_estudiante VARCHAR(12) NOT NULL UNIQUE,
apellidos_nombres VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE docente (
id_docente INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
apellidos_nombres VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE curso (
id_curso INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
nombre VARCHAR(100) NOT NULL,
turno VARCHAR(20) NOT NULL,
id_docente INT UNSIGNED NOT NULL,
FOREIGN KEY (id_docente) REFERENCES docente(id_docente)
) ENGINE=InnoDB;

CREATE TABLE nota_curso (
id_nota INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
id_estudiante INT UNSIGNED NOT NULL,
id_curso INT UNSIGNED NOT NULL,
nota DECIMAL(4,2) NOT NULL,
UNIQUE KEY uq_estudiante_curso (id_estudiante, id_curso),
FOREIGN KEY (id_estudiante) REFERENCES estudiante(id_estudiante),
FOREIGN KEY (id_curso) REFERENCES curso(id_curso),
CHECK (nota BETWEEN 0 AND 20)
) ENGINE=InnoDB;

INSERT INTO estudiante (codigo_estudiante, apellidos_nombres)
VALUES ('20210001', 'Torres Ana'),
('20210002', 'Quispe Luis'),
('20210003', 'Flores Maria');

INSERT INTO docente (apellidos_nombres)
VALUES ('Pérez Elena'), ('Ramos Carlos');

INSERT INTO curso (nombre, turno, id_docente)
VALUES ('Ingenieria Web', 'Mañana', 1),
('Ingenieria de Software', 'Tarde', 2);

INSERT INTO nota_curso (id_estudiante, id_curso, nota)
VALUES (1, 1, 15.00), (2, 1, 12.50), (3, 2, 18.00);