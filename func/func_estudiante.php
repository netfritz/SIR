<?php

require_once("class/model/Estudiante.php");

function dateInput($id,$label,$value,$name, $day, $month, $year){
  $dias = range (1, 31);
  $meses = array (1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
  $anios = range (1900, 2000);
  $html = "<tr>
             <th>
               <label for=\"id_".$id."\">".$label."</label>
             </th>
             <td>
               <div id=\"id_".$id."\" >";
  
  $html .= 'Día: <select id="id_'.$id.'_dia" name="'.$name.'_dia">';
  foreach ($dias as $val) {
    if ($val == $day) {
      $html .= '<option selected value="'.$val.'">'.$val.'</option>\n';
    } else {
      $html .= '<option value="'.$val.'">'.$val.'</option>\n';
    }
  } 
  $html .= '</select>';

  $html .= 'Mes: <select id="id_'.$id.'_mes" name="'.$name.'_mes">';
  foreach ($meses as $val) {
    if ($val == $month) {
      $html .= '<option selected value="'.$val.'">'.$val.'</option>\n';
    } else {
      $html .= '<option value="'.$val.'">'.$val.'</option>\n';
    }
  }
  $html .= '</select>';
  
  $html .= 'Año: <select id="id_'.$id.'_anio" name="'.$name.'_anio">';
  foreach ($anios as $val) {
    if ($val == $year) {
      $html .= '<option selected value="'.$val.'">'.$val.'</option>\n';
    } else {
      $html .= '<option value="'.$val.'">'.$val.'</option>\n';
    }
  }
  
  $html .= "   </div>
             </td>
           </tr>";
  return $html;
}

// Muestra un formulario en pantalla para la clase Estudiante
// Cuando es llamado via GET, devuelve un formulario vacio
// Cuando es por POST, se asume que contiene el código de la carrera y se
// devuelve un formulario precargado con los datos
function estudianteInput() {
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $obj = Estudiante::getByKey($_POST["id"]);
    $html = "<form action=\"index.php?class=estudiante&cmd=edit\" method=\"post\">";
    $html .= "<input type=\"hidden\" name=\"type\" value=\"edit\" />";
    $html .= estudianteFields($obj->getDoc_Id(),
                              $obj->getCarnet(),
                              $obj->getNombre(),
                              $obj->getApellido(),
                              $obj->getFecha_nac(),
                              $obj->getColegio_origen(),
                              False);
  } else {
    // Insertar nuevo
    $html = "<form action=\"index.php?class=estudiante&cmd=insert\" method=\"post\">
               <input type=\"hidden\" name=\"type\" value=\"new\" />";
    $html .= estudianteFields("","","","",NULL,"",True);
  }
  $html .= "<input type=\"submit\" value=\"Enviar\"/>
            <a href=\"index.php?class=estudiante\">Volver</a>
          </form>";
  echo $html;
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
           <input type=\"hidden\" name=\"id\" value=\"" . $id ."\" />".$id;
  }

  if ($fecha_nac == NULL) {
    $dia = NULL;
    $mes = NULL;
    $anio = NULL;
  } else {
    $aux = explode('-',$fecha_nac);
    $dia = $aux[2];
    $mes = $aux[1];
    $anio = $aux[0];
  }
  $html ="
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
    dateInput("fecha_nac","Fecha de Nacimiento:",$fecha_nac,"fecha_nac",$dia,$mes,$anio).
    tableRowInput("colegio","Colegio de Origen:",$colegio,"colegio").
    "       
     </tbody>
   </table>
   ";
    return $html;
}

