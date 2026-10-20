<?php
require __DIR__ . '/config.php';
function e($valor) { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$enviado = $_SERVER['REQUEST_METHOD'] === 'POST';
$intereses = $_POST['intereses'] ?? [];
$herramientas = $_POST['herramientas'] ?? [];
$mensaje = '';

if ($enviado) {
    $stmt = $pdo->prepare('INSERT INTO preferencias
                           (participante, tema, herramientas, intereses, lenguaje)
                           VALUES (:participante, :tema, :herramientas, :intereses, :lenguaje)');
    $stmt->execute([
        'participante' => trim($_POST['participante'] ?? ''),
        'tema' => $_POST['tema'] ?? '',
        'herramientas' => json_encode($herramientas, JSON_UNESCAPED_UNICODE),
        'intereses' => json_encode($intereses, JSON_UNESCAPED_UNICODE),
        'lenguaje' => trim($_POST['lenguaje'] ?? '')
    ]);
    $mensaje = 'Preferencias guardadas correctamente.';
}

$preferencias = $pdo->query('SELECT participante, tema, herramientas, intereses, lenguaje
                             FROM preferencias ORDER BY id DESC LIMIT 10')->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Controles múltiples</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Actividad 3 - Controles múltiples</h1>
<form action="actividad3_controles.php" method="post"><fieldset><legend>Preferencias de aprendizaje</legend>
<div class="grupo"><label for="participante">Participante</label><input id="participante" name="participante" type="text" required></div>
<div class="grupo"><label for="tema">Tema de interés</label><select id="tema" name="tema" required><optgroup label="Desarrollo web"><option>HTML y CSS</option><option>PHP</option></optgroup><optgroup label="Programación"><option>Python</option><option>Java</option></optgroup></select></div>
<div class="grupo"><label for="herramientas">Herramientas conocidas</label><select id="herramientas" name="herramientas[]" multiple size="4"><option>Visual Studio Code</option><option>XAMPP</option><option>Git</option><option>Figma</option></select></div>
<div class="grupo"><span>Intereses</span><div class="opciones"><label><input type="checkbox" name="intereses[]" value="Frontend">Frontend</label><label><input type="checkbox" name="intereses[]" value="Backend">Backend</label><label><input type="checkbox" name="intereses[]" value="UX">UX</label></div></div>
<div class="grupo"><label for="lenguaje">Lenguaje por explorar</label><input id="lenguaje" name="lenguaje" list="lenguajes"><datalist id="lenguajes"><option value="PHP"><option value="JavaScript"><option value="Python"><option value="Java"></datalist></div>
</fieldset><div class="acciones"><button type="submit">Enviar preferencias</button><a class="boton" href="index.php">Volver</a></div></form>
<?php if ($mensaje !== ''): ?><section class="resultado"><p><?= e($mensaje) ?></p></section><?php endif; ?>
<h2>Preferencias guardadas</h2><?php if (!$preferencias): ?><p class="nota">Todavía no existen preferencias.</p><?php else: ?><div style="overflow-x:auto"><table class="tabla-datos"><thead><tr><th>Participante</th><th>Tema</th><th>Herramientas</th><th>Intereses</th><th>Lenguaje</th></tr></thead><tbody><?php foreach ($preferencias as $fila): $h = json_decode($fila['herramientas'], true) ?: []; $i = json_decode($fila['intereses'], true) ?: []; ?><tr><td><?= e($fila['participante']) ?></td><td><?= e($fila['tema']) ?></td><td><?= e(implode(', ', $h)) ?: 'Ninguna' ?></td><td><?= e(implode(', ', $i)) ?: 'Ninguno' ?></td><td><?= e($fila['lenguaje']) ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</main></body></html>