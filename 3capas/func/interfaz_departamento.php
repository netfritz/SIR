<?php

require_once("interfaz.php");
require_once("class/model/Departamento.php");

class interfazDepartamentoAll extends interfazAll {
  
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

    // Unir todo dentro del template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Departamentos</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=departamento&cmd=input'>Insertar nuevo Departamento</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th>Universidad</th>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Direccion</th>
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

class interfazDepartamentoForm extends interfazForm {

  public function printv() {

    // Generar titulo
    $titulo = $this->instancia != NULL ? "Modificar un departamento <br />" 
      : "Agregar un nuevo departamento <br />";

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
    if ($this->instancia != NULL) {
      $campos["id"] = $this->instancia->getId();
      $campos["universidad"] = $this->instancia->getUniversidad();
      $campos["codigo"] = $this->instancia->getCodigo();
      $campos["nombre"] = $this->instancia->getNombre();
      $campos["direccion"] = $this->instancia->getDireccion();
     }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Departamentos</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>


              <form action='index.php?class=departamento&cmd={$cmd}' method='post'>
              <input type='hidden' name='id' value='{$campos['id']}' maxlength='25' />
                <table>
                  <tr>
                    <td>Universidad:</td>
                    <td><input type='text' name='universidad' value='{$campos['universidad']}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>Codigo:</td>
                    <td><input type='text' name='codigo' value='{$campos['codigo']}' maxlength='25' /></td>
                  </tr>
                  <tr>
                    <td>Nombre:</td>
                    <td><input type='text' name='nombre' value='{$campos['nombre']}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>Direccion:</td>
                    <td><input type='text' name='direccion' value='{$campos['direccion']}' maxlength='100' /> </td>
                  </tr>
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