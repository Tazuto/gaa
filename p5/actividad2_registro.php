<?php
require __DIR__ . '/config.php';
function e($valor) { return htmlspecialchars($valor ?? '', ENT_QUOTES, 'UTF-8'); }
$enviado = $_SERVER['REQUEST_METHOD'] === 'POST';
$mensaje = '';

if ($enviado) {
    $stmt = $pdo->prepare('INSERT INTO contactos
                           (nombre, email, telefono, comentario)
                           VALUES (:nombre, :email, :telefono, :comentario)');
    $stmt->execute([
        'nombre' => trim($_POST['nombre'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'telefono' => trim($_POST['telefono'] ?? ''),
        'comentario' => trim($_POST['comentario'] ?? '')
    ]);
    $mensaje = 'Contacto guardado correctamente.';
}

$contactos = $pdo->query('SELECT nombre, email, telefono, comentario, creado_en
                          FROM contactos ORDER BY id DESC LIMIT 10')->fetchAll();
?>
<!doctype html><html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Registro POST</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Actividad 2 - Registro con POST</h1><p>Los datos se envían en el cuerpo de la petición y se guardan en la tabla contactos.</p>
<form action="actividad2_registro.php" method="post"><fieldset><legend>Datos de contacto</legend>
<div class="grupo"><label for="nombre">Nombre completo</label><input id="nombre" name="nombre" type="text" required></div>
<div class="grupo"><label for="email">Correo electrónico</label><input id="email" name="email" type="email" required></div>
<div class="grupo"><label for="telefono">Teléfono</label><input id="telefono" name="telefono" type="tel" pattern="[0-9]{9}" placeholder="999888777" required></div>
<div class="grupo"><label for="comentario">Motivo de registro</label><textarea id="comentario" name="comentario" required></textarea></div>
</fieldset><div class="acciones"><button type="submit">Enviar registro</button><a class="boton" href="index.php">Volver</a></div></form>
<?php if ($mensaje !== ''): ?><section class="resultado"><p><?= e($mensaje) ?></p></section><?php endif; ?>
<h2>Últimos contactos</h2><?php if (!$contactos): ?><p class="nota">Todavía no existen contactos.</p><?php else: ?><div style="overflow-x:auto"><table class="tabla-datos"><thead><tr><th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Comentario</th><th>Fecha</th></tr></thead><tbody><?php foreach ($contactos as $fila): ?><tr><td><?= e($fila['nombre']) ?></td><td><?= e($fila['email']) ?></td><td><?= e($fila['telefono']) ?></td><td><?= e($fila['comentario']) ?></td><td><?= e($fila['creado_en']) ?></td></tr><?php endforeach; ?></tbody></table></div><?php endif; ?>
</main></body></html>