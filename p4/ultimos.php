<?php
require_once __DIR__ . '/comun.php';
inicio('Últimos cinco accesos');

try {
    $pdo = conectar('registro_web');
    $stmt = $pdo->query(
        'SELECT id, ip, fecha_hora, version_servidor 
        FROM acceso ORDER BY id DESC LIMIT 5'
    );
    tabla($stmt->fetchAll());
    $stmt = null;
    $pdo = null;
} catch (PDOException $e) { fallo(); }

echo '<p><a href="registrar.php">Registrar otro acceso</a></p>';
fin();