DELIMITER //
CREATE PROCEDURE fechaVencido()
BEGIN
    DECLARE v_fSalida DATE;
    DECLARE cur_final BOOL DEFAULT FALSE;
    DECLARE v_idHabitacion INT;

    DECLARE cursor1 CURSOR FOR
        SELECT r.fechasalida, dr.Habitacion_idHabitacion
        FROM Reserva r
        INNER JOIN DetalleReservaHabitacion dr ON dr.Reserva_idReserva = r.idReserva;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET cur_final = TRUE;

    OPEN cursor1;

    bucle: LOOP
        FETCH cursor1 INTO v_fSalida, v_idHabitacion;
        IF cur_final THEN
            LEAVE bucle;
        END IF;

        IF (CURDATE() >= v_fSalida) THEN
            UPDATE Habitacion
            SET estado = 1
            WHERE idHabitacion = v_idHabitacion;
        END IF;
    END LOOP;

    CLOSE cursor1;
END //
DELIMITER ;

