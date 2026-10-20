<?php
$actividades = [
    'ejemplo_registro.php' => 'Ejemplo guiado: registro académico',
    'listado_registros.php' => 'Registros guardados en MySQL',
    'actividad1_consulta.php' => 'Actividad 1: consulta con GET',
    'actividad2_registro.php' => 'Actividad 2: registro con POST',
    'actividad3_controles.php' => 'Actividad 3: controles múltiples',
    'actividad4_dinamico.php' => 'Actividad 4: formulario dinámico con PHP'
];
?>
<!doctype html>
<html lang="es"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laboratorio 05</title><link rel="stylesheet" href="css/estilos.css"></head>
<body><main class="contenedor"><h1>Laboratorio 05</h1><p>Diseño y procesamiento de formularios web con HTML, CSS, PHP y MySQL.</p>
<nav><ul class="menu"><?php foreach ($actividades as $archivo => $nombre): ?><li><a href="<?= $archivo ?>"><?= $nombre ?></a></li><?php endforeach; ?></ul></nav>
<p class="nota">Copie la carpeta <code>laboratorio05_xampp</code> a <code>C:\xampp\htdocs</code> y abra <code>http://localhost/laboratorio05_xampp/</code>.</p>
</main></body></html>