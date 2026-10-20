<?php
require_once __DIR__ . '/comun.php';
require_once __DIR__ . '/soporte.php';
$id = id_solicitud();
try {
    $pdo = conectar('test');
    $stmt = $pdo->prepare('SELECT * FROM users WHERE id=:id');
    $stmt->execute(['id' => $id]);
    $datos = $stmt->fetch();
    if (!$datos) {
        http_response_code(404);
        exit('El usuario no existe.');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validar_token();
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        header('Location: read.php');
        exit;
    }
} catch (PDOException $e) { fallo(); exit; }
inicio('Eliminar usuario');
?>
<p>Se eliminará el usuario <?= e($id) ?>:
<?= e($datos['firstname']) ?> <?= e($datos['lastname']) ?>,
<?= e($datos['email']) ?>.</p>
<form method="post">
<?php token_formulario(); ?>
<input type="hidden" name="id" value="<?= e($id) ?>">
<button>Confirmar eliminación</button>
<a href="read.php">Cancelar</a>
</form>
<?php fin(); ?>