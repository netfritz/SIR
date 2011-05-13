<?php

require_once("class/model/Universidad.php");

/* Muestra un formulario en pantalla para la clase Universidad
 * Cuando es llamado via GET, devuelve un formulario vacio
 * Cuando es por POST, se asume que contiene el código de la universidad y se
 * devuelve un formulario precargado con los datos
 */
function universidadInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Universidad::getByKey($_POST["nombre"]);
    echo "<form action=\"index.php?class=universidad&cmd=edit\" method=\"post\">
          <input type=\"hidden\" name=\"type\" value=\"edit\" />
	  <input type=\"hidden\" name=\"nombre\" value=\"".$_POST["nombre"]."\"/>
 	      Nombre: " .$_POST["nombre"]. "</br>";
    universidadFields($_POST["nombre"], $obj->getPais(),
                      $obj->getEstado(), $obj->getCiudad(),
                      $obj->getDireccion(), $obj->getRector(), $obj->getUrl());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=universidad&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" /></br>
          Nombre: <input type=\"text\" name=\"nombre\" /></br>";
    universidadFields("","","","","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" /> 
	</form>";
}

/* Imprime por pantalla un formulario con un campo para cada atributo necesario
 * de la clase. Permite que se le de un valor inicial a cada campo
 */
function universidadFields($nombre,$pais,$estado,$ciudad,$direccion,$rector,$url) {
  echo "
   Pais: <input type=\"text\" name=\"pais\" value=\"".$pais."\" /></br>
   Estado: <input type=\"text\" name=\"estado\" value=\"".$estado."\" /></br>
   Ciudad: <input type=\"text\" name=\"ciudad\" value=\"".$ciudad."\" /></br>
   Direccion: <input type=\"text\" name=\"direccion\" value=\"".$direccion."\" /></br>
   Rector: <input type=\"text\" name=\"rector\" value=\"".$rector."\" /></br>
   URL: <input type=\"text\" name=\"url\" value=\"".$url."\" /></br> ";
}

function universidadInsert() {
  if($_POST["nombre"]=="" || $_POST["pais"]=="" ||
     $_POST["estado"]=="" || $_POST["ciudad"]=="" ||
     $_POST["direccion"]=="" || $_POST["rector"]=="" ||
     $_POST["url"]=="")
    {
      echo "Error. La universidad no se ha agregado. Debe llenar TODOS los campos";
    }else {

    $object = Universidad::getByKey($_POST["nombre"]);
    if (!isset($object)){
      $obj = new Universidad($_POST["nombre"],
                             $_POST["pais"],
                             $_POST["estado"],
                             $_POST["ciudad"],
                             $_POST["direccion"],
                             $_POST["rector"],
                             $_POST["url"]);
      $obj->save();
      echo "Se ha agregado una nueva universidad";
    }else{
      echo "Error. Esta universidad ya ha sido agregada a la Base de datos";
    }
  }
  universidadAll();
}

function universidadAll() {
  echo "</br><a href=\"index.php?class=universidad&cmd=input\">Insertar nueva Universidad</a></br>";

  $res = Universidad::all();
  echo "<ul>";
 if ($res) {
  foreach ($res as $ind) {
    echo "<li>Universidad: " . $ind. "

         <form action=\"index.php?class=universidad&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"nombre\" value=\"" . $ind->getNombre() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>

         <form action=\"index.php?class=universidad&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"nombre\" value=\"" . $ind->getNombre() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
         
         </li>";
  }
 } else {
    echo "<li>En este momento no hay universidades registrados</li>";
  }
  echo "</ul>";
}

function universidadEdit() {
  $obj = Universidad::getByKey($_POST["nombre"]);
  $obj->setPais($_POST["pais"]);
  $obj->setEstado($_POST["estado"]);
  $obj->setCiudad($_POST["ciudad"]);
  $obj->setDireccion($_POST["direccion"]);
  $obj->setRector($_POST["rector"]);
  $obj->setUrl($_POST["url"]);
  $obj->save();
  echo "Se ha modificado la universidad";
  universidadAll();
}

function universidadDelete() {
  $obj = Universidad::getByKey($_POST["nombre"]);
  $obj->delete();
  echo "La universidad " . $obj . " ha sido eliminada";
  universidadAll();
}

?>
