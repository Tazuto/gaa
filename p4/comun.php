<?php
function conectar($base) {
    require __DIR__ . '/config.php';
    $dsn = "mysql:host=$host;port=$puerto;dbname=$base;";
    return new PDO($dsn . 'charset=utf8mb4', $usuario, $clave, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
}

function e($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

function inicio($titulo) {
    echo '<!doctype html><html lang="es"><head>';
    echo '<meta charset="UTF-8">';
    echo '<meta name="viewport"';
    echo ' content="width=device-width, initial-scale=1">';
    echo '<title>' . e($titulo) . '</title>';
    echo '<link rel="stylesheet" href="estilos.css">';
    echo '</head><body><main><h1>' . e($titulo) . '</h1>';
}

function fin() { 
    echo '</main></body></html>'; 
}

function tabla($filas) {
    if (!$filas) { 
        echo '<p>No hay registros.</p>'; 
        return; 
    }
    echo '<div class="tabla"><table><thead><tr>';
    foreach (array_keys($filas[0]) as $columna) {
        echo '<th>' . e($columna) . '</th>';
    }
    echo '</tr></thead><tbody>';
    foreach ($filas as $fila) {
        echo '<tr>';
        foreach ($fila as $valor) {
            echo '<td>' . e($valor) . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table></div>';
}

function fallo() {
    http_response_code(500);
    echo '<p>No se pudo completar la operación. Revise el servicio, ';
    echo 'las credenciales y la base de datos.</p>';
}