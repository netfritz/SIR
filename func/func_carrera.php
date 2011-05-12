<?php

require_once("class/model/Carrera.php");

function carreraAll() {
  echo "</br><a href='index.php?class=carrera&cmd=input'>Insertar nueva Carrera</a></br>";

  $res = Carrera::all();
  echo "<ul>";
  foreach ($res as $ind) {
    echo "<li>Carrera: {$ind}

         <form action='index.php?class=carrera&cmd=input' method='post'>
         <input type='hidden' name='codigo' value='{$ind->getCodigo()}' />
         <input type='submit' value='Editar' />
         </form>

         <form action='index.php?class=carrera&cmd=delete' method='post'>
         <input type='hidden' name='codigo' value='{$ind->getCodigo()}' />
         <input type='submit' value='Borrar' />
         </form>
         
         </li>";
  }
  echo "</ul>";
}

function carreraDelete() {
  $obj = Carrera::getByKey($_POST["codigo"]);
  $obj->delete();
  echo "La carrera {$obj->getNombre()} ha sido eliminada";
  carreraAll();
}

function carreraInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Carrera::getByKey($_POST["codigo"]);
    echo "<form action='index.php?class=carrera&cmd=edit' method='post'
          <input type='hidden' name='type' value='edit' />";
      carreraFields(False, $obj->getCodigo(),
		    $obj->getNombre(), $obj->getDireccion(),
		    $obj->getCoordinador());
  } else {
    // Insertar nuevo
    echo "<form action='index.php?class=carrera&cmd=insert' method='post'
          <input type='hidden' name='type' value='new' />";
      carreraFields(True,"","","","");
  }
  echo "<input type='submit' value='Enviar' />";
}

function carreraInsert() {

  $reCodigo = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $codigo = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reCodigo)));
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $coordinador = filter_input(INPUT_POST, 'coordinador', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));

  if (!$codigo)
    echo "El codigo es invalido. Solo se permiten letras, numeros, espacios y guiones. </br>";
  if (!$nombre)
    echo "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra. </br>";
  if (!$direccion)
    echo "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.</br>";
  if (!$coordinador)
    echo "El coordinador es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";

  $existe = Carrera::getByKey($codigo);
  if ($existe != NULL)
    echo "Ya existe otra carrera con el mismo código. </br>";

  $obj = new Carrera($codigo, $nombre, $direccion, $coordinador);

  if (!($codigo && $nombre && $direccion && $coordinador && $existe == NULL) ) {
    // Error de validacion, reimprimir formulario
    echo "<form action='index.php?class=carrera&cmd=edit' method='post'
          <input type='hidden' name='type' value='edit' />";
    carreraFields(True, $codigo, $nombre, $direccion, $coordinador);
    echo "<input type='submit' value='Enviar' />";
  } else {
    // Ningún error, todo corre bien
    $obj->save();
    echo "Se ha agregado una nueva carrera";
    carreraAll();
  }
}

function carreraEdit() {
  $reNombres = "/^[a-zA-Z]+[a-zA-Z ]*[a-zA-Z]+$/";
  $reDireccion = "/^[a-zA-Z0-9]+[a-zA-Z0-9- ]*[a-zA-Z0-9]*$/";

  // Validar formulario
  $nombre  = filter_input(INPUT_POST, 'nombre', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  $direccion = filter_input(INPUT_POST, 'direccion', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reDireccion)));
  $coordinador = filter_input(INPUT_POST, 'coordinador', FILTER_VALIDATE_REGEXP, 
			 array("options"=>array("regexp"=>$reNombres)));
  if (!$nombre)
    echo "El nombre es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";
  if (!$direccion)
    echo "La direccion es invalida. Solo se permiten letras, numeros, espacios y guiones.</br>";
  if (!$coordinador)
    echo "El coordinador es invalido. Solo se permiten letras y espacios. Debe comenzar y terminar por una letra.</br>";

  $obj = Carrera::getByKey($_POST["codigo"]);
  $obj->setNombre($nombre);
  $obj->setDireccion($direccion);
  $obj->setCoordinador($coordinador);

  if (!($nombre && $direccion && $coordinador)) {
    echo "<form action='index.php?class=carrera&cmd=edit' method='post'
          <input type='hidden' name='type' value='edit' />";
    carreraFields(False, $_POST["codigo"], $nombre, $direccion, $coordinador);
    echo "<input type='submit' value='Enviar' />";
  } else {
    $obj->save();
    echo "Se ha modificado la carrera";
    carreraAll();
  }
}

function carreraFields($nuevo, $codigo, $nombre, $direccion, $coordinador) {
  if ($nuevo)
    echo "Codigo: <input type='text' name='codigo' value='{$codigo}' /></br>";
  else
    echo "Codigo: {$codigo} <input type='hidden' name='codigo' value='{$codigo}' /></br>";

  echo "
   Nombre: <input type='text' name='nombre' value='{$nombre}' /></br>
   Direccion: <input type='text' name='direccion' value='{$direccion}' /></br>
   Coordinador: <input type='text' name='coordinador' value='{$coordinador}' /></br>";
}

?>