function estudianteInsert() {
  $meses = array('Enero' => 01, 'Febrero' => 02, 'Marzo' => 03, 'Abril' => 04, 'Mayo' => 05,
                 'Junio' => 06,'Julio' => 07, 'Agosto' => 08, 'Septiembre' => 09, 'Octubre' => 10,
                 'Noviembre' => 11, 'Diciembre' => 12);

  $id = $_POST["id"];
  $carnet = $_POST["carnet"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dia = $_POST["fecha_nac_dia"];
  $mes = $_POST["fecha_nac_mes"];
  $anio = $_POST["fecha_nac_anio"];
  $fecha_nac = $anio."-".$meses[$mes]."-".$dia;
  $colegio = $_POST["colegio"];

  // VALIDAR

  $obj = new Estudiante($id,
                        $carnet,
                        $nombre,
                        $apellido,
                        $fecha_nac,
                        $colegio);
  $obj->save();
  echo "Se ha agregado un nuevo estudiante";
  estudianteAll();
}

function tableRowAll($student){
  $html = "
           <tr>
             <td align=\"center\">
               <p><strong>".$student->getDoc_Id()."</strong></p>
             </td>
             <td align=\"center\">
               <p>".$student->getCarnet()."</p>
             </td>
             <td align=\"center\">
               <p>".$student->getNombre()."</p>
             </td>
             <td align=\"center\">
               <p>".$student->getApellido()."</p>
             </td>
             <td align=\"center\">
               <p>".$student->getFecha_nac()."</p>
             </td>
             <td align=\"center\">
               <p>".$student->getColegio_origen()."</p>
             </td>
             <td align=\"center\">
               <form action=\"index.php?class=estudiante&cmd=input\" method=\"POST\">
                 <input type=\"hidden\" name=\"id\" value=\"" . $student->getDoc_Id() . "\" />
                 <input type=\"image\" src=\"resources/images/lapiz3.png\" alt=\"Editar\" height=\"20px\" width=\"20px\"/>
               </form>
             </td>
             <td align=\"center\">
               <form action=\"index.php?class=estudiante&cmd=delete\" method=\"POST\">
                 <input type=\"hidden\" name=\"id\" value=\"" . $student->getDoc_Id() . "\" />
                 <input type=\"image\" src=\"resources/images/equis3.png\" alt=\"Borrar\" height=\"20px\" width=\"20px\"/>
               </form>
             </td>
           </tr>";
  return $html;
}

function estudianteAll() {
  echo "</br><a href=\"index.php?class=estudiante&cmd=input\">Insertar nuevo Estudiante</a></br>";

  $res = Estudiante::all();
  if ($res) {
    $students = "";
    foreach ($res as $ind) {
      $students .= tableRowAll($ind);
    }
    $html ="
     <table>
       <tbody>
         <tr>
           <th align=\"center\">
             <p>Documento de identidad</p>
           </th>
           <th align=\"center\">
             <p>Carnet</p>
           </th>
           <th align=\"center\">
             <p>Nombre</p>
           </th>
           <th align=\"center\">
             <p>Apellido</p>
           </th>
           <th align=\"center\">
             <p>Fecha de Nacimiento</p>
           </th>
           <th align=\"center\">
             <p>Colegio de Origen</p>
           </th>
         </tr>".
         $students.
       "</tbody>
     </table>";
  } else {
    $html = "<p>En este momento no hay estudiantes registrados</p>";
  }
  echo $html;
}

function estudianteEdit() {
  $meses = array('Enero' => 01, 'Febrero' => 02, 'Marzo' => 03, 'Abril' => 04, 'Mayo' => 05,
                 'Junio' => 06,'Julio' => 07, 'Agosto' => 08, 'Septiembre' => 09, 'Octubre' => 10,
                 'Noviembre' => 11, 'Diciembre' => 12);
  $id = $_POST["id"];
  $carnet = $_POST["carnet"];
  $nombre = $_POST["nombre"];
  $apellido = $_POST["apellido"];
  $dia = $_POST["fecha_nac_dia"];
  $mes = $_POST["fecha_nac_mes"];
  $anio = $_POST["fecha_nac_anio"];
  $fecha_nac = $anio."-".$meses[$mes]."-".$dia;
  $colegio = $_POST["colegio"];

  echo "esta es la fecha!!!! : ".$fecha_nac."<br/>";

  // VALIDAR
  
  
  $obj = Estudiante::getByKey($id);
  $obj->setCarnet($carnet);
  $obj->setNombre($nombre);
  $obj->setApellido($apellido);
  $obj->setFecha_nac($fecha_nac);
  $obj->setColegio_origen($colegio);
  $obj->save();
  echo "Se ha modificado un estudiante";
  echo "esta es la fecha!!!! : ".$fecha_nac."<br/>";
  estudianteAll();
}

function estudianteDelete() {
  $obj = Estudiante::getByKey($_POST["id"]);
  $obj->delete();
  echo "El estudiante " . $obj . " ha sido eliminado";
  estudianteAll();
}

?>