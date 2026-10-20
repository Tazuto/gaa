<?php
require_once __DIR__ . '/../comun.php';
require_once __DIR__ . '/../soporte.php';
require __DIR__ . '/config.php';

function opciones($pdo) {
    $est = $pdo->query('SELECT * FROM estudiante ORDER BY apellidos_nombres')->fetchAll();
    $cur = $pdo->query('SELECT * FROM curso ORDER BY nombre')->fetchAll();
    return [$est, $cur];
}

function datos_nota() {
    return [
        'id_estudiante' => filter_input(INPUT_POST, 'id_estudiante', FILTER_VALIDATE_INT),
        'id_curso' => filter_input(INPUT_POST, 'id_curso', FILTER_VALIDATE_INT),
        'nota' => filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_FLOAT)
    ];
}

function validar_nota($v, $est, $cur) {
    if (!in_array($v['id_estudiante'], array_column($est, 'id_estudiante')) ||
        !in_array($v['id_curso'], array_column($cur, 'id_curso'))) {
        return 'Seleccione un estudiante y un curso existentes.';
    }
    if ($v['nota'] === false || $v['nota'] === null || $v['nota'] < 0 || $v['nota'] > 20) {
        return 'La nota debe ser un número entre 0 y 20.';
    }
    if (abs($v['nota'] * 100 - round($v['nota'] * 100)) > 0.00001) {
        return 'Use como máximo dos decimales.';
    }
    return '';
}

function cargar_nota($pdo, $id) {
    $s = $pdo->prepare('SELECT * FROM nota_curso WHERE id_nota = :id');
    $s->execute(['id' => $id]);
    $v = $s->fetch();
    if (!$v) {
        http_response_code(404);
        exit('La nota no existe.');
    }
    return $v;
}

function formulario_nota($v, $est, $cur, $error, $id = null) {
?>
<p class="error" role="alert"><?= e($error) ?></p>
<form method="post">
<?php token_formulario(); ?>
<?php if ($id !== null): ?>
<input type="hidden" name="id" value="<?= e($id) ?>">
<?php endif; ?>
<label>Estudiante
<select name="id_estudiante" required>
<option value="">Seleccione</option>
<?php foreach ($est as $fila): ?>
<option value="<?= e($fila['id_estudiante']) ?>"
<?= (string)$v['id_estudiante'] === (string)$fila['id_estudiante'] ? 'selected' : '' ?>>
<?= e($fila['codigo_estudiante']) ?> - <?= e($fila['apellidos_nombres']) ?>
</option>
<?php endforeach; ?>
</select>
</label>
<label>Curso
<select name="id_curso" required>
<option value="">Seleccione</option>
<?php foreach ($cur as $fila): ?>
<option value="<?= e($fila['id_curso']) ?>"
<?= (string)$v['id_curso'] === (string)$fila['id_curso'] ? 'selected' : '' ?>>
<?= e($fila['nombre']) ?> <?= e($fila['turno']) ?>
</option>
<?php endforeach; ?>
</select>
</label>
<label>Nota de 0 a 20
<input type="number" name="nota" min="0" max="20" step="0.01" required value="<?= e($v['nota']) ?>">
</label>
<button>Guardar nota</button>
<a href="index.php">Cancelar</a>
</form>
<?php
}