<?php

require_once("interfaz.php");
require_once("class/model/Universidad.php");

/*
 * $bloqueMsj guarda el html que representa los mensajes
 * $tabla guarda el html que...representa la tabla
 */

class interfazUNIVERSIDADAll extends interfazAll {
  
  public function printv() {

    // Generar el html que representa los mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} <br />";
    }

    $tabla = "";
    if($this->instancias != null){
    // Generar html para la tabla de instancias
  
    foreach ($this->instancias as $inst) {
      $tabla .= "
         <tr>
           <td>{$inst->getNombre()}</td>
           <td>{$inst->getPais()}</td>
           <td>{$inst->getEstado()}</td>
           <td>{$inst->getCiudad()}</td>
           <td>{$inst->getDireccion()}</td>
           <td>{$inst->getRector()}</td>
           <td>{$inst->getURL()}</td>
           <td> 
             <form action='index.php?class=universidad&cmd=input' method='post'>
               <input type='hidden' name='nombre' value='{$inst->getNombre()}' />
               <input type='submit' value='Editar' />
             </form>
           </td>
           <td>
             <form action='index.php?class=universidad&cmd=delete' method='post'>
               <input type='hidden' name='nombre' value='{$inst->getNombre()}' />
               <input type='submit' value='Borrar' />
             </form>         
           </td>
         </tr>";
    }
}
    // Unir todo dentro del template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Universidades</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=universidad&cmd=input'>Insertar nueva Universidad</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th>Nombre</th>
                  <th>Pais</th>
                  <th>Estado</th>
                  <th>Ciudad</th> 
                  <th>Direccion</th>
                  <th>Rector</th>
                  <th>URL</th>
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
class interfazUniversidadForm extends interfazForm {

  public function printv() {

    // Generar titulo
    $titulo = $this->instancia != NULL ? "Modificar una Universidad <br />" 
      : "Agregar una nueva Universidad <br />";

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
    $nombre = "";
    if ($this->instancia != NULL) {
      $campos["nombre"] = $this->instancia->getNombre();
      $campos["pais"] = $this->instancia->getPais();
      $campos["estado"] = $this->instancia->getEstado();
      $campos["direccion"] = $this->instancia->getDireccion();
      $campos["rector"] = $this->instancia->getRector();
      $campos["url"] = $this->instancia->getUrl();
      $campos["ciudad"] = $this->instancia->getCiudad();       
      if (!$this->nuevo) {
	$nombre = $campos['nombre'];
	$claveType = 'hidden';
      }

    }else{
      $campos["nombre"] = "";
      $campos["pais"] = "";
      $campos["estado"] = "";
      $campos["direccion"] = "";
      $campos["rector"] = "";
      $campos["url"] = "";
      $campos["ciudad"] = "";       
    }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Universidad</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>

              <form action='index.php?class=universidad&cmd={$cmd}' method='post'>
                <table>
                  <tr>
                    <td>Nombre:</td>
                    <td>{$nombre} <input type='{$claveType}' name='nombre' value='{$campos['nombre']}' maxlength='25' /></td>
                  </tr>
                  <tr>
                    <td>Pais:</td>
                    <td> <input type='text' name='pais' value='{$campos['pais']}' maxlength='25' /></td>
                  <tr>
                    <td>Estado:</td>
                    <td><input type='text' name='estado' value='{$campos['estado']}' maxlength='25' /> </td>
                  </tr>
                  <tr>
                    <td>Ciudad:</td>
                    <td><input type='text' name='ciudad' value='{$campos['ciudad']}' maxlength='25' /> </td>
                  </tr>
                  <tr>
                    <td>Direccion:</td>
                    <td><input type='text' name='direccion' value='{$campos['direccion']}' maxlength='100'  /> </td>
                  <tr>
                  <tr>
                    <td>Rector:</td>
                    <td><input type='text' name='rector' value='{$campos['rector']}' maxlength='25'  /> </td>
                  <tr>
                  <tr>
                    <td>Url:</td>
                    <td><input type='text' name='url' value='{$campos['url']}' maxlength='300'  /> </td>
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
