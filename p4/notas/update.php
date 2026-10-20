<?php
require_once __DIR__ . '/comun.php';
$id = id_solicitud();
$error = '';
try {
    [$est, $cur] = opciones($pdo);
    $v = cargar_nota($pdo, $id);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validar_token();
        $v = datos_nota();
        $error = validar_nota($v, $est, $cur);
        if ($error === '') {
            $sql = 'UPDATE nota_curso SET id_estudiante=:estudiante,
id_curso=:curso, nota=:nota WHERE id_nota=:id';
            $stmt = $pdo->prepare($sql);
            $parametros = [
                'estudiante' => $v['id_estudiante'],
                'curso' => $v['id_curso'],
                'nota' => $v['nota'],
                'id' => $id
            ];
            $stmt->execute($parametros);
            header('Location: index.php');
            exit;
        }
    }
} catch (PDOException $e) {
    if (!isset($est, $cur, $v)) { fallo(); exit; }
    $error = $e->getCode() === '23000'
        ? 'Revise las relaciones o la pareja estudiante-curso repetida.'
        : 'No se pudo actualizar. Revise SQL y conexión.';
}
inicio('Actualizar nota');
formulario_nota($v, $est, $cur, $error, $id);
fin();