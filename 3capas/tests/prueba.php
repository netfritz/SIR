Hora de probar cosas en la vida

<br>
<?php
require_once("Carrera.php");

$bla = Carrera::all();

print_r($bla);

echo "<br>";
foreach ($bla as $ble) {
  echo "<p>".$ble. "</p>";
}


$bli = Carrera::getByKey("0800");

echo "<p>".$bli."</p>";
if ($bli == NULL) {
  echo "?";
} else {
  $bli->setNombre("ING LOCA");
  $bli->save();
}

$bla2 = new Carrera("100", "OTRA ING", "JA", "MALD");
$bla2->save();

$bla2->delete();

?>
