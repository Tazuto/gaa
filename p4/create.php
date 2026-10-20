<?php
require_once __DIR__ . '/comun.php';

$campos = ['firstname' => 'Nombres', 'lastname' => 'Apellidos',
           'email' => 'Correo', 'age' => 'Edad', 'location' => 'Ciudad'];
$datos = array_fill_keys(array_keys($campos), '');
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        $error = 'Revise los campos, el correo y la edad (0 a 120).';
    } else {
        try {
            $pdo = conectar('test');
            $stmt = $pdo->prepare('INSERT INTO users 
                (firstname, lastname, email, age, location) 
                VALUES (:nombre, :apellido, :email, :edad, :ciudad)');
            $stmt->execute([
                'nombre' => $datos['firstname'],
                'apellido' => $datos['lastname'],
                'email' => $datos['email'], 
                'edad' => $edad,
                'ciudad' => $datos['location']
            ]);
            
            header('Location: read.php');
            exit;
        } catch (PDOException $e) {
            $error = 'No se pudo guardar. Revise la conexión y la tabla.';
        }
    }
}

inicio('Crear usuario');
if ($error !== '') { echo '<p>' . e($error) . '</p>'; }
echo '<form method="post">';

foreach ($campos as $campo => $etiqueta) {
    $tipo = ($campo === 'email') ? 'email' : (($campo === 'age') ? 'number' : 'text');
    
    echo '<label>' . e($etiqueta);
    echo '<input name="' . $campo . '" type="' . $tipo . '"';
    echo ' value="' . e($datos[$campo]) . '" required';
    
    if ($campo === 'age') { 
        echo ' min="0" max="120" step="1"'; 
    } else {
        $maximo = in_array($campo, ['firstname', 'lastname']) ? 30 : 50;
        echo ' maxlength="' . $maximo . '"';
    }
    echo '></label>';
}

echo '<button>Guardar usuario</button></form>';
echo '<a href="index.php">Regresar al menú</a>';
fin();