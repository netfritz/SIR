<?php

require_once("interfaz.php");
require_once("class/model/Carrera.php");

class interfazCarreraAll extends interfazAll {
  
  public function printv() {

    // Generar bloque que representa los mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} </br>";
    }
    
    // Generar html para la tabla de instancias
    $tabla = "";
    foreach ($this->instancias as $inst) {
      $tabla .= "
         <tr>
           <td>{$inst->getCodigo()}</td>
           <td>{$inst->getNombre()}</td>
           <td>{$inst->getDireccion()}</td>
           <td>{$inst->getCoordinador()}</td>
           <td> 
             <form action='index.php?class=carrera&cmd=input' method='post'>
               <input type='hidden' name='codigo' value='{$inst->getCodigo()}' />
               <input type='submit' value='Editar' />
             </form>
           </td>
           <td>
             <form action='index.php?class=carrera&cmd=delete' method='post'>
               <input type='hidden' name='codigo' value='{$inst->getCodigo()}' />
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
            <h2 class='title'><a href='#'>Carreras</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=carrera&cmd=input'>Insertar nueva Carrera</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Direccion</th>
                  <th>Coordinador</th>
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

class interfazCarreraForm extends interfazForm {

  public function printv() {

    // Generar bloque de mensajes
    $bloqueMsj = "";
    foreach ($this->mensajes as $msj) {
      $bloqueMsj .= "{$msj} </br>";
    }

    // Determinar a qué página se dirige este formulario
    $cmd = $this->nuevo ? "insert" : "edit";

 
    // Precargar los campos si se pretende editar una instancia
    $campos = array();
    if ($this->instancia != NULL) {
      $campos["codigo"] = $this->instancia->getCodigo();
      $campos["nombre"] = $this->instancia->getNombre();
      $campos["direccion"] = $this->instancia->getDireccion();
      $campos["coordinador"] = $this->instancia->getCoordinador();
      $codigo = "<tr><td>Codigo:</td><td>";
      
      if (!$this->nuevo)
	$codigo .= "{$campos['codigo']} <input type='hidden' name='codigo' value='{$this->instancia->getCodigo()}' maxlength='25'>";
      else
	$codigo .= "<input type='text' name='codigo' value='{$this->instancia->getCodigo()}' maxlength='25'>";
      
      $codigo .= "</td></tr>";
      
      $titulo = "Modificar una carrera <br />";

    } else {
      // Si es una nueva instancia entonces generar el campo en el formulario
      $codigo = "
        <tr>
          <td>Codigo:</td>
          <td><input type='text' name='codigo' maxlength='25' /></td>
        </tr>";
      $titulo = "Agregar una nueva carrera <br />";
    }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Carreras</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>

              <form action='index.php?class=carrera&cmd={$cmd}' method='post'>
                <table>
                  {$codigo}
                  <tr>
                    <td>Nombre:</td>
                    <td><input type='text' name='nombre' value='{$campos['nombre']}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>Direccion:</td>
                    <td><input type='text' name='direccion' value='{$campos['direccion']}' maxlength='100' /> </td>
                  </tr>
                  <tr>
                    <td>Coordinador:</td>
                    <td><input type='text' name='coordinador' value='{$campos['coordinador']}' maxlength='100'  /> </td>
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