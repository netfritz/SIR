<?php

require_once("class\model\Agrupacion.php");

// Muestra un formulario en pantalla para la clase Agrupacion
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la agrupacion y se
// devuelve un formulario precargado con los datos
function agrupacionInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Agrupacion::getByKey($_POST["univ"],$_POST["nombre"]);
    echo "<form action=\"index.php?class=agrupacion&cmd=edit\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"edit\" />";
    agrupacionFields($obj->getUniversidad(),
		     $obj->getNombre(), $obj->getPresidente(), $obj->getMision(),
		     $obj->getVision());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=agrupacion&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" />";
    agrupacionFields("","","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function agrupacionFields($univ, $nombre, $pres, $mision, $vision) {
 
    echo "   
   Universidad: <input type=\"text\" name=\"univ\" value=\"".$univ."\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" value=\"".$nombre."\" /></br>
   Presidente: <input type=\"text\" name=\"pres\" value=\"".$pres."\" /></br>
   Mision: <input type=\"text\" name=\"mision\" value=\"".$mision."\" /></br>
   Vision: <input type=\"text\" name=\"vision\" value=\"".$vision."\" /></br>";
}

function agrupacionInsert() {
  $obj = new Agrupacion($_POST["univ"],
			$_POST["nombre"],
			$_POST["pres"],
			$_POST["mision"],
			$_POST["vision"]);
  $obj->save();
  echo "Se ha agregado una nueva agrupacion";
  agrupacionAll();
}

function agrupacionAll() {
  echo "</br><a href=\"index.php?class=agrupacion&cmd=input\">Insertar nueva Agrupacion</a></br>";

  $res = Agrupacion::all();
  echo "<ul>";
  if($res){
  foreach ($res as $ind) {
    echo "<li>Agrupacion: " . $ind. "

         <form action=\"index.php?class=agrupacion&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"univ\" value=\"" . $ind->getUniversidad() . "\" />
         <input type=\"hidden\" name=\"nombre\" value=\"" . $ind->getNombre() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>

         <form action=\"index.php?class=agrupacion&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"univ\" value=\"" . $ind->getUniversidad() . "\" />
         <input type=\"hidden\" name=\"nombre\" value=\"" . $ind->getNombre() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
         
         </li>";
  }
  
  }
  else{
      echo "No hay agrupaciones en la base de datos";
  }
  echo "</ul>";
}

function agrupacionEdit() {
  $obj = Agrupacion::getByKey($_POST["univ"],$_POST["nombre"]);
//  $obj->setUniversidad($_POST["univ"]);
//  $obj->setNombre($_POST["nombre"]);
  $obj->setPresidente($_POST["pres"]);
  $obj->setMision($_POST["mision"]);
  $obj->setVision($_POST["vision"]);
  $obj->save();
  echo "Se ha modificado la agrupacion";
  agrupacionAll();
}

function agrupacionDelete() {
  $obj = Agrupacion::getByKey($_POST["univ"],$_POST["nombre"]);
  $obj->delete();
  echo "La agrupacion " . $obj . " ha sido eliminada";
  agrupacionAll();
}

?>