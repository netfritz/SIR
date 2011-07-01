<?php

require_once("class/model/Materia.php");
require_once("interfaz_materia.php");


function materiaAll() {
  return new interfazMateriaAll(Materia::all());
}

function materiaDelete() {
  $obj = Materia::getByKey($_POST["id"]);
  $obj->delete();

  return new interfazMateriaAll(Materia::all(),
				array("La Materia {$obj->getNombre()} ha sido eliminada"));
}

function materiaInput() {

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Materia::getByKey($_POST["id"]);
    if ($obj != NULL) {
      return new interfazMateriaForm($obj, False);
    }
  }
 
  return new interfazMateriaForm(); 
}

function materiaInsert() {
  
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reDpto = "/^.*$/";

// Validar formulario
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $dpto = filter_input(INPUT_POST, 'dpto', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDpto)));
  $msjs = array();

  if (!$codigo)
    $msjs[]= "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    $msjs[]= "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$dpto)
    $msjs[]= "El departamento es invalido. Solo se permiten letras, numeros, espacios y guiones.</br>"; 

  
  $obj = new Materia ($dpto, $codigo, $nombre);

  if (!($dpto && $codigo && $nombre) )
    return new interfazMateriaForm($obj, True, $msjs);

  $obj->save();

  return new interfazMateriaAll(Materia::all(),
				array("Se ha agregado una nueva materia"));
}


function materiaEdit() {
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reDpto = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

// Validar formulario
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $dpto = filter_input(INPUT_POST, 'dpto', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDpto)));
  $msjs = array();

  if (!$codigo)
    $msjs[]= "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    $msjs[]= "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$dpto)
    $msjs[]= "El departamento es invalido. Solo se permiten letras, numeros, espacios y guiones.</br>";

  $obj = Materia::getByKey($_POST["id"]);
  $obj->setnombre($nombre);
  $obj->setdpto($dpto);
  $obj->setcodigo($codigo);

  if (!($nombre && $dpto && $codigo))
    return new interfazMateriaForm($obj, False, $msjs);
  
  $obj->save();
  return new interfazMateriaAll(Materia::all(),
				array("Se ha modificado una materia"));
}


?>