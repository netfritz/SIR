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
  $pais  = filter_input(INPUT_POST, 'pais', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $estado  = filter_input(INPUT_POST, 'estado', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $ciudad  = filter_input(INPUT_POST, 'ciudad', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $rector = filter_input(INPUT_POST, 'rector', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $msjs = array();

  if (!$nombre)
    $msjs[] = "El nombre de la universidad es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$pais)
     $msjs[] = "El nombre del pais es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$estado)
     $msjs[] = "El nombre del estado es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$ciudad)
     $msjs[] = "El nombre de la ciudad es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";  
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.";
  if (!$rector)
     $msjs[] = "El nombre del rector es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  /*
  $pais=$_POST['pais'];     
  $estado=$_POST['estado'];
  $ciudad=$_POST['ciudad'];
  $direccion=$_POST['direccion'];
  $rector=$_POST['rector'];
*/ 
 $url=$_POST['url'];
  

  $existe = Universidad::getByKey($nombre);
  if ($existe != NULL)
    $msjs[] = "Ya existe otra Universidad con el mismo nombre";

  $obj = new Universidad($nombre,$pais,$estado,$ciudad,$direccion,$rector,$url);

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
  $pais  = filter_input(INPUT_POST, 'pais', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $estado  = filter_input(INPUT_POST, 'estado', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $ciudad  = filter_input(INPUT_POST, 'ciudad', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $rector = filter_input(INPUT_POST, 'rector', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $msjs = array();

  if (!$pais)
     $msjs[] = "El nombre del pais es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$estado)
     $msjs[] = "El nombre del estado es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$ciudad)
     $msjs[] = "El nombre de la ciudad es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";  
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.";
  if (!$rector)
     $msjs[] = "El nombre del rector es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";

   $url=$_POST["url"];

  $obj = Universidad::getByKey($_POST["nombre"]);
 
  $obj->setPais($pais);
  $obj->setEstado($estado);
  $obj->setCiudad($ciudad);
  $obj->setDireccion($direccion);
  $obj->setRector($rector);
  $obj->setUrl($url);

  if (!($pais && $direccion && $estado && $ciudad && $rector))
    return new interfazUniversidadForm($obj, False, $msjs);
  
  $obj->save();
  return new interfazUniversidadAll(Universidad::all(),
				array("Se ha modificado una universidad"));
}


?>
