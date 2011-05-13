<?php

require_once("class/model/Agrupacion.php");
require_once("interfaz_agrupacion.php");


function agrupacionAll() {
  return new interfazAgrupacionAll(Agrupacion::all());
}

function agrupacionDelete() {
  $obj = Agrupacion::getByKey($_POST["univ"], $_POST["nombre"]);
  $obj->delete();

  return new interfazAgrupacionAll(Agrupacion::all(),
	array("La agrupacion {$obj->getNombre()} de {$obj->getUniversidad()} ha sido eliminada"));
}

function agrupacionInput() {

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Agrupacion::getByKey($_POST["universidad"], $_POST["nombre"]);
    if ($obj != NULL) {
      return new interfazAgrupacionForm($obj, False);
    }
  }
 
  return new interfazAgrupacionForm(); 
}

function agrupacionInsert() {


  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reMision = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $univ = filter_input(INPUT_POST, 'universidad', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $pres  = filter_input(INPUT_POST, 'pres', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));  
  $mision = filter_input(INPUT_POST, 'mision', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reMision)));
  $vision = filter_input(INPUT_POST, 'vision', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reMision)));
  $msjs = array();

  if (!$univ)
    $msjs[] = "La universidad es invalida. Solo se permiten letras y espacios.";
  if (!$nombre)
    $msjs[] = "El nombre es invalido. Solo se permiten letras y espacios.";
  if (!$pres)
    $msjs[] = "El presidente es invalido. Solo se permiten letras y espacios.";
  if (!$mision)
    $msjs[] = "La mision es invalida. Solo se permiten letras, numeros, guiones y espacios.";
  if (!$vision)
    $msjs[] = "La vision es invalida. Solo se permiten letras, numeros, guiones y espacios.";  
  

  $existe = Agrupacion::getByKey($univ, $nombre);
  if ($existe != NULL)
    $msjs[] = "Ya existe otra agrupacion con el mismo nombre en la misma universidad";

  $obj = new Agrupacion($univ, $nombre, $pres, $mision, $vision);

  if (!($univ && $nombre && $pres && $mision && $vision && $existe == NULL) )
    return new interfazAgrupacionForm($obj, True, $msjs);

  $obj->save();

  return new interfazAgrupacionAll(Agrupacion::all(),
				array("Se ha agregado una nueva agrupacion"));
}


function agrupacionEdit() {

  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reMision = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $pres  = filter_input(INPUT_POST, 'pres', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));  
  $mision = filter_input(INPUT_POST, 'mision', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reMision)));
  $vision = filter_input(INPUT_POST, 'vision', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reMision)));
  $msjs = array();

  if (!$pres)
    $msjs[] = "El presidente es invalido. Solo se permiten letras y espacios.";
  if (!$mision)
    $msjs[] = "La mision es invalida. Solo se permiten letras, numeros, guiones y espacios.";
  if (!$vision)
    $msjs[] = "La vision es invalida. Solo se permiten letras, numeros, guiones y espacios."; 

  $obj = Agrupacion::getByKey($_POST["univ"], $_POST["nombre"]);
  $obj->setNombre($pres);
  $obj->setDireccion($mision);
  $obj->setCoordinador($vision);

  if (!($pres && $mision && $vision))
    return new interfazAgrupacionForm($obj, False, $msjs);
  
  $obj->save();
  return new interfazAgrupacionAll(Agrupacion::all(),
				array("Se ha modificado una agrupacion"));
}


?>