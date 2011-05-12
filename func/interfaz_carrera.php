class interfazCarreraAll extends interfazAll {

  public print() {

    echo "</br>
          <a href=\"index.php?class=carrera&cmd=input\">Insertar nueva Carrera</a>
          </br>
          <ul>";

    foreach ($mensajes as $msj) {
      echo "{$msj} </br>";
    }

    foreach ($instancias as $inst) {
      echo '<li>Carrera: {$inst}. 
         <form action="index.php?class=carrera&cmd=input" method="post">
         <input type="hidden" name="codigo" value="' . $inst->getCodigo() . '" />
         <input type="submit" value="Editar" />
         </form>

         <form action="index.php?class=carrera&cmd=delete\" method=\"post\">
         <input type="hidden" name="codigo" value="' . $inst->getCodigo() . '" />
         <input type="submit" value="Borrar" />
         </form>
         
         </li>';
    }
    
    echo '</ul>';
  }
}

class interfazCarerraForm extends interfazForm {

  public print() {

    if ($this->instancia != NULL) {
      $campos["codigo"] = $instancia->getCodigo();
      $campos["nombre"] = $instancia->getNombre();
      $campos["direccion"] = $instancia->getDireccion();
      $campos["coordinador"] = $instancia->getCoordinador();
      $cmd = "edit";
    } else {
      $campos = array();
      $cmd = "insert";
    }

    foreach ($mensajes as $msj) {
      echo "{$msj} </br>";
    }
    
    echo '<form action="index.php?class=carrera&cmd=${cmd}" method="post">
          Codigo: {$codigo}. </br>
          Nombre: <input type="text" name="nombre" value="{$nombre}" /> </br>
          Direccion: <input type="text" name="direccion" value="{$direccion}" /> </br>
          Coordinador: <input type="text" name="coordinador" value="{$coordinador}" /> </br>
          <input type="submit" value="Enviar" />
          </form>';
}