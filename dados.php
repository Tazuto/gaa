<h1>Dos dados</h1>

<p>Actualice la pagina para mostrar una nueva tirada</p>

<?php
$dado1 = rand(1,6);
$dado2 = rand(1,6);

print "<p>\n";
print "<img src=\"img/$dado1.svg\" alt=\"$dado1\" width=\"140\" height=\"140\">\n";
print "<img src=\"img/$dado2.svg\" alt=\"$dado2\" width=\"140\" height=\"140\">\n";
print "</p>";

print "\n";

if ($dado1 == $dado2) {
    print " <p>Ha sacado una pareja de $dado1.</p>\n";
} else {
    print " <p>No ha sacado pareja. El valor mas alto es " . max($dado1, $dado2) . ".</p>\n";
}
?>