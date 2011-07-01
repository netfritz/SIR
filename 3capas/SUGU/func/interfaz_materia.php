<?php

require_once("interfaz.php");
require_once("class/model/Materia.php");

class interfazMateriaAll extends interfazAll {
  
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
      <td>{$inst->getdpto()}</td>
      <td>{$inst->getcodigo()}</td>
      <td>{$inst->getnombre()}</td>
      <td>
         <form action=\"index.php?class=materia&cmd=input\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $inst->getid() . "\" />
         <input type=\"submit\" value=\"Editar\" />         
         </form>
      </td>
      <td>
         <form action=\"index.php?class=materia&cmd=delete\" method=\"post\">
         <input type=\"hidden\" name=\"id\" value=\"" . $inst->getid() . "\" />
         <input type=\"submit\" value=\"Borrar\" />        
          </form>
    </td>     
         </tr>";
         
    }

    // Unir todo dentro del template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Materias</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=materia&cmd=input'>Insertar nueva Materia</a>
              </ br>
              <p>
              {$bloqueMsj}

              <table>
                <tr>
                  <th>Departamento</th>
                  <th>Codigo</th>
                  <th>Nombre</th>
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

class interfazMateriaForm extends interfazForm {

  public function printv() {

    // Generar titulo
    $titulo = $this->instancia != NULL ? "Modificar una materia <br />" 
      : "Agregar una nueva materia <br />";

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
      $campos["id"] = $this->instancia->getid();
      $campos["dpto"] = $this->instancia->getdpto();
      $campos["codigo"] = $this->instancia->getcodigo();
      $campos["nombre"] = $this->instancia->getnombre();
            
    }
    
    // Unir todo en el template
    echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Materias</a></h2>
            <div class='entry'>
              
              {$bloqueMsj}

              <h3> {$titulo} </h3>

              <form action='index.php?class=materia&cmd={$cmd}' method='post'>
                <table>
                  <tr>
                    <td><input type='hidden' name='id' value='{$campos['id']}' maxlength='25' /></td>
                  </tr>
                  <tr>
                    <td>Departamento:</td>
                    <td><input type='text' name='dpto' value='{$campos['dpto']}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>Codigo:</td>
                    <td><input type='text' name='codigo' value='{$campos['codigo']}' maxlength='100' /> </td>
                  </tr>
                  <tr>
                    <td>Nombre:</td>
                    <td><input type='text' name='nombre' value='{$campos['nombre']}' maxlength='100'  /> </td>
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