<?php
require_once __DIR__ . '/comun.php';
$v = ['id_estudiante' => '', 'id_curso' => '', 'nota' => ''];
$error = '';
try {
    [$est, $cur] = opciones($pdo);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        validar_token();
        $v = datos_nota();
        $error = validar_nota($v, $est, $cur);
        if ($error === '') {
            $sql = 'INSERT INTO nota_curso (id_estudiante, id_curso, nota)
VALUES (:estudiante, :curso, :nota)';
            $stmt = $pdo->prepare($sql);
            $parametros = [
                'estudiante' => $v['id_estudiante'],
                'curso' => $v['id_curso'],
                'nota' => $v['nota']
            ];
            $stmt->execute($parametros);
            header('Location: index.php');
            exit;
        }
    }
} catch (PDOException $e) {
    if (!isset($est, $cur)) { fallo(); exit; }
    $error = $e->getCode() === '23000'
        ? 'Revise las relaciones o la pareja estudiante-curso repetida.'
        : 'No se pudo registrar. Revise SQL y conexión.';
}
inicio('Registrar nota');
formulario_nota($v, $est, $cur, $error);
fin();