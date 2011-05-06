Hora de probar cosas en la vida

<?php
require_once("Carrera.php");

$bla = Carrera::all();

foreach ($bla as $ble) {
  echo "<p>".$ble. "</p>";
}

$bli = Carrera::getByKey("0800");

echo "<p>".$bli."</p>";

$bli->setNombre("ING LOCA");
$bli->save();

$bla2 = new Carrera("100", "OTRA ING", "JA", "MALD");
$bla2->save();

$bla2->delete();

?>
