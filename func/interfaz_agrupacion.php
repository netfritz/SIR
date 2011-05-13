<?php

require_once("interfaz.php");
require_once("class/model/Agrupacion.php");

class interfazAgrupacionAll extends interfazAll {
  
  public function printv() {

    // Generar el html que representa los mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} </br>";
    }
    
    // Generar html para la tabla de instancias
    $tabla = "";
    foreach ($this->instancias as $inst) {
      $tabla .= "
         <tr>
           <td>{$inst->getUniversidad()}</td>
           <td>{$inst->getNombre()}</td>
           <td>{$inst->getPresidente()}</td>
           <td>{$inst->getMision()}</td>
           <td>{$inst->getVision()}</td>
           <td> 
             <form action='index.php?class=agrupacion&cmd=input' method='post'>
               <input type='hidden' name='universidad' value='{$inst->getUniversidad()}' />
               <input type='hidden' name='nombre' value='{$inst->getNombre()}' />
               <input type='submit' value='Editar' />
             </form>
           </td>
           <td>
             <form action='index.php?class=agrupacion&cmd=delete' method='post'>
               <input type='hidden' name='universidad' value='{$inst->getUniversidad()}' />
               <input type='hidden' name='nombre' value='{$inst->getNombre()}' />
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
            <h2 class='title'><a href='#'>Agrupaciones</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=agrupacion&cmd=input'>Insertar nueva Agrupacion</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th>Universidad</th>
                  <th>Nombre</th>
                  <th>Presidente</th>
                  <th>Mision</th>
                  <th>Vision</th>
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

class interfazAgrupacionForm extends interfazForm {

  public function printv() {

    // Generar titulo
    $titulo = $this->instancia != NULL ? "Modificar una agrupacion <br />" 
      : "Agregar una nueva agrupacion <br />";

    // Generar html para los mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} </br>";
    }

    // Determinar el objetivo de este formulario
    $cmd = $this->nuevo ? "insert" : "edit";
 
    // Precargar los campos si se pretende editar una instancia
    // Si 
    $campos = array();
    $universidadType = "text";
    $nombreType = "text";
    $universidad = "";
    $nombre = "";
    if ($this->instancia != NULL) {
      $campos["universidad"] = $this->instancia->getUniversidad();
      $campos["nombre"] = $this->instancia->getNombre();
      $campos["pres"] = $this->instancia->getPresidente();
      $campos["mision"] = $this->instancia->getMision();
      $campos["vision"] = $this->instancia->getVision();
            
      if (!$this->nuevo) {
	$universidad = $campos['universidad'];
	$universidadType = 'hidden';
        $nombre = $campos['nombre'];
	$nombreType = 'hidden';
      }
    }
    else{
      $campos["universidad"] = "";
      $campos["nombre"] = "";
      $campos["pres"] = "";
      $campos["mision"] = "";
      $campos["vision"] = "";
    }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Agrupaciones</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>

              <form action='index.php?class=agrupacion&cmd={$cmd}' method='post'>
                <table>
                  <tr>
                    <td>Universidad:</td>
                    <td>{$universidad} <input type='{$universidadType}' name='universidad' value='{$campos["universidad"]}' maxlength='25' /></td>
                  <td>Nombre:</td>
                    <td>{$nombre} <input type='{$nombreType}' name='nombre' value='{$campos["nombre"]}' maxlength='40' /></td>
                  </tr>
                  <tr>
                    <td>Presidente:</td>
                    <td><input type='text' name='pres' value='{$campos["pres"]}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>Mision:</td>
                    <td><input type='text' name='mision' value='{$campos["mision"]}' maxlength='100' /> </td>
                  </tr>
                  <tr>
                    <td>Vision:</td>
                    <td><input type='text' name='vision' value='{$campos['vision']}' maxlength='100'  /> </td>
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