<?php

require_once("Carrera.php");
require_once("interfaz_carrera.php");

function carreraInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Carrera::getByKey($_POST["codigo"]);
    return new interfazCarreraForm($obj, True);
  } else {
    return new interfazCarreraForm(NULL);
  } 
}

function carreraInsert() {

  // Validar formulario

  // Verificar si ya existe la instancia

  $obj = new Carrera($_POST["codigo"],
		     $_POST["nombre"],
		     $_POST["direccion"],
		     $_POST["coordinador"]);
  $obj->save();

  return new interfazCarreraAll(Carrera::all(),
				array("Se ha agregado una nueva carrera"));

}

function carreraAll() {
  return new interfazCarreraAll(Carrera::all());
}

function carreraEdit() {

  // Validar campos

  $obj = Carrera::getByKey($_POST["oldcodigo"]);
  //$obj->setCodigo($_POST["codigo"]);
  $obj->setNombre($_POST["nombre"]);
  $obj->setDireccion($_POST["direccion"]);
  $obj->setCoordinador($_POST["coordinador"]);
  $obj->save();

  return new interfazCarreraAll(Carrera::all(),
				array("Se ha modificado una carrera"));
}

function carreraDelete() {
  $obj = Carrera::getByKey($_POST["codigo"]);
  $obj->delete();

  return new interfazCarreraAll(Carrera::all(),
				array("La carrera " . $obj->getNombre() . " ha sido eliminada"));
}

?>