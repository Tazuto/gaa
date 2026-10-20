<?php
function mensajes() {

    $array[0] = "Tamaño total de disco C: ".disk_total_space("C:")."B"; 
    $array[1] = "Espacio libre de disco C: ".disk_free_space("C:")."B"; 
    $array[2] = "Nombre del archivo PHP: ".__FILE__."";
    $array[3] = "Directorio del archivo PHP: ".__DIR__;

    return $array;
}

$palabras = mensajes();
$repeticiones = count($palabras);

// Calcula la diferencia de opacidad entre cada una de las repeticiones $reduccion = number_format(1 / $repeticiones, 6);
$reduccion = number_format(1 / $repeticiones, 6);

for ($i = 0; $i < $repeticiones; $i++) {
    
    // Calcula la opacidad en base a la repetición en la que se está 
    // // y la diferencia de opacidad entre cada una de ellas
    $opacidad = 1 - $reduccion * $i;
    
    // Imprime una capa incluyendo las palabras del array con dos estilos:
    // uno para convertir a mayúsculas y otro para definir la opacidad
    echo '<div style="text-transform: uppercase; opacity:'.$opacidad.';">'.$palabras [$i].'</div>';
}

?>