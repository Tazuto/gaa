<?php
date_default_timezone_set("America/Lima");
$hora = date("H");
if ($hora < 12) {
    $file = 'img/dia.jpg';
    $mensaje = "Buenos Días";
}
else if ($hora < 18) {
    $file = 'img/tarde.jpg'; 
    $mensaje = "Buenas Tardes";
}
else {
    $file = 'img/noche.jpg';
    $mensaje = "Buenos Noches";
}
?>
<html>
<body>
<center>
    <b><?= $mensaje ?></b> 
    <br>
    <img src="<?= $file ?>">
</center>
</body>
</html>