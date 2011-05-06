<?php

require_once("Profesor.php");

function profesorInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Profesor::getByKey($_POST["id"],$_POST["dep"]);
    echo "<form action=\"index.php?class=profesor&cmd=edit\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"edit\" />";
    profesorFields($_POST["id"], $_POST["dep"], $obj->getDocumento_Id(), 
		   $obj->getCarnet(), $obj->getDpto(),
		   $obj->getNombre(), $obj->getApellido(),
		   $obj->getTitulo());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=profesor&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" />";
    profesorFields("","","","","","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function profesorFields($oldid, $olddep, $id, $dep, $carnet, $nombre, $apellido, $titulo) {
  echo "
   <input type=\"hidden\" name=\"oldid\" value=\"" . $oldid ."\" /></br>
   <input type=\"hidden\" name=\"olddep\" value=\"" . $olddep ."\" /></br>
   Documento de identidad: <input type=\"text\" name=\"id\" value=\"".$id."\" /></br>
   Código departamento: <input type=\"text\" name=\"dep\" value=\"".$dep."\" /></br>
   Carnet: <input type=\"text\" name=\"carnet\" value=\"".$carnet."\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" value=\"".$nombre."\" /></br>
   Apellido: <input type=\"text\" name=\"apellido\" value=\"".$apellido."\" /></br>
   Titulo: <input type=\"text\" name=\"titulo\" value=\"".$titulo."\" /></br>";
}

function profesorInsert() {
  $obj = new Profesor($_POST["id"],
		      $_POST["dep"],
		      $_POST["carnet"],
		      $_POST["nombre"],
		      $_POST["apellido"],
		      $_POST["titulo"]);
  $obj->save();
  echo "Se ha agregado un nuevo profesor";
  profesorAll();
}

function profesorAll() {
  echo "</br><a href=\"index.php?class=profesor&cmd=input\">Insertar nuevo Profesor</a></br>";

  $res = Profesor::all();
  echo "<ul>";
  foreach ($res as $ind) {
    echo "<li>Profesor: " . $ind. "

         <form action=\"index.php?class=profesor&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $ind->getDocument_Id() . "\" />
         <input type=\"hidden\" name=\"dep\" value=\"" . $ind->getDpto() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>

         <form action=\"index.php?class=profesor&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $ind->getDocument_Id() . "\" />
         <input type=\"hidden\" name=\"dep\" value=\"" . $ind->getDpto() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
         
         </li>";
  }
  echo "</ul>";
}

function profesorEdit() {
  $obj = Profesor::getByKey($_POST["oldid"],$_POST["olddep"]);
  $obj->setDocumento_Id($_POST["id"]);
  $obj->setDpto($_POST["dep"]);
  $obj->setCarnet($_POST["carnet"]);
  $obj->setNombre($_POST["nombre"]);
  $obj->setApellido($_POST["apellido"]);
  $obj->setTitulo($_POST["titulo"]);
  $obj->save();
  echo "Se ha modificado un profesor";
  profesorAll();
}

function profesorDelete() {
  $obj = Profesor::getByKey($_POST["id"],$_POST["dep"]);
  $obj->delete();
  echo "El profesor " . $obj . " ha sido eliminado";
  profesorAll();
}

?>