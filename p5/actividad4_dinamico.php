<?php
require __DIR__ . '/config.php';
function e($valor) { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$paso = $_POST['paso'] ?? 'inicio';
$cantidad = (int) ($_POST['cantidad'] ?? 0);
$nombreEquipo = trim($_POST['nombre_equipo'] ?? '');
$mensaje = '';

if ($paso === 'procesar') {
    $integrantes = $_POST['integrantes'] ?? [];
    try {
        $pdo->beginTransaction();
        $stmtEquipo = $pdo->prepare('INSERT INTO equipos (nombre) VALUES (:nombre)');
        $stmtEquipo->execute(['nombre' => $nombreEquipo]);
        $equipoId = (int) $pdo->lastInsertId();

        $stmtIntegrante = $pdo->prepare('INSERT INTO integrantes (equipo_id, nombre)
                                        VALUES (:equipo_id, :nombre)');
        foreach ($integrantes as $integrante) {
            $stmtIntegrante->execute([
                'equipo_id' => $equipoId,
                'nombre' => trim($integrante)
            ]);
        }
        $pdo->commit();
        $mensaje = 'Equipo e integrantes guardados correctamente.';
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) { $pdo->rollBack(); }
        $mensaje = 'No fue posible guardar el equipo.';
    }
}

$equipos = $pdo->query("SELECT e.nombre, COUNT(i.id) AS cantidad,
                        GROUP_CONCAT(i.nombre ORDER BY i.id SEPARATOR ', ') AS integrantes
                        FROM equipos e
                        LEFT JOIN integrantes i ON i.equipo_id = e.id
                        GROUP BY e.id, e.nombre
                        ORDER BY e.id DESC LIMIT 10")->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Formulario dinámico</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Actividad 4 - Formulario dinámico con PHP</h1>
<?php if ($paso === 'inicio'): ?>
<p>Indique el equipo y la cantidad de integrantes. PHP generará los controles en el siguiente envío.</p><form action="actividad4_dinamico.php" method="post"><input type="hidden" name="paso" value="generar"><div class="grupo"><label for="nombre_equipo">Nombre del equipo</label><input id="nombre_equipo" name="nombre_equipo" type="text" required></div><div class="grupo"><label for="cantidad">Cantidad de integrantes</label><input id="cantidad" name="cantidad" type="number" min="1" max="5" required></div><div class="acciones"><button type="submit">Generar formulario</button><a class="boton" href="index.php">Volver</a></div></form>
<?php elseif ($paso === 'generar' && $cantidad >= 1 && $cantidad <= 5): ?>
<form action="actividad4_dinamico.php" method="post"><input type="hidden" name="paso" value="procesar"><input type="hidden" name="cantidad" value="<?= $cantidad ?>"><input type="hidden" name="nombre_equipo" value="<?= e($nombreEquipo) ?>"><fieldset><legend>Integrantes de <?= e($nombreEquipo) ?></legend><?php for ($i=1; $i <= $cantidad; $i++): ?><div class="grupo"><label for="nombre<?= $i ?>">Integrante <?= $i ?></label><input id="nombre<?= $i ?>" name="integrantes[]" type="text" required></div><?php endfor; ?></fieldset><div class="acciones"><button type="submit">Guardar equipo</button><a class="boton" href="actividad4_dinamico.php">Reiniciar</a></div></form>
<?php elseif ($paso === 'procesar'): ?><section class="resultado"><h2>Resultado</h2><p><?= e($mensaje) ?></p></section><p><a class="boton" href="actividad4_dinamico.php">Registrar otro equipo</a></p>
<?php else: ?><section class="resultado"><p>La cantidad debe estar entre 1 y 5.</p></section><p><a class="boton" href="actividad4_dinamico.php">Intentar nuevamente</a></p><?php endif; ?>
<h2>Equipos guardados</h2><?php if (!$equipos): ?><p class="nota">Todavía no existen equipos.</p><?php else: ?><div style="overflow-x:auto"><table class="tabla-datos"><thead><tr><th>Equipo</th><th>Cantidad</th><th>Integrantes</th></tr></thead><tbody><?php foreach ($equipos as $fila): ?><tr><td><?= e($fila['nombre']) ?></td><td><?= e($fila['cantidad']) ?></td><td><?= e($fila['integrantes']) ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</main></body></html>