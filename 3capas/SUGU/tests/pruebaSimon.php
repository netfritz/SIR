<?php

require_once 'Profesor.php';

$profesor2 = new Profesor("18.4.123", 2, "03-36440", "Sin", "Rojas", "Geofisico");
$profesor1 = new Profesor("18.234.123", 2, "03-36440", "on", "Rojas", "Geofisico");
$profesor3 = new Profesor("11234.123", 2, "03-36440", "Sion", "Rojas", "Geofisico");
$profesor2->save();
$array = Profesor::all();
foreach ($array as $value) {
    echo $value."</br>";
}
$profesor4 = Profesor::getByKey("18.234.123", 2);
echo $profesor4;
$profesor4->setApellido("Perez");
$profesor4->save();
$profesor4->setDocumento_id("123");
$profesor4->save();

//$profesor->delete();
?>
    
