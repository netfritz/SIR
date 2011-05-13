<?php

require_once("class/model/Departamento.php");
require_once("interfaz_departamento.php");


function departamentoAll() {
  return new interfazDepartamentoAll(Departamento::all());
}

function departamentoDelete() {
  $obj = Departamento::getByKey($_POST["id"]);
  $obj->delete();

  return new interfazDepartamentoAll(Departamento::all(),
				array("El departamento {$obj->getNombre()} ha sido eliminado"));
}

function departamentoInput() {

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Departamento::getByKey($_POST["id"]);
    if ($obj != NULL) {
      return new interfazDepartamentoForm($obj, False);
    }
  }
 
  return new interfazDepartamentoForm(); 
}

function departamentoInsert() {

  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $universidad = filter_input(INPUT_POST, 'universidad', FILTER_VALIDATE_REGEXP, 
			      array("options"=>array("regexp"=>$reNombres)));
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));

  $msjs = array();

  if (!$universidad)
    $msjs[] = "La universidad es invalida. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$codigo)
    $msjs[] = "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    $msjs[] = "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.</br>";

  $obj = new Departamento($universidad, $codigo, $nombre, $direccion);

  if (!($universidad && $codigo && $nombre && $direccion) ) {
    return new interfazDepartamentoForm($obj, True, $msjs);
  }
  $obj->save();
  return new interfazDepartamentoAll(Departamento::all(),
				array("Se ha agregado un nuevo departamento"));
}


function departamentoEdit() {

  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $universidad = filter_input(INPUT_POST, 'universidad', FILTER_VALIDATE_REGEXP, 
			      array("options"=>array("regexp"=>$reNombres)));
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));

  $msjs = array();
  if (!$universidad)
    $msjs[] = "La universidad es invalida. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$codigo)
    $msjs[] = "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    $msjs[] = "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$direccion)
    $msjs[] = "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.</br>";

  $obj = Departamento::getByKey($_POST["id"]);
  $obj->setUniversidad($universidad);
  $obj->setCodigo($codigo);
  $obj->setNombre($nombre);
  $obj->setDireccion($direccion);

  if (!($universidad && $codigo && $nombre && $direccion)) {
    return new interfazDepartamentoForm($obj, False, $msjs);
  }
  $obj->save();
  return new interfazDepartamentoAll(Departamento::all(),
				array("Se ha modificado un departamento"));
}


?>