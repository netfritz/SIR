<?php

require_once("class/model/Departamento.php");

function departamentoAll() {
  echo "</br><a href='index.php?class=departamento&cmd=input'>Insertar nuevo Departamento</a></br>";

  $res = Departamento::all();
  echo "<table>
          <tr>
            <th>Universidad</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Direccion</th>
          </tr>";
  foreach ($res as $inst) {
    echo "<tr>
           <td>{$inst->getUniversidad()}</td>
           <td>{$inst->getCodigo()}</td>
           <td>{$inst->getNombre()}</td>
           <td>{$inst->getDireccion()}</td>
           <td> 
             <form action='index.php?class=departamento&cmd=input' method='post'>
               <input type='hidden' name='id' value='{$inst->getId()}' />
               <input type='submit' value='Editar' />
             </form>
           </td>
           <td>
             <form action='index.php?class=departamento&cmd=delete' method='post'>
               <input type='hidden' name='id' value='{$inst->getId()}' />
               <input type='submit' value='Borrar' />
             </form>         
           </td>
         </tr>";
  }
  echo "</table>";
}

function departamentoDelete() {
  $obj = Departamento::getByKey($_POST["id"]);
  $obj->delete();
  echo "El departamento {$obj->getNombre()} ha sido eliminado";
  departamentoAll();
}

function departamentoInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Departamento::getByKey($_POST["id"]);
    echo "<form action='index.php?class=departamento&cmd=edit' method='post'>";
      departamentoFields($obj->getId(), $obj->getUniversidad(), $obj->getCodigo(),
		    $obj->getNombre(), $obj->getDireccion());
  } else {
    // Insertar nuevo
    echo "<form action='index.php?class=departamento&cmd=insert' method='post'>";
      departamentoFields("","","","","");
  }
  echo "<input type='submit' value='Enviar' />";
}

function departamentoInsert() {
  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $universidad = filter_input(INPUT_POST, 'universidad', FILTER_VALIDATE_REGEXP, 
			      array("options"=>array("regexp"=>$reNombres)));
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));

  if (!$universidad)
    echo "La universidad es invalida. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$codigo)
    echo "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    echo "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$direccion)
    echo "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.</br>";

  $obj = new Departamento($universidad, $codigo, $nombre, $direccion);

  if (!($universidad && $codigo && $nombre && $direccion) ) {
    // Error de validacion, reimprimir formulario
    echo "<form action='index.php?class=departamento&cmd=edit' method='post'>";
      departamentoFields("", $universidad, $codigo, $nombre, $direccion);
    echo "<input type='submit' value='Enviar' />";
  } else {
    // Ningún error, todo corre bien
    $obj->save();
    echo "Se ha agregado un nuevo departamento";
    departamentoAll();
  }
}

function departamentoEdit() {
  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $universidad = filter_input(INPUT_POST, 'universidad', FILTER_VALIDATE_REGEXP, 
			      array("options"=>array("regexp"=>$reNombres)));
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  if (!$universidad)
    echo "La universidad es invalida. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$codigo)
    echo "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    echo "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$direccion)
    echo "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.</br>";

  $obj = Departamento::getByKey($_POST["id"]+0);
  $obj->setUniversidad($universidad);
  $obj->setCodigo($codigo);
  $obj->setNombre($nombre);
  $obj->setDireccion($direccion);

  if (!($universidad && $codigo && $nombre && $direccion)) {
    echo "<form action='index.php?class=departamento&cmd=edit' method='post'>";
    departamentoFields($_POST["id"], $universidad, $codigo, $nombre, $direccion);
    echo "<input type='submit' value='Enviar' />";
  } else {
    $obj->save();
    echo "Se ha modificado el departamento";
    departamentoAll();
  }
}

function departamentoFields($id, $universidad, $codigo, $nombre, $direccion) {
    echo "<input type='hidden' name='id' value='{$id}' /></br>
   Universidad: <input type='text' name='universidad' value='{$universidad}' /></br>
   Codigo: <input type='text' name='codigo' value='{$codigo}' /></br>
   Nombre: <input type='text' name='nombre' value='{$nombre}' /></br>
   Direccion: <input type='text' name='direccion' value='{$direccion}' /></br>";
}

?>