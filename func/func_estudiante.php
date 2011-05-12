<?php

require_once("class/model/Estudiante.php");

// Muestra un formulario en pantalla para la clase Estudiante
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la carrera y se
// devuelve un formulario precargado con los datos
function estudianteInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Estudiante::getByKey($_POST["id"]);
    echo "<form action=\"index.php?class=estudiante&cmd=edit\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"edit\" />";
    estudianteFields($obj->getDoc_Id(),
		     $obj->getCarnet(), $obj->getNombre(),
		     $obj->getApellido(), $obj->getFecha_nac(),
                     $obj->getColegio_origen(),True);
  } else {
    // Insertar nuevo
    echo "<form action=\"index.php?class=estudiante&cmd=insert\" method=\"post\"
          <input type=\"hidden\" name=\"type\" value=\"new\" />";
    estudianteFields("","","","","","",True);
  }
  echo "<input type=\"submit\" value=\"Enviar\" />";
}

function tableRowInput($id,$label,$value,$name){
  return "<tr>
            <th>
              <label for=\"id_".$id."\">".$label."</label>
            </th>
            <td>
              <input type=\"text\" id=\"id_".$id."\" name=\"".$name."\" value=\"".$value."\"/>
            </td>
          </tr>";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function estudianteFields($id,  $carnet, $nombre, $apellido, $fecha_nac, $colegio, $insert = False) {
  if ($insert) {
    $clave= "
           <input type=\"text\" id=\"id_doc_id\" name=\"id\" value=\"".$id."\"/>";
  } else {
    $clave= "
           <input type=\"hidden\" name=\"id\" value=\"" . $id ."\" />
           <p id=\"id_doc_id\">".$id."</p>";
  }
  
  $msj ="
   <table>
     <tbody>
       <tr>
         <th>
           <label for=\"id_doc_id\">Documento de identidad:</label>
         </th>
         <td>".$clave."
         </td>
       </tr>".
    tableRowInput("carnet","Carnet:",$carnet,"carnet").
    tableRowInput("nombre","Nombre:",$nombre,"nombre").
    tableRowInput("apellido","Apellido:",$apellido,"apellido").
    tableRowInput("fecha_nac","Fecha de Nacimiento:",$fecha_nac,"fecha_nac").
    tableRowInput("colegio","Colegio de Origen:",$colegio,"colegio").
    "       
     </tbody>
   </table>
   ";
    echo $msj;
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
  if ($res) {
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
  } else {
    echo "<li>En este momento no hay estudiantes registrados</li>";
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