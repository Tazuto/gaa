<?php
require __DIR__ . '/config.php';
function e($valor) { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$stmt = $pdo->query('SELECT id, codigo, nombres, correo, escuela, ciclo, modalidad, creado_en
                     FROM registros_academicos ORDER BY id DESC');
$registros = $stmt->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Registros académicos</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Registros académicos</h1>
<?php if (!$registros): ?><p class="nota">Todavía no existen registros en la base de datos.</p>
<?php else: ?><div style="overflow-x:auto"><table class="tabla-datos"><thead><tr><th>ID</th><th>Código</th><th>Estudiante</th><th>Correo</th><th>Escuela</th><th>Ciclo</th><th>Modalidad</th><th>Fecha</th></tr></thead><tbody>
<?php foreach ($registros as $fila): ?><tr><td><?= e($fila['id']) ?></td><td><?= e($fila['codigo']) ?></td><td><?= e($fila['nombres']) ?></td><td><?= e($fila['correo']) ?></td><td><?= e($fila['escuela']) ?></td><td><?= e($fila['ciclo']) ?></td><td><?= e($fila['modalidad']) ?></td><td><?= e($fila['creado_en']) ?></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?>
<p class="acciones"><a class="boton" href="ejemplo_registro.php">Nuevo registro</a><a class="boton" href="index.php">Volver</a></p>
</main></body></html>