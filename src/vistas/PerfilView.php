<?php
class PerfilView {
  private static $instance; // Representa la unica instancia de esta clase

  function makeDateInput($id,$label, $day, $month, $year){
    $dias = range (1, 31);
    $meses = array (1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    for ($i = 2000; $i >= 1900; $i--) {
      $anios[] = $i;
    }
    $html = "<td colspan=\"2\"><table><tbody><tr>
             <th>
               <label for=\"".$id."\">".$label.":</label>
             </th>
             <td><table><tbody><tr>";
    $html .= '<th><label for="'.$id.'_dia">Día:</label></th>';
    $html .= '<td><select id="'.$id.'_dia" name="'.$id.'_dia">';
    foreach ($dias as $val) {
      if ($val == $day) {
        $html .= '<option selected value="'.$val.'">'.$val.'</option>\n';
      } else {
        $html .= '<option value="'.$val.'">'.$val.'</option>\n';
      }
    }
    $html .= '</select></td>';
    $html .= '<th><label for="'.$id.'_mes">Mes:</label></th>';
    $html .= '<td><select id="'.$id.'_mes" name="'.$id.'_mes">';
    foreach ($meses as $k => $val) {
      if ($val == $month) {
        $html .= '<option selected value="'.$k.'">'.$val.'</option>\n';
      } else {
        $html .= '<option value="'.$k.'">'.$val.'</option>\n';
      }
    }
    $html .= '</select></td>';
    $html .= '<th><label for="'.$id.'_anio">Año:</label></th>';
    $html .= '<td><select id="'.$id.'_anio" name="'.$id.'_anio">';
    foreach ($anios as $val) {
      if ($val == $year) {
        $html .= '<option selected value="'.$val.'">'.$val.'</option>\n';
      } else {
        $html .= '<option value="'.$val.'">'.$val.'</option>\n';
      }
    }
    $html .= '</select></td>';
    $html .= "</tr></tbody></table>
             </td>
             </tr></tbody></table></td>";
    return $html;
  }

  private function makeTextBox($id,$label,$errorBox,$value = False,$habilitado = True) {
    if ($value != False) {
      $val = " value=\"".$value."\"";
    } else {
      $val = "";
    }
    if (!$habilitado){
      $habi = " disabled=\"disabled\"";
    } else {
      $habi = "";
    }
    $html = "  <th>
                 <label for=\"{$id}\">{$label}:</label>
               </th>
               <td>
                 <input id=\"{$id}\" name=\"{$id}\" type=\"text\" class=\"field\"".$habi.$val."/>
               </td>";
    if ($errorBox) {
      $html .= "</tr>
                <tr>
                  <td colspan=\"2\">
                    <label for=\"{$id}\" class=\"error\"></label>
                  </td>";
    }
    return $html;
  }

  private function makePasswdBox($id,$label,$errorBox,$value = False) {
    if ($value != False) {
      $val = "value=\"".$value."\"";
    }
    $html = " <th>
                <label for=\"{$id}\">{$label}:</label>
              </th>
              <td>
                <input id=\"{$id}\" name=\"{$id}\" type=\"password\" class=\"field\" ".$val."/>
              </td>";
    if ($errorBox) {
      $html .= "</tr>
                <tr>
                 <td>
                   <label for=\"{$id}\" class=\"error\"></label>
                 </td>";
    }

    return $html;
  }

  private function makeDropDownList($id, $label, $opts, $selected = NULL) {
    $options = "";
    $options .= "<th><label for=\"{$id}\">{$label}:</label></th>";
    $options .= "<td><select id=\"{$id}\" name=\"{$id}\" class=\"field\">";
    foreach ($opts as $opt) {
      $options .= "<option value=\"{$opt}\"";
      if (!is_null($selected) && strcmp($selected, $opt) == 0) {
        $options .= "selected=\"selected\">{$opt}</option>";
      } else {
        $options .= ">{$opt}</option>";
      }
    }
    $options .= "</select></td>";
    return $options;
  }

  private function makeSubmitButton($id,$value) {
    return "<td colspan=\"2\"><input id=\"{$id}\" type=\"submit\" value=\"{$value}\"/></td>";
  }

  private function makeRadioButtonsSet($id,$label,$labels,$vals){
    $html = "";
    $html .= "<th><label for=\"{$id}\">{$label}:</label></th>";
    $html .= "<td>";
    $html .= "<table><tbody>";
    foreach ($vals as $k => $val) {
      $html .= "<tr>";
      $html .= "<td><label for=\"{$id}{$val}\">{$labels[$k]}</label></td>";
      $html .= "<td><input type=\"radio\" name=\"{$id}\" value=\"{$vals[$k]}\" /></td>";
      $html .= "</tr>";
    }
    $html .= "</tbody></table>";
    $html .= "</td>";
    return $html;
  }

  public function viewRegisterEmpty(){
    $tipoOpts = array("Estudiante",
                      "Profesor");
    $sexVals = array("M",
                     "F");
    $sexLabels = array("Masculino",
                       "Femenino");
    $html =  "<form id=\"regForm\" name=\"registro\" action=\"/?Action=create\" method=\"POST\">
                <fieldset><legend><h2>Registro:&nbsp;&nbsp;</h2></legend>
                  <table style=\"width: auto;\">
                    <tbody>";
    $html .= "<tr>".$this->makeTextBox("usrname","Nombre de Usuario",true)."</tr>";
    $html .= "<tr id=\"ajaxUsr\"></tr>";
    $html .= "<tr>".$this->makeTextBox("nombre","Nombre",true)."</tr>";
    $html .= "<tr>".$this->makeTextBox("apellido","Apellido",true)."</tr>";
    $html .= "<tr>".$this->makeTextBox("email","E-mail",true)."</tr>";
    $html .= "<tr id=\"ajaxEmail\"></tr>";
    $html .= "<tr>".$this->makeTextBox("email2","Confirme su E-mail",true)."</tr>";
    $html .= "<tr id=\"ajaxEmail2\"></tr>";
    $html .= "<tr>".$this->makePasswdBox("passwd","Contraseña",true)."</tr>";
    $html .= "<tr id=\"ajaxPasswd\"></tr>";
    $html .= "<tr>".$this->makePasswdBox("passwd2","Confirme su contraseña",true)."</tr>";
    $html .= "<tr id=\"ajaxPasswd2\"></tr>";
    $html .= "<tr>".$this->makeDateInput("fechaNac","Fecha de Nacimiento","1","1","2000")."</tr>";
    $html .= "<tr>".$this->makeRadioButtonsSet("sexo","Sexo",$sexLabels,$sexVals)."</tr>";
    $html .= "<tr>".$this->makeDropDownList("tipo","Eres",$tipoOpts,"Estudiante")."</tr>";
    $html .= "<tr>".$this->makeSubmitButton("submitBtn","Enviar!")."</tr>";
    $html .= "     </tbody>
                 </table>
               </fieldset>
             </form>";
    return $html;
  }

  private function editBasicData(){
    $tipoOpts = array("Estudiante",
                      "Profesor");
    $sexVals = array("M",
                     "F");
    $sexLabels = array("Masculino",
                       "Femenino");
    $html =  "<fieldset><legend><h2>Datos Básicos&nbsp;&nbsp;</h2></legend>
                <table style=\"width: auto;\">
                  <tbody>";
    $html .= "<tr><td colspan=\"4\"><table><tbody><tr>".$this->makeTextBox("usrname","Nombre de Usuario",False,"VALOR",False)."</tr></tbody></table></td></tr>";
    $html .= "<tr id=\"ajaxUsr\"></tr>";
    $html .= "<tr>".$this->makeTextBox("nombre","Nombre",False,"VALOR");
    $html .= $this->makeTextBox("apellido","Apellido",False,"VALOR")."</tr>";
    /*
    $html .= $this->makePasswdBox("passwd","Contraseña");
    $html .= "<tr id=\"ajaxPasswd\"></tr>";
    $html .= $this->makePasswdBox("passwd2","Confirme su contraseña");
    $html .= "<tr id=\"ajaxPasswd2\"></tr>";
    $html .= $this->makeDateInput("fechaNac","Fecha de Nacimiento","1","1","2000");
    $html .= $this->makeRadioButtonsSet("sexo","Sexo",$sexLabels,$sexVals);
    $html .= $this->makeDropDownList("tipo","Eres",$tipoOpts,"Estudiante");*/
    $html .= "    </tbody>
                </table>
              </fieldset>";
    return $html;
  }

  private function editContactData($perfil){
    
  }

  private function editAcademicData($perfil){
  
  }

  private function editMiscData($perfil){

  }
  
  private function editSecurityData($perfil){

  }

  public function viewEditPerfil($perfil,$status) {
    if (strcmp($status,"request") == 0) {
      $html = "";
      $html .= "<form name=\"registro\" action=\"editarPerfil.php?Action=edit&mode=submit\" method=\"POST\">";
      $html .= "<table BORDER=\"1\" style=\"width: auto;\">";
      $html .= "<tbody>";
      $html .= "<tr><td>";
      $html .= $this->editBasicData($perfil);
      $html .= "</td></tr>";
      $html .= "<tr><td>";
      $html .= $this->editContactData($perfil);
      $html .= "</td></tr>";
      $html .= "<tr><td>";
      $html .= $this->editAcademicData($perfil);
      $html .= "</td></tr>";
      $html .= "<tr><td>";
      $html .= $this->editMiscData($perfil);
      $html .= "</td></tr>";
      $html .= "<tr><td>";
      $html .= $this->editSecurityData($perfil);
      $html .= "</td></tr>";
      $html .= "<tr><td>";
      $html .= "<input id=\"submitBtn\" type=\"submit\" value=\"Guardar Cambios\"/>";
      $html .= "</td></tr>";
      $html .= "</tbody>";
      $html .= "</table>";
      $html .= "</form>";
      return $html;
    } else if (strcmp($status,"success") == 0) {
      $msg = "<div id=\"successMsg\"><table style=\"border: 1;\"><h2>Cambios guardados satisfactoriamente</h2></table></div><br/><br/><a href=\"/\">Volver al inicio</a>";
    }
    return $msg;
  }

  public function viewCreatePerfil() {
    return "<h2>Perfil creado exitosamente!</h2>";
  }

  public function viewError($msg) {
    return "<div id=\"errorBox\"class=\"error\"><p>{$msg}</p></div>";
  }

  public function viewErrors($msgArr) {
    $out = "";
    foreach ($msgArr as $error) {
      $out .= "<li>{$error}<\li>";
    }
    return "<div id=\"errorBox\"class=\"error\"><ul>{$out}</ul></div>";
  }

  //#####################################################################//
  //                        Inicio del Singleton                         //
  //#####################################################################//

  /**
   * Para evitar que instancien esta clase, se crea un constructor privado
   * (Tomado del manual de php:
   *             http://php.net/manual/en/language.oop5.patterns.php)
   */
  private function __construct() {

  }

  /**
   * Evita que los usuarios clonen el objeto
   * (Tomado del manual de php:
   *             http://php.net/manual/en/language.oop5.patterns.php)
   */
  public function __clone(){
    trigger_error('No se permite la clonación de este objeto.', E_USER_ERROR);
  }

  /**
   * Método que garantiza que sólo habrá una instancia de esta clase, con los
   * dos métodos anteriores junto con este, se crea un "Singleton Pattern"
   * con lo cual emulamos lo que sería una clase estática (lo que en java
   * hacemos con "public static class blah {}").
   * (Tomado del manual de php:
   *             http://php.net/manual/en/language.oop5.patterns.php)
   */
  public static function singleton() {
    if (!isset(self::$instance)) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }
}
?>