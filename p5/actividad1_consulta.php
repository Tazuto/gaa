<?php
require __DIR__ . '/config.php';
function e($valor) { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$busqueda = trim($_GET['q'] ?? '');
$resultados = [];

if ($busqueda !== '') {
    $stmt = $pdo->prepare('SELECT codigo, nombres, correo, escuela, ciclo, modalidad
                           FROM registros_academicos
                           WHERE codigo LIKE :codigo OR nombres LIKE :nombres
                           ORDER BY nombres');
    $criterio = '%' . $busqueda . '%';
    $stmt->execute(['codigo' => $criterio, 'nombres' => $criterio]);
    $resultados = $stmt->fetchAll();
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Consulta GET</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Actividad 1 - Consulta con GET</h1><p>Busque registros académicos por código universitario o nombre.</p>
<form action="actividad1_consulta.php" method="get"><div class="grupo"><label for="q">Criterio de búsqueda</label><input id="q" name="q" type="search" required value="<?= e($busqueda) ?>" placeholder="Ejemplo: 20260001 o Ana"></div><div class="acciones"><button type="submit">Buscar estudiante</button><a class="boton" href="index.php">Volver</a></div></form>
<?php if ($busqueda !== ''): ?><section class="resultado"><h2>Resultado de la consulta</h2><p>Criterio recibido por GET: <strong><?= e($busqueda) ?></strong>.</p><?php if (!$resultados): ?><p>No se encontraron coincidencias.</p><?php else: ?><div style="overflow-x:auto"><table class="tabla-datos"><thead><tr><th>Código</th><th>Estudiante</th><th>Correo</th><th>Escuela</th><th>Ciclo</th><th>Modalidad</th></tr></thead><tbody><?php foreach ($resultados as $fila): ?><tr><td><?= e($fila['codigo']) ?></td><td><?= e($fila['nombres']) ?></td><td><?= e($fila['correo']) ?></td><td><?= e($fila['escuela']) ?></td><td><?= e($fila['ciclo']) ?></td><td><?= e($fila['modalidad']) ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?></section><?php endif; ?>
</main></body></html>