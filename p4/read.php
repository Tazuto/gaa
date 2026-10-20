<?php
require_once __DIR__ . '/comun.php';
inicio('Usuarios registrados');

try {
    $pdo = conectar('test');
    $stmt = $pdo->query(
        'SELECT id, firstname, lastname, email, age, location, date 
        FROM users ORDER BY id DESC'
    );
    tabla($stmt->fetchAll());
    $stmt = null;
    $pdo = null;
} catch (PDOException $e) { fallo(); }
?>

<form method="get">
    <label>ID del usuario
        <input type="number" name="id" min="1" required>
    </label>
    <button formaction="update.php">Editar</button>
    <button formaction="delete.php">Eliminar</button>
</form>

<p><a href="create.php">Crear otro usuario</a></p>
<p><a href="index.php">Regresar al menú</a></p>

<?php 
fin(); 
?>