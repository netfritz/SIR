<?php

require_once("class/model/Carrera.php");
require_once("interfaz_carrera.php");


function carreraAll() {
  return new interfazCarreraAll(Carrera::all());
}

function carreraDelete() {
  $obj = Carrera::getByKey($_POST["codigo"]);
  $obj->delete();

  return new interfazCarreraAll(Carrera::all(),
				array("La carrera {$obj->getNombre()} ha sido eliminada"));
}

function carreraInput() {

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Carrera::getByKey($_POST["codigo"]);
    if ($obj != NULL) {
      return new interfazCarreraForm($obj, False);
    }
  }
 
  return new interfazCarreraForm(); 
}

function carreraInsert() {

  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
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

  $existe = Carrera::getByKey($codigo);
  if ($existe != NULL)
    $msjs[] = "Ya existe otra carrera con el mismo código";

  $obj = new Carrera($codigo, $nombre, $direccion, $coordinador);

  if (!($codigo && $nombre && $direccion && $coordinador && $existe == NULL) )
    return new interfazCarreraForm($obj, True, $msjs);

  $obj->save();

  return new interfazCarreraAll(Carrera::all(),
				array("Se ha agregado una nueva carrera"));
}


function carreraEdit() {

  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $coordinador = filter_input(INPUT_POST, 'coordinador', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $msjs = array();

  if (!$nombre)
    $msjs[] = "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.";
  if (!$coordinador)
    $msjs[] = "El coordinador es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.";

  $obj = Carrera::getByKey($_POST["codigo"]);
  $obj->setNombre($nombre);
  $obj->setDireccion($direccion);
  $obj->setCoordinador($coordinador);

  if (!($nombre && $direccion && $coordinador))
    return new interfazCarreraForm($obj, False, $msjs);
  
  $obj->save();
  return new interfazCarreraAll(Carrera::all(),
				array("Se ha modificado una carrera"));
}


?>