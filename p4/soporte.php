<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
function token_formulario() {
    echo '<input type="hidden" name="token" value="';
    echo htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8');
    echo '">';
}
function validar_token() {
    $token = $_POST['token'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['token'], $token)) {
        http_response_code(403);
        exit('Formulario invalido. Vuelva al listado');
    }
}
function id_solicitud() {
    $tipo = $_SERVER['REQUEST_METHOD'] === 'POST' ? INPUT_POST : INPUT_GET;
    $id = filter_input($tipo, 'id', FILTER_VALIDATE_INT);
    if (!$id || $id < 1) {
        http_response_code(400);
        exit('Identificador invalido.');
    }
    return $id;
}