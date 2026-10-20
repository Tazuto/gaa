<?php
require_once __DIR__ . '/comun.php';
require __DIR__ . '/config.php';
inicio('Contactos con MySQLi');
echo '<form method="get"><label>ID del contacto';
echo '<input type="number" name="id" min="1" required></label>';
echo '<button>Buscar</button></form>';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $cn = new mysqli($host, $usuario, $clave, 'agenda', $puerto);
    $cn->set_charset('utf8mb4');
    $resultado = $cn->query('SELECT * FROM contacto ORDER BY id');
    echo '<h2>Todos los contactos</h2>';
    $filas = [];
    while ($fila = $resultado->fetch_assoc()) { $filas[] = $fila; }
    tabla($filas);
    if (isset($_GET['id'])) {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null || $id < 1) {
            echo '<p>Ingrese un ID entero positivo.</p>';
        } else {
            $stmt = $cn->prepare(
                'SELECT nombre_apellido FROM contacto WHERE id = ?'
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->bind_result($nombre);
            echo '<h2>Resultado de búsqueda</h2>';
            if ($stmt->fetch()) { echo '<p>' . e($nombre) . '</p>'; }
            else { echo '<p>No existe ese contacto.</p>'; }
            $stmt->close();
        }
    }
    $cn->close();
} catch (mysqli_sql_exception $e) { fallo(); }
fin();