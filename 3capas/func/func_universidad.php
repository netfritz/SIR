<?php

require_once("class/model/Universidad.php");
require_once("interfaz_universidad.php");


function universidadAll() {
  return new interfazUniversidadAll(Universidad::all());
}

function universidadDelete() {
  $obj = Universidad::getByKey($_POST["nombre"]);
  $obj->delete();

  return new interfazUniversidadAll(Universidad::all(),
				array("La universidad {$obj->getNombre()} ha sido eliminada"));
}

function universidadInput() {

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Universidad::getByKey($_POST["nombre"]);
    if ($obj != NULL) {
      return new interfazUniversidadForm($obj, False);
    }
  }
 
  return new interfazUniversidadForm(); 
}

function universidadInsert() {

  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  

  // Validar formulario
  
  $nombre = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  /*
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $coordinador = filter_input(INPUT_POST, 'coordinador', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $msjs = array();

  if (!$codigo)
    $msjs[] = "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones.";
  if (!$nombre)
    $msjs[] = "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.";
  if (!$coordinador)
    $msjs[] = "El coordinador es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  */
  $pais=$_POST['pais'];     
  $estado=$_POST['estado'];
  $ciudad=$_POST['ciudad'];
  $direccion=$_POST['direccion'];
  $rector=$_POST['rector'];
  $url=$_POST['url'];

  $existe = Universidad::getByKey($nombre);
  if ($existe != NULL)
    $msjs[] = "Ya existe otra Universidad con el mismo nombre";

  $obj = new Universidad($nombre,$_POST['pais'],$_POST['estado'],$_POST['ciudad'],$_POST['direccion'],$_POST['rector'],$_POST['url']);

  if (!($nombre && $pais && $direccion && $ciudad && $estado && $rector && $url && $existe == NULL) )
    return new interfazUniversidadForm($obj, True, $msjs);

  $obj->save();

  return new interfazUniversidadAll(Universidad::all(),
				array("Se ha agregado una nueva universidad"));
}


function universidadEdit() {

  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  /*
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $coordinador = filter_input(INPUT_POST, 'coordinador', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  */
  $msjs = array();
  /*
  if (!$nombre)
    $msjs[] = "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.";
  if (!$coordinador)
    $msjs[] = "El coordinador es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  */
  $pais=$_POST["pais"];     
  $estado=$_POST["estado"];
  $ciudad=$_POST["ciudad"];
  $direccion=$_POST["direccion"];
  $rector=$_POST["rector"];
  $url=$_POST["url"];

  $obj = Universidad::getByKey($_POST["nombre"]);
  //$obj->setNombre($_POST["nombre"]);
  $obj->setPais($pais);
  $obj->setEstado($estado);
  $obj->setCiudad($ciudad);
  $obj->setDireccion($direccion);
  $obj->setRector($rector);
  $obj->setUrl($url);

  //if (!($nombre && $direccion && $coordinador))
  //  return new interfazUniversidadForm($obj, False, $msjs);
  
  $obj->save();
  return new interfazUniversidadAll(Universidad::all(),
				array("Se ha modificado una universidad"));
}


?>
