<?php
require_once __DIR__ . '/comun.php';
require_once __DIR__ . '/soporte.php';
$campos = ['firstname' => 'Nombres', 'lastname' => 'Apeliidos',
'email' => 'Correo', 'age' => 'Edad', 'location' => 'Ciudad'];
$id = id_solicitud();

try {
    $pdo = conectar('test');
    $stmt = $pdo->prepare('SELECT firstname, lastname, email, age, location FROM users WHERE id=:id');
    $stmt->execute(['id' => $id]);
    $datos = $stmt->fetch();
    if (!$datos) {http_response_code(404); exit('El usuario no existe.'); }
} catch (PDOException $e) { fallo(); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validar_token();
    foreach ($campos as $campo => $etiqueta) {
        $valor = $_POST[$campo] ?? '';
        $datos[$campo] = is_string($valor) ? trim($valor) : '';
    }
    $edad = filter_var($datos['age'], FILTER_VALIDATE_INT);
    $valido = !in_array('', $datos, true)
        && strlen($datos['firstname']) <= 30
        && strlen($datos['lastname']) <= 30
        && strlen($datos['email']) <= 50
        && strlen($datos['location']) <= 50
        && filter_var($datos['email'], FILTER_VALIDATE_EMAIL)
        && $edad !== false && $edad >= 0 && $edad <= 120;

    if (!$valido) {
        $error = 'Revise campos, longitudes, correo y edad (0 a 120).';
    } else {
        try {
            $pdo = conectar('test');
            $stmt = $pdo->prepare('UPDATE users SET firstname=:firstname, lastname=:lastname, email=:email, age=:age, location=:location WHERE id=:id');
            $stmt->execute($datos + ['id' => $id]);
            header('Location: read.php');
            exit;
        } catch (PDOException $e) {
            $error = 'No se pudo guardar. Revise conexion y tabla.';
        }
    }
}
inicio('Actualizar usuario');
?>
<p><?= e($error) ?></p>
<form method="post">
<input type="hidden" name="id" value="<?= e($id) ?>">
<?php token_formulario(); ?>
<?php foreach ($campos as $campo => $etiqueta): ?>
<label><?= e($etiqueta) ?>
<input name="<?= e($campo) ?>" required
type="<?= $campo === 'age' ? 'number' : ($campo === 'email' ? 'email' : 'text') ?>"
value="<?= e($datos[$campo]) ?>"
<?php if ($campo === 'age'): ?> min="0" max="120"
<?php else: ?> maxlength="<?= in_array($campo, ['firstname', 'lastname']) ? 30 : 50 ?>" <?php endif; ?>>
</label>
<?php endforeach; ?>
<button>Guardar cambios</button>
<a href="read.php">Cancelar</a>
</form>
<?php fin(); ?>