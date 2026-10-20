<?php
echo "<h2>Bienvenido al Examen de Laboratorio de MVC</h2>";
require_once 'controlador/Controlador.php';
(new Controlador())->procesarSolicitud();