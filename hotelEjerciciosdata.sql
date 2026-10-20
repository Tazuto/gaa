USE hoteldb;

INSERT INTO Persona (nombres, apellidos, docidentidad)
VALUES
('Juan', 'Pérez', '12345678'),     -- Cliente reserva 1
('Ana', 'Torres', '87654321'),     -- Acompañante reserva 1
('Carlos', 'Ramos', '11223344'),   -- Cliente reserva 2
('Lucía', 'Gómez', '44332211');    -- Acompañante reserva 2

INSERT INTO Cliente (idCliente, celular, correo)
VALUES
(1, '987654321', 'juan@gmail.com'),
(2, '999888777', 'carlos@gmail.com');


INSERT INTO Habitacion (numero, capacidad, precio_noche, estado)
VALUES
('101', 1, 100.00, 0),  -- Ocupada (0)
('102', 1, 100.00, 0),  -- Ocupada (0)
('210', 2, 180.00, 0);  -- Ocupada (0)

INSERT INTO Reserva (fechareserva, fechainicio, fechasalida, estadoreserva, Cliente_idCliente)
VALUES
(NOW(), '2025-11-07', '2025-10-06', 0, 1), -- Reserva 1 (Juan)
(NOW(), '2025-11-15', '2025-10-05', 0, 2); -- Reserva 2 (Carlos)

INSERT INTO DetalleReservaHabitacion (Reserva_idReserva, Habitacion_idHabitacion)
VALUES
(1, 1),  -- Reserva 1 → Habitación 101
(1, 2),  -- Reserva 1 → Habitación 102
(2, 3);  -- Reserva 2 → Habitación 210

INSERT INTO DetalleAsignacionHabitacion (escliente, Persona_idPersona, DetalleReservaHabitacion_idDetalleReservaHabitacion)
VALUES
(1, 1, 1), -- Juan (cliente) ocupa habitación 101
(0, 2, 2), -- Ana (acompañante) ocupa habitación 102
(1, 3, 3), -- Carlos (cliente) ocupa habitación 210
(0, 4, 3); -- Lucía (acompañante) ocupa habitación 210

SELECT * FROM Habitacion;
