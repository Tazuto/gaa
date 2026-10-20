<?php
require_once __DIR__ . '/comun.php';
$id = id_solicitud();
$error = '';
try {
    $v = cargar_nota($pdo, $id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validar_token();
        $sql = 'DELETE FROM nota_curso WHERE id_nota=:id';
        $stmt = $pdo->prepare($sql);
        $parametros = ['id' => $id];
        $stmt->execute($parametros);
        header('Location: index.php');
        exit;
    }
} catch (PDOException $e) {
    if (!isset($v)) { fallo(); exit; }
    $error = 'No se pudo eliminar. Revise SQL y conexión.';
}
inicio('Eliminar nota');
?>
<p class="error" role="alert"><?= e($error) ?></p>
<p>Se eliminará el registro <?= e($id) ?>,
del estudiante ID <?= e($v['id_estudiante']) ?>,
curso ID <?= e($v['id_curso']) ?>,
con nota <?= e($v['nota']) ?>.</p>
<form method="post">
<?php token_formulario(); ?>
<input type="hidden" name="id" value="<?= e($id) ?>">
<button>Confirmar eliminación</button>
<a href="index.php">Cancelar</a>
</form>
<?php fin(); ?>