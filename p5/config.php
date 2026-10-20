<?php
$host = 'localhost';
$basedatos = 'laboratorio05';
$usuario = 'root';
$clave = '';
$dsn = "mysql:host=$host;dbname=$basedatos;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $usuario, $clave, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    exit('No fue posible conectar con la base de datos. Verifique MySQL y config.php.');
}