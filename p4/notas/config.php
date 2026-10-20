<?php
require __DIR__ . '/../config.php';
$dsn = "mysql:host=$host;port=$puerto;dbname=notas_esis;";
try {
    $pdo = new PDO($dsn . 'charset=utf8mb4', $usuario, $clave, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('No se pudo conectar. Revise el servicio y config.php.');
}