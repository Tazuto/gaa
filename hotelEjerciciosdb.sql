/*DROP DATABASE IF EXISTS hoteldb;*/
CREATE DATABASE hoteldb;
USE hoteldb;

CREATE TABLE Persona (
	idPersona INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(90),
    apellidos VARCHAR(90),
    docidentidad VARCHAR(10)
);

CREATE TABLE Cliente (
	idCliente INT PRIMARY KEY,
    celular VARCHAR(20),
    correo VARCHAR(90),
    FOREIGN KEY (idCliente) REFERENCES Persona(idPersona) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Reserva (
	idReserva INT AUTO_INCREMENT PRIMARY KEY,
    fechareserva DATETIME,
    fechainicio DATE,
    fechasalida DATE,
    estadoreserva INT,
    Cliente_idCliente INT,
    FOREIGN KEY (Cliente_idCliente) REFERENCES Cliente(idCliente) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE Habitacion (
	idHabitacion INT AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(6),
    capacidad INT,
    precio_noche DECIMAL(10,2),
    estado INT
);

CREATE TABLE DetalleReservaHabitacion (
	idDetalleReservaHab INT AUTO_INCREMENT PRIMARY KEY,
    Reserva_idReserva INT,
    Habitacion_idHabitacion INT,
    FOREIGN KEY (Reserva_idReserva) REFERENCES Reserva(idReserva) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (Habitacion_idHabitacion) REFERENCES Habitacion(idHabitacion) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE DetalleAsignacionHabitacion (
	idDetalleAsignacionHab INT AUTO_INCREMENT PRIMARY KEY,
    escliente TINYINT,
    Persona_idPersona INT,
    DetalleReservaHabitacion_idDetalleReservaHabitacion INT,
    FOREIGN KEY (Persona_idPersona) REFERENCES Persona(idPersona) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (DetalleReservaHabitacion_idDetalleReservaHabitacion) REFERENCES DetalleReservaHabitacion(idDetalleReservaHab) ON UPDATE CASCADE ON DELETE CASCADE
);
