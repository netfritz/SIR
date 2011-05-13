<?php

class interfazProfesorAll extends interfazAll {

    public function printv() {
        // Generar el html que representa los mensajes
        $bloqueMsj = "";
        foreach ($this->mensajes as $msj) {
            $bloqueMsj .= "$msj </br>";
        }

        if ($this->instancias != null) {
            // Generar html para la tabla de instancias
            $tabla = "";
            foreach ($this->instancias as $ind) {
                $id = $ind->getDocumento_id();
                $dpto = $ind->getDpto();
                $tabla .= "
                  <tr>
                  <td>" . $id . "</td>
                  <td>" . $dpto . "</td>
                  <td>" . $ind->getCarnet() . "</td>
                  <td>" . $ind->getNombre() . "</td>
                  <td>" . $ind->getApellido() . "</td>
                  <td>" . $ind->getTitulo() . "</td>
                  <td>
                  <form action=\"index.php?class=profesor&cmd=input\" method=\"post\">
                  <input type=\"hidden\" name=\"id\" value=\"" . $id . "\" />
                  <input type=\"hidden\" name=\"dep\" value=\"" . $dpto . "\" />
                  <input type=\"submit\" value=\"Editar\" />
                  </form>
                  </td>
                  <td>
                  <form action=\"index.php?class=profesor&cmd=delete\" method=\"post\">
                  <input type=\"hidden\" name=\"id\" value=\"" . $id . "\" />
                  <input type=\"hidden\" name=\"dep\" value=\"" . $dpto . "\" />
                  <input type=\"submit\" value=\"Eliminar\" />
                  </td>
                  </tr>";
            }
        }
// Unir todo dentro del template
        echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Profesores</a></h2>
            <!-- <p class='meta'>Blabla</p> -->
            <div class='entry'>
              <a href='index.php?class=profesor&cmd=input'>Insertar nuevo Profesor</a>
              </ br>
              <p>
              $bloqueMsj

              <table>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Direccion</th>
                  <th>Coordinador</th>
                </tr>

                $tabla

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

class interfazProfesorForm extends interfazForm {

    public function printv() {

        // Generar titulo
        $titulo = $this->instancia != NULL ? "Modificar un profesor <br />" :
                "Agregar un nuevo profesor <br />";

        // Generar html para los mensajes
        $bloqueMsj = "";
        foreach ($this->mensajes as $msj) {
            $bloqueMsj .= "$msj </br>";
        }

        // Determinar el objetivo de este formulario
        $cmd = $this->nuevo ? "insert" : "edit";

        // Precargar los campos si se pretende editar una instancia                
        $idType = "text";
        $depType = "text";
        $id = "";
        $dep = "";
        if ($this->instancia != NULL) {
            $campos["id"] = $this->instancia->getDocumento_id();
            $campos["dep"] = $this->instancia->getDpto();
            $campos["carnet"] = $this->instancia->getCarnet();
            $campos["nombre"] = $this->instancia->getNombre();
            $campos["apellido"] = $this->instancia->getApellido();
            $campos["titulo"] = $this->instancia->getTitulo();

            if (!$this->nuevo) {
                $id = $campos['id'];
                $dep = $campos['dep'];
                $depType = 'hidden';
                $idType = 'hidden';
            }
        } else {
            $campos["id"] = "";
            $campos["dep"] = "";
            $campos["carnet"] = "";
            $campos["nombre"] = "";
            $campos["apellido"] = "";
            $campos["titulo"] = "";
        }

        // Unir todo en el template
        echo "
      <div id='page'>
        <div id='content'>
          <div class='post'>
            <h2 class='title'><a href='#'>Profesores</a></h2>
            <div class='entry'>
              
              $bloqueMsj

              <h3> $titulo </h3>

              <form action='index.php?class=profesor&cmd=$cmd' method='post'>
                <table>
                  <tr>
                    <td>Documento de Identificación:</td>
                    <td>$id <input type='$codigoType' name='id' value='{$campos['id']}' maxlength='25' /></td>
                  </tr>
                  <tr>
                    <td>Departamento:</td>
                    <td>$dep<input type='$depType' name='dep' value='{$campos['dep']}' maxlength='45' /> </td>
                  </tr>
                  <tr>
                    <td>Carnet:</td>
                    <td><input type='text' name='carnet' value='{$campos['carnet']}' maxlength='100' /> </td>
                  </tr>
                  <tr>
                    <td>Nombre:</td>
                    <td><input type='text' name='nombre' value='{$campos['nombre']}' maxlength='100'  /> </td>
                  </tr>
                  <tr>
                    <td>Apellido:</td>
                    <td><input type='text' name='apellido' value='{$campos['apellido']}' maxlength='100'  /> </td>
                  </tr>
                  <tr>
                    <td>Titulo:</td>
                    <td><input type='text' name='titulo' value='{$campos['titulo']}' maxlength='100'  /> </td>
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
