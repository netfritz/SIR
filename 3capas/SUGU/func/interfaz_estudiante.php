<?php

require_once("interfaz.php");
require_once("class/model/Estudiante.php");

/*
 * $bloqueMsj guarda el html que representa los mensajes
 * $tabla guarda el html que...representa la tabla
 */

class interfazEstudianteAll extends interfazAll {
  
  public function printv() {

    // Generar el html que representa los mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} <br />";
    }
    
    // Generar html para la tabla de instancias
    $tabla = "";
    foreach ($this->instancias as $inst) {
      $tabla .= "
         <tr>
           <td>{$inst->getDoc_Id()}</td>
           <td>{$inst->getCarnet()}</td>
           <td>{$inst->getNombre()}</td>
           <td>{$inst->getApellido()}</td>
           <td>{$inst->getFecha_nac()}</td>
           <td>{$inst->getColegio_origen()}</td>
           <td> 
             <form action='index.php?class=estudiante&cmd=input' method='post'>
               <input type='hidden' name='id' value='{$inst->getDoc_Id()}' />
               <input type=\"image\" src=\"resources/images/lapiz3.png\" alt=\"Editar\" height=\"20px\" width=\"20px\"/>
             </form>
           </td>
           <td>
             <form action='index.php?class=estudiante&cmd=delete' method='post'>
               <input type='hidden' name='id' value='{$inst->getDoc_Id()}' />
               <input type=\"image\" src=\"resources/images/equis3.png\" alt=\"Borrar\" height=\"20px\" width=\"20px\"/>
             </form>         
           </td>
         </tr>";
    }

    // Unir todo dentro del template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Estudiantes</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=estudiante&cmd=input'>Insertar un nuevo estudiante</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th align=\"center\"><p>Documento de Identidad</p></th>
                  <th align=\"center\"><p>Carnet</p></th>
                  <th align=\"center\"><p>Nombre</p></th>
                  <th align=\"center\"><p>Apellido</p></th>
                  <th align=\"center\"><p>Fecha de Nacimiento</p></th>
                  <th align=\"center\"><p>Colegio de Origen</p></th>
                </tr>

                {$tabla}

              </table>
              </p>
            </div>
          </div>
          <div style='clear: both;'>&nbsp;</div>
        </div>
	<div style='clear: both;'>&nbsp;</div>
      </div>
      <!-- end #page -->";
  }
}



/*
 * Cómo funciona interfazCLASEForm
 * Primero se generan las partes dinámicas de la página y se guardan en variables
 * luego se hace un echo de la página de verdad con las variables generadas
 * La variable $titulo guarda el titulo que aparece antes del formulario
 *   Se usar para mostrar 'Agregar' o 'Editar' de acuerdo al contexto
 * La variable $bloqueMsj guarda el html que muestra los mensajes
 * La variable $cmd guarda a donde va a ser enviado el formulario (insert o edit)
 * $campos es un arreglo asociativo que contiene los campos del formulario
 * Cabe destacar que los campos clave del formulario deben ser modificables si el
 * formulario es para 'insert', y no deben serlo si es para 'edit'
 * Lean bien el codigo para que vean como funciona esta parte
 */
class interfazEstudianteForm extends interfazForm {
    
  public function tableRowInput($id,$label,$value,$name){
    return "<tr>
            <th>
              <label for=\"id_".$id."\">".$label."</label>
            </th>
            <td>
              <input type=\"text\" id=\"id_".$id."\" name=\"".$name."\" value=\"".$value."\"/>
            </td>
          </tr>";
  }
  
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
    public function printv() {

    // Generar titulo
    $titulo = $this->instancia != NULL ? "Modificar un Estudiante <br />" 
      : "Agregar un nuevo Estudiante <br />";

    // Generar html para los mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} </br>";
    }

    // Determinar el objetivo de este formulario
    $cmd = $this->nuevo ? "insert" : "edit";
 
    // Precargar los campos si se pretende editar una instancia
    $campos = array();
    $claveType = "text";
    $doc_id = "id";
    if ($this->instancia != NULL) {
      $campos["id"] = $this->instancia->getDoc_Id();
      $campos["carnet"] = $this->instancia->getCarnet();
      $campos["nombre"] = $this->instancia->getNombre();
      $campos["apellido"] = $this->instancia->getApellido();
      $campos["fecha_nac"] = $this->instancia->getFecha_nac();
      $campos["colegio"] = $this->instancia->getColegio_origen();
    } else {
      $campos["id"] = "";
      $campos["carnet"] = "";
      $campos["nombre"] = "";
      $campos["apellido"] = "";
      $campos["fecha_nac"] = "";
      $campos["colegio"] = "";
    }             
      if (!$this->nuevo) {
        $doc_id = $campos["id"];
        $claveType = 'hidden';
      }
      
      if ($campos["fecha_nac"] == NULL) {
        $dia = NULL;
        $mes = NULL;
        $anio = NULL;
      } else {
        $aux = explode('-',$fecha_nac);
        $dia = $aux[2];
        $mes = $aux[1];
        $anio = $aux[0];
      }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Estudiantes</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>

              <form action='index.php?class=estudiante&cmd={$cmd}' method='post'>
                <table>
                  <tbody>
                    <tr>
                      <th><label for=\"id_doc_id\">Documento de identificación:</label></th>
                      <td>{$doc_id} <input type='{$claveType}' name='id' id='id_doc_id' value=\"".$campos["id"]."\" maxlength='25' /></td>
                    </tr>".
                    $this->tableRowInput("carnet","Carnet:",$campos["carnet"],"carnet").
                    $this->tableRowInput("nombre","Nombre:",$campos["nombre"],"nombre").
                    $this->tableRowInput("apellido","Apellido:",$campos["apellido"],"apellido").
                    $this->dateInput("fecha_nac","Fecha de Nacimiento:",$campos["fecha_nac"],"fecha_nac",$dia,$mes,$anio).
                    $this->tableRowInput("colegio","Colegio de Origen:",$campos["colegio"],"colegio").
                    "
                  </tbody>
                </table>
                <input type='submit' value='Enviar' />
              </form>
            </div>
          </div>
	  <div style='clear: both;'>&nbsp;</div>
	</div>
	<div style='clear: both;'>&nbsp;</div>
      </div>
      <!-- end #page -->";
  }
}

?>