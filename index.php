Hora de probar cosas en la vida

<?php
require_once("Carrera.php");

$bla = Carrera::all();

foreach ($bla as $ble) {
  echo "<p>".$ble->toString(). "</p>";
}

?>
