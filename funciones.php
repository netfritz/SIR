<?php

function __autoload($class_name) {
  include $class_name . '.php';
}

// Muestra un formulario en pantalla para la clase Carrera
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la carrera y se
// devuelve un formulario precargado con los datos
function carreraInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Carrera::getByKey($_POST["codigo"]);
    echo "<form action=\"index.php?class=carrera&cmd=edit\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"edit\" />";
    carreraFields($_POST["codigo"], $obj->getCodigo(),
		  $obj->getNombre(), $obj->getDireccion(),
		  $obj->getCoordinador());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=carrera&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" />";
    carreraFields("","","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function carreraFields($oldcodigo, $codigo, $nombre, $direccion, $coordinador) {
  echo "
   <input type=\"hidden\" name=\"oldcodigo\" value=\"" . $oldcodigo ."\" /></br>
   Codigo: <input type=\"text\" name=\"codigo\" value=\"".$codigo."\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" value=\"".$nombre."\" /></br>
   Direccion: <input type=\"text\" name=\"direccion\" value=\"".$direccion."\" /></br>
   Coordinador: <input type=\"text\" name=\"coordinador\" value=\"".$coordinador."\" /></br>";
}

function carreraInsert() {
  $obj = new Carrera($_POST["codigo"],
		     $_POST["nombre"],
		     $_POST["direccion"],
		     $_POST["coordinador"]);
  $obj->save();
  echo "Se ha agregado una nueva carrera";
  carreraAll();
}

function carreraAll() {
  echo "</br><a href=\"index.php?class=carrera&cmd=input\">Insertar nueva Carrera</a></br>";

  $res = Carrera::all();
  echo "<ul>";
  foreach ($res as $ind) {
    echo "<li>Carrera: " . $ind. "

         <form action=\"index.php?class=carrera&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"codigo\" value=\"" . $ind->getCodigo() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>

         <form action=\"index.php?class=carrera&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"codigo\" value=\"" . $ind->getCodigo() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
         
         </li>";
  }
  echo "</ul>";
}

function carreraEdit() {
  $obj = Carrera::getByKey($_POST["oldcodigo"]);
  $obj->setCodigo($_POST["codigo"]);
  $obj->setNombre($_POST["nombre"]);
  $obj->setDireccion($_POST["direccion"]);
  $obj->setCoordinador($_POST["coordinador"]);
  $obj->save();
  echo "Se ha modificado la carrera";
  carreraAll();
}

function carreraDelete() {
  $obj = Carrera::getByKey($_POST["codigo"]);
  $obj->delete();
  echo "La carrera " . $obj->getNombre() . " ha sido eliminada";
  carreraAll();
}

?>