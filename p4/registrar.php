<?php
require_once __DIR__ . '/comun.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = conectar('registro_web');
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'desconocida';
        $fecha = (new DateTimeImmutable('now',
            new DateTimeZone('America/Lima')))->format('Y-m-d H:i:s');
        $version = $pdo->query('SELECT VERSION()')->fetchColumn();
        
        $stmt = $pdo->prepare('INSERT INTO acceso 
            (ip, fecha_hora, version_servidor) VALUES (?, ?, ?)');
        $stmt->execute([$ip, $fecha, $version]);
        
        header('Location: ultimos.php');
        exit;
    } catch (PDOException $e) {
        inicio('Registro de accesos'); fallo(); fin(); exit;
    }
}

inicio('Registro de accesos');
echo '<form method="post"><button>Registrar mi acceso</button></form>';
echo '<a href="ultimos.php">Ver los últimos cinco accesos</a>';
fin();