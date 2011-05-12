<?php

require_once("interfaz.php");
require_once("class/model/CLASE.php");

/*
 * $bloqueMsj guarda el html que representa los mensajes
 * $tabla guarda el html que...representa la tabla
 */

class interfazCLASEAll extends interfazAll {
  
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
           <td>{$inst->getATRIBUTO1()}</td>
           <td>{$inst->getATRIBUTO2()}</td>
           <td>{$inst->getATRIBUTO3()}</td>
           <td>{$inst->getATRIBUTOn()}</td>
           <td> 
             <form action='index.php?class=CLASE&cmd=input' method='post'>
               <input type='hidden' name='CLAVE1' value='{$inst->getCLAVE1()}' />
               <input type='hidden' name='CLAVE2' value='{$inst->getCLAVE2()}' />
               <input type='submit' value='Editar' />
             </form>
           </td>
           <td>
             <form action='index.php?class=CLASE&cmd=delete' method='post'>
               <input type='hidden' name='CLAVE1' value='{$inst->getCLAVE1()}' />
               <input type='hidden' name='CLAVE2' value='{$inst->getCLAVE2()}' />
               <input type='submit' value='Borrar' />
             </form>         
           </td>
         </tr>";
    }

    // Unir todo dentro del template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>CLASE</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=CLASE&cmd=input'>Insertar nueva CLASE</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th>ATRIBUTO1</th>
                  <th>ATRIBUTO2</th>
                  <th>ATRIBUTO3</th>
                  <th>ATRIBUTOn</th>
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
class interfazCLASEForm extends interfazForm {

  public function printv() {

    // Generar titulo
    $titulo = $this->instancia != NULL ? "Modificar una CLASE <br />" 
      : "Agregar una nueva CLASE <br />";

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
    $CLAVE1 = "";
    $CLAVE2 = "";
    if ($this->instancia != NULL) {
      $campos["ATRIBUTO1"] = $this->instancia->getATRIBUTO1();
      $campos["ATRIBUTO2"] = $this->instancia->getATRIBUTO2();
      $campos["ATRIBUTO3"] = $this->instancia->getATRIBUTO3();
      $campos["ATRIBUTOn"] = $this->instancia->getATRIBUTOn();
            
      if (!$this->nuevo) {
	$CLAVE1 = $campos['CLAVE1'];
	$CLAVE2 = $campos['CLAVE2'];
	$claveType = 'hidden';
      }

    }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>CLASE</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>

              <form action='index.php?class=CLASE&cmd={$cmd}' method='post'>
                <table>
                  <tr>
                    <td>CLAVE1:</td>
                    <td>{$CLAVE1} <input type='{$claveType}' name='CLAVE1' value='{$campos['CLAVE1']}' maxlength='25' /></td>
                  </tr>
                  <tr>
                    <td>CLAVE2:</td>
                    <td>{$CLAVE2} <input type='{$claveType}' name='CLAVE2' value='{$campos['CLAVE2']}' maxlength='25' /></td>
                  <tr>
                    <td>ATRIBUTO:</td>
                    <td><input type='text' name='ATRIBUTO' value='{$campos['ATRIBUTO']}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>ATRIBUTO:</td>
                    <td><input type='text' name='ATRIBUTO' value='{$campos['ATRIBUTO']}' maxlength='100' /> </td>
                  </tr>
                  <tr>
                    <td>ATRIBUTO:</td>
                    <td><input type='text' name='ATRIBUTO' value='{$campos['ATRIBUTO']}' maxlength='100'  /> </td>
                  <tr>
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