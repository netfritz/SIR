<?php

require_once("class/model/Estudiante.php");
require_once("interfaz_estudiante.php");


function estudianteAll() {
  return new interfazEstudianteAll(Estudiante::all());
}

function estudianteDelete() {
  $obj = Estudiante::getByKey($_POST["id"]);
  $obj->delete();

  return new interfazEstudianteAll(Estudiante::all(),
				array("El Estudiante {$obj->getNombre()} ha sido eliminado"));
}

function estudianteInput() {

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Estudiante::getByKey($_POST["id"]);
    if ($obj != NULL) {
      return new interfazEstudianteForm($obj, False);
    }
  }
 
  return new interfazEstudianteForm();
}

function estudianteInsert() {
  $meses = array('Enero' => 01, 'Febrero' => 02, 'Marzo' => 03, 'Abril' => 04, 'Mayo' => 05,
                 'Junio' => 06,'Julio' => 07, 'Agosto' => 08, 'Septiembre' => 09, 'Octubre' => 10,
                 'Noviembre' => 11, 'Diciembre' => 12);

  $id = $_POST["id"];
  $carnet = $_POST["carnet"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dia = $_POST["fecha_nac_dia"];
  $mes = $_POST["fecha_nac_mes"];
  $anio = $_POST["fecha_nac_anio"];
  $fecha_nac = $anio."-".$meses[$mes]."-".$dia;
  $colegio = $_POST["colegio"];

  // Validar formulario

  $existe = Estudiante::getByKey($id);
  if ($existe != NULL)
    $msjs[] = "Ya existe otra carrera con el mismo código";

  $obj = new Estudiante($id, $nombre,$apellido,$fecha_nac,$colegio);

  if (!($codigo && $nombre && $direccion && $coordinador && $existe == NULL) )
    return new interfazEstudianteForm($obj, True, $msjs);

  $obj->save();

  return new interfazEstudianteAll(Estudiante::all(),
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