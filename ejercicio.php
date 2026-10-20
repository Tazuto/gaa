<?php
$num = rand(1, 40);
//se obtiene lista de rango de 10 a 20 valores no repetidos
$listado = range(10, 20);
shuffle($listado);
//se almacenaran los valores de la lista
array_push($listado);
//se devolverá los valores de la lista y uno de ellos se va a comparar con el numero aleatorio
$msg = preg_grep("/^$num/", $listado) ? "$num pertenece a lista <br/>" : "$num no pertenece a lista <br/>"; 
echo $msg;
?>