<?php

require_once("Estudiante.php");

// Muestra un formulario en pantalla para la clase Estudiante
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la carrera y se
// devuelve un formulario precargado con los datos
function estudianteInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Estudiante::getByKey($_POST["id"]);
    echo "<form action=\"index.php?class=estudiante&cmd=edit\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"edit\" />";
    estudianteFields($_POST["id"], $obj->getDoc_Id(),
		     $obj->getCarnet(), $obj->getNombre(),
		     $obj->getApellido(), $obj->getFecha_nac(),
		     $obj->getColegio_origen());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=estudiante&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" />";
    estudianteFields("","","","","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function estudianteFields($oldid, $id,  $carnet, $nombre, $apellido, $fecha_nac, $colegio) {
  echo "
   <input type=\"hidden\" name=\"oldid\" value=\"" . $oldid ."\" /></br>
   Documento de identidad: <input type=\"text\" name=\"id\" value=\"".$id."\" /></br>
   Carnet: <input type=\"text\" name=\"carnet\" value=\"".$carnet."\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" value=\"".$nombre."\" /></br>
   Apellido: <input type=\"text\" name=\"apellido\" value=\"".$apellido."\" /></br>
   Fecha de nacimiento: <input type=\"text\" name=\"fecha_nac\" value=\"".$fecha_nac."\" /></br>
   Colegio de origen: <input type=\"text\" name=\"colegio\" value=\"".$colegio."\" /></br>";
}

function estudianteInsert() {
  $obj = new Estudiante($_POST["id"],
			$_POST["carnet"],
			$_POST["nombre"],
			$_POST["apellido"],
			$_POST["fecha_nac"],
			$_POST["colegio"]);
  $obj->save();
  echo "Se ha agregado un nuevo estudiante";
  estudianteAll();
}

function estudianteAll() {
  echo "</br><a href=\"index.php?class=estudiante&cmd=input\">Insertar nuevo Estudiante</a></br>";

  $res = Estudiante::all();
  echo "<ul>";
  foreach ($res as $ind) {
    echo "<li>Estudiante: " . $ind. "

         <form action=\"index.php?class=estudiante&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"codigo\" value=\"" . $ind->getDoc_Id() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>

         <form action=\"index.php?class=estudiante&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"codigo\" value=\"" . $ind->getDoc_Id() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
         
         </li>";
  }
  echo "</ul>";
}

function estudianteEdit() {
  $obj = Estudiante::getByKey($_POST["oldid"]);
  $obj->setDoc_Id($_POST["id"]);
  $obj->setCarnet($_POST["carnet"]);
  $obj->setNombre($_POST["nombre"]);
  $obj->setApellido($_POST["apellido"]);
  $obj->setFecha_nac($_POST["fecha_nac"]);
  $obj->setColegio_origen($_POST["colegio"]);
  $obj->save();
  echo "Se ha modificado un estudiante";
  estudianteAll();
}

function estudianteDelete() {
  $obj = Estudiante::getByKey($_POST["id"]);
  $obj->delete();
  echo "El estudiante " . $obj . " ha sido eliminado";
  estudianteAll();
}

?>