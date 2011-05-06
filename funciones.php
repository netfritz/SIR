<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

function carreraInsert() {
  echo "
   <form action=\"index.php?class=carrera&cmd=finsert\" method=\"post\">
   <input type=\"hidden\" name=\"oldcodigo\"  /></br>
   Codigo: <input type=\"text\" name=\"codigo\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" /></br>
   Direccion: <input type=\"text\" name=\"direccion\" /></br>
   Coordinador: <input type=\"text\" name=\"coordinador\" /></br>
   <input type=\"submit\" value=\"Enviar\" />
   </form>";
}

function carreraFinsert() {
  $obj = new Carrera($_POST["codigo"],
		     $_POST["nombre"],
		     $_POST["direccion"],
		     $_POST["coordinador"]);
  $obj->save();
  echo "Se ha agregado una nueva carrera";
  carreraAll();
}

function carreraAll() {
  echo "</br><a href=\"index.php?class=carrera&cmd=insert\">Insertar nueva Carrera</a></br>";

  $res = Carrera::all();
  echo "<ul>";
  foreach ($res as $ind) {
    echo "<li>Carrera: " . $ind. "

         <form action=\"index.php?class=carrera&cmd=edit\" method=\"post\">
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
  $obj = Carrera::getByKey($_POST["codigo"]);
  echo "
   <form action=\"index.php?class=carrera&cmd=fedit\" method=\"post\">
   <input type=\"hidden\" name=\"oldcodigo\" value=\"".$obj->getCodigo()."\" /></br>
   Codigo: <input type=\"text\" name=\"codigo\" value=\"".$obj->getCodigo()."\" /></br>
   Nombre: <input type=\"text\" name=\"nombre\" value=\"".$obj->getNombre()."\" /></br>
   Direccion: <input type=\"text\" name=\"direccion\" value=\"".$obj->getDireccion()."\" /></br>
   Coordinador: <input type=\"text\" name=\"coordinador\" value=\"".$obj->getCoordinador()."\" /></br>
   <input type=\"submit\" value=\"Enviar\" />
   </form>";
}

function carreraFedit() {
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