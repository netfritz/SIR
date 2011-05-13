<?php

require_once("class/model/Materia.php");

// Muestra un formulario en pantalla para la clase Materia
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la materia y se
// devuelve un formulario precargado con los datos
function materiaInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Materia::getByKey($_POST["id"]);
    echo "<form action=\"index.php?class=materia&cmd=edit\" method=\"post\">";
    materiaFields($obj->getid(), $obj->getdpto(),
		  $obj->getcodigo(), $obj->getnombre());
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=materia&cmd=insert\" method=\"post\">";
    materiaFields("","","","");
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function materiaFields($id, $dpto, $codigo, $nombre) {
  echo "<input type='hidden' name='id'value='{$id}'  /></br>
   Nombre: <input type='text' name='nombre' value='{$nombre}' /></br>
   Codigo: <input type='text' name='codigo' value='{$codigo}' /></br>  
   Departamento: <input type='text' name='dpto' value='{$dpto}' /></br>";
  
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
  if (!$codigo)
    echo "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    echo "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$dpto)
    echo "El departamento es invalido. Solo se permiten letras, numeros, espacios y guiones.</br>";
  
  $obj = new Materia($dpto,$codigo,$nombre);
  if (!($dpto && $codigo && $nombre) ) {
    // Error de validacion, reimprimir formulario
    echo "<form action='index.php?class=materia&cmd=edit' method='post'>";
    materiaFields("", $dpto, $codigo, $nombre);
    echo "<input type='submit' value='Enviar' />";
  } else {
   // Ningún error, todo corre bien
   $obj->save();
   echo "Se ha agregado una nueva materia";
   materiaAll();
 }
}

function materiaAll() {
  echo "</br><a href=\"index.php?class=materia&cmd=input\">Insertar nueva Materia</a></br>";

  $res = Materia::all();
  echo "<table>
        <tr>       
         <th>Departamento</th>
         <th>Codigo</th>
         <th>Nombre</th>
        </tr>";
  foreach ($res as $ind) {
    echo "<tr>
      <td>{$ind->getdpto()}</td>
      <td>{$ind->getcodigo()}</td>
      <td>{$ind->getnombre()}</td>
      <td>
         <form action=\"index.php?class=materia&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $ind->getid() . "\" />
         <input type=\"submit\" value=\"Editar\" />
         </form>
      </td>
      <td>
         <form action=\"index.php?class=materia&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $ind->getid() . "\" />
         <input type=\"submit\" value=\"Borrar\" />
         </form>
    </td>     
         </tr>";
  }
  echo "</table>";
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
  if (!$codigo)
    echo "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    echo "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$dpto)
    echo "El departamento es invalido. Solo se permiten letras, numeros, espacios y guiones.</br>";

  $obj = Materia::getByKey($_POST["id"]);
  $obj->setnombre($nombre);
  $obj->setdpto($dpto);
  $obj->setcodigo($codigo);

  if (!($nombre && $dpto && $codigo)) {
    echo "<form action='index.php?class=materia&cmd=edit' method='post'>";
    materiaFields($_POST["id"], $dpto, $codigo, $nombre);
    echo "<input type='submit' value='Enviar' />";
  } else {
    $obj->save();
    echo "Se ha modificado la materia";
    materiaAll();
  }
}


function materiaDelete() {
  $obj = Materia::getByKey($_POST["id"]);
  $obj->delete();
  echo "La materia " . $obj->getnombre() . " ha sido eliminada";
  materiaAll();
}

?>
