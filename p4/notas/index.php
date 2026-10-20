<?php
require_once __DIR__ . '/comun.php';
try {
    $sql = 'SELECT n.id_nota, e.codigo_estudiante,
e.apellidos_nombres AS estudiante,
c.nombre AS curso, d.apellidos_nombres AS docente,
c.turno, n.nota
FROM nota_curso n
INNER JOIN estudiante e ON n.id_estudiante = e.id_estudiante
INNER JOIN curso c ON n.id_curso = c.id_curso
INNER JOIN docente d ON c.id_docente = d.id_docente
ORDER BY n.id_nota DESC';
    $filas = $pdo->query($sql)->fetchAll();
} catch (PDOException $e) { fallo(); exit; }
inicio('Notas ESIS');
?>
<nav><a href="create.php">Registrar nota</a> |
<a href="../index.php">Menú de usuarios</a></nav>
<?php if (!$filas): ?>
<p>No hay notas registradas.</p>
<?php else: ?>
<div class="tabla"><table>
<thead><tr>
<th>ID</th><th>Código</th><th>Estudiante</th><th>Curso</th>
<th>Docente</th><th>Turno</th><th>Nota</th><th>Acciones</th>
</tr></thead>
<tbody>
<?php foreach ($filas as $f): ?>
<tr>
<td><?= e($f['id_nota']) ?></td>
<td><?= e($f['codigo_estudiante']) ?></td>
<td><?= e($f['estudiante']) ?></td>
<td><?= e($f['curso']) ?></td>
<td><?= e($f['docente']) ?></td>
<td><?= e($f['turno']) ?></td>
<td><?= e($f['nota']) ?></td>
<td>
<a href="update.php?id=<?= e($f['id_nota']) ?>">Editar</a>
<a href="delete.php?id=<?= e($f['id_nota']) ?>">Eliminar</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table></div>
<?php endif; ?>
<?php fin(); ?>