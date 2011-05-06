<?php

require_once("Materia.php");

// Muestra un formulario en pantalla para la clase Materia
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la materia y se
// devuelve un formulario precargado con los datos
function materiaInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Materia::getByKey($_POST["id"]);
    echo "<form action=\"index.php?class=materia&cmd=edit\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"edit\" />";
    materiaFields($_POST["id"], $obj->getid(), $obj->getdpto(),
		  $obj->getcodigo(), $obj->getnombre());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=materia&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" />";
    materiaFields("","","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function materiaFields($oldid, $id, $dpto, $codigo, $nombre) {
  echo "
   <input type=\"hidden\" name=\"oldid\" value=\"" . $oldid ."\" /></br>
   Id: <input type=\"text\" name=\"id\" value=\"".$id."\" /></br>
   Departamento: <input type=\"text\" name=\"dpto\" value=\"".$dpto."\" /></br>
   Codigo: <input type=\"text\" name=\"codigo\" value=\"".$codigo."\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" value=\"".$nombre."\" /></br>";
}

function materiaInsert() {
  $obj = new Materia($_POST["id"],
		     $_POST["dpto"],
		     $_POST["codigo"],
		     $_POST["nombre"]);
  $obj->save();
  echo "Se ha agregado una nueva materia";
  materiaAll();
}

function materiaAll() {
  echo "</br><a href=\"index.php?class=materia&cmd=input\">Insertar nueva Materia</a></br>";

  $res = Materia::all();
  echo "<ul>";
  foreach ($res as $ind) {
    echo "<li>Materia: " . $ind. "

         <form action=\"index.php?class=materia&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $ind->getid() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>

         <form action=\"index.php?class=materia&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $ind->getid() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
         
         </li>";
  }
  echo "</ul>";
}

function materiaEdit() {
  $obj = Materia::getByKey($_POST["oldid"]);
  $obj->setid($_POST["id"]);
  $obj->setdpto($_POST["dpto"]);
  $obj->setcodigo($_POST["codigo"]);
  $obj->setnombre($_POST["nombre"]);
  $obj->save();
  echo "Se ha modificado una materia";
  materiaAll();
}

function materiaDelete() {
  $obj = Materia::getByKey($_POST["id"]);
  $obj->delete();
  echo "La materia " . $obj . " ha sido eliminada";
  materiaAll();
}

?>