<?php 
$i = 1;
do {

    $cant_combustible_litros = rand(0, 10) / 10;
    $distancia_kilometros = rand(70, 100);
    $costo_unitario_litro = rand(20, 50);
    $consumo_combustible = $cant_combustible_litros / $distancia_kilometros * 100; 
    $costo_trayecto = $cant_combustible_litros * $costo_unitario_litro;
    echo "<div>La cantidad de combustible es de $cant_combustible_litros litros</div>"; 
    echo "<p class='calculo '>Consumo de combustible: ";
    echo $consumo_combustible;
    echo " Litros/100km";
    echo "<br>";
    echo "Costo de Trayecto: ";
    echo $costo_trayecto;
    echo "</p><center>";
    list($entero, $decimal) = sscanf($costo_trayecto, '%d.%d');
    
    if ($decimal != 0) {
        echo "<h1>El costo debe ser entero, volver a generar costo.</h1>";
        echo "<h2>Fin de intento $i</h2>";
        $i++;
    } else {
        echo "<h1>El costo es entero.</h1>"; break;
        break;
    }    
    echo "</center>";

} while ($i <= 5);

?>