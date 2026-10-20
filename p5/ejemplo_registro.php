<?php
require __DIR__ . '/config.php';
function e($valor) { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$enviado = $_SERVER['REQUEST_METHOD'] === 'POST';
$mensaje = '';

if ($enviado) {
    try {
        $sql = 'INSERT INTO registros_academicos
                (codigo, nombres, correo, fecha_nacimiento, escuela, ciclo, modalidad)
                VALUES (:codigo, :nombres, :correo, :fecha, :escuela, :ciclo, :modalidad)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'codigo' => trim($_POST['codigo'] ?? ''),
            'nombres' => trim($_POST['nombres'] ?? ''),
            'correo' => trim($_POST['correo'] ?? ''),
            'fecha' => $_POST['fecha'] ?? '',
            'escuela' => $_POST['escuela'] ?? '',
            'ciclo' => (int) ($_POST['ciclo'] ?? 0),
            'modalidad' => $_POST['modalidad'] ?? ''
        ]);
        $mensaje = 'Registro guardado correctamente con el ID ' . $pdo->lastInsertId() . '.';
    } catch (PDOException $e) {
        $mensaje = $e->getCode() === '23000'
            ? 'El código universitario ya se encuentra registrado.'
            : 'No fue posible guardar el registro.';
    }
}
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Registro académico</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Registro académico</h1><p>Ejemplo guiado de formulario procesado con PHP y guardado en MySQL.</p>
<form action="ejemplo_registro.php" method="post">
<fieldset><legend>Datos del estudiante</legend>
<div class="grupo"><label for="codigo">Código universitario</label><input id="codigo" name="codigo" type="text" required maxlength="10" placeholder="Ejemplo: 20260001"></div>
<div class="grupo"><label for="nombres">Nombres y apellidos</label><input id="nombres" name="nombres" type="text" required></div>
<div class="grupo"><label for="correo">Correo institucional</label><input id="correo" name="correo" type="email" required placeholder="usuario@unjbg.edu.pe"></div>
<div class="grupo"><label for="fecha">Fecha de nacimiento</label><input id="fecha" name="fecha" type="date" required></div>
</fieldset>
<fieldset><legend>Información académica</legend>
<div class="grupo"><label for="escuela">Escuela profesional</label><select id="escuela" name="escuela" required><option value="">Seleccione una opción</option><option>Ingeniería de Sistemas</option><option>Ingeniería Civil</option><option>Ingeniería Ambiental</option></select></div>
<div class="grupo"><label for="ciclo">Ciclo de estudios</label><input id="ciclo" name="ciclo" type="number" min="1" max="10" required></div>
<div class="grupo"><label for="modalidad">Modalidad</label><select id="modalidad" name="modalidad"><option>Presencial</option><option>Semipresencial</option></select></div>
</fieldset>
<div class="acciones"><button type="submit">Registrar datos</button><a class="boton" href="listado_registros.php">Ver registros</a><a class="boton" href="index.php">Volver</a></div>
</form>
<?php if ($mensaje !== ''): ?><section class="resultado"><h2>Resultado</h2><p><?= e($mensaje) ?></p></section><?php endif; ?>
</main></body></html>