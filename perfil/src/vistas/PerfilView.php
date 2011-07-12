<?php
class PerfilView {
  private static $instance; // Representa la unica instancia de esta clase

  function makeDateInput($id,$label, $day, $month, $year,$colspan = 2){
    $dias = range (1, 31);
    $meses = array (1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    for ($i = 2000; $i >= 1900; $i--) {
      $anios[] = $i;
    }
    $html = "<td colspan=\"{$colspan}\"><table><tbody><tr>
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

  private function makeTextArea($id,$label,$value = "",$habilitado = True,$colspan = 1){
    if (!$habilitado){
      $habi = " disabled=\"disabled\"";
    } else {
      $habi = "";
    }
    $html = "  <th colspan=\"{$colspan}\">
                 <label for=\"{$id}\">{$label}:</label>
               </th>
               <td colspan=\"{$colspan}\">
                 <textarea id=\"{$id}\" name=\"{$id}\" type=\"text\" class=\"field\"".$habi.">".$value."</textarea>
               </td>";
    return $html;
  }

  private function makeTextBox($id,$label,$errorBox,$value = False,$habilitado = True,$colspan = 1) {
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
    $html = "  <th colspan=\"{$colspan}\">
                 <label for=\"{$id}\">{$label}:</label>
               </th>
               <td colspan=\"{$colspan}\">
                 <input id=\"{$id}\" name=\"{$id}\" type=\"text\" class=\"field\"".$habi.$val."/>
               </td>";
    if ($errorBox) {
      $html .= "</tr>
                <tr>
                  <td colspan=\"".(2*$colspan)."\">
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

  private function makeRadioButtonsSet($id,$label,$labels,$vals,$selected){
    $html = "";
    $html .= "<th><label for=\"{$id}\">{$label}:</label></th>";
    $html .= "<td>";
    $html .= "<table><tbody>";
    foreach ($vals as $k => $val) {
      $html .= "<tr>";
      $html .= "<td><label for=\"{$id}{$val}\">{$labels[$k]}</label></td>";
      $html .= "<td><input type=\"radio\" name=\"{$id}\" value=\"{$vals[$k]}\"".(strcmp($selected,$val) == 0 ? " checked" : "")."/></td>";
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

  private function editPhoto($perfil){
    if (is_null($perfil["foto"])) {
      $image = "<img src=\"images/";
      if (strcmp($perfil["sexo"],"M") == 0) {
        $image .= "maleShape.gif";
      } else if (strcmp($perfil["sexo"],"F") == 0) {
        $image .= "femaleShape.png";
      }
      $image .= "\" alt=\"Foto de Perfil\" style=\"width: 100px; height: 100px;\"/>";
    }

    $html = "<fieldset><legend><h3>&nbsp;Foto de Perfil&nbsp;<input type=\"submit\" id=\"colapsePhoto\" class=\"flip\" value=\"Ocultar\"/>&nbsp;</h3></legend><a id=\"PhotoAnc\" name=\"PhotoAnc\"/>
                <div id=\"Photo\">
                  <table style=\"width: auto;\" border=\"0\" cellpadding=\"10\">
                    <tbody>";
    $html .= "<tr>";
    // FOTO
    $html .= "<td>";
    $html .= $image;
    //$html .="Foto = ".(is_null($perfil["foto"]) ? "NULL" : $perfil["foto"])."";
    $html .="</td>";
    // WIDGET PARA LA CARGA DE ARCHIVO
    $html .= "<td>";
    $html .= "<h4>Elija un archivo local como su nueva foto de perfil:</h4><br/>";
    $html .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000000000000000\">
              <input name=\"foto\" type=\"file\" id=\"foto\">";
    $html .="</td>";

    $html .= "</tr>";
    $html .= "      </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editBasicData($perfil){
    $tipoOpts = array("Estudiante",
                      "Profesor");
    $sexVals = array("M",
                     "F");
    $sexLabels = array("Masculino",
                       "Femenino");
    $dia = substr($perfil["fechaNac"],8,2);
    $mes = substr($perfil["fechaNac"],5,2);
    $anio = substr($perfil["fechaNac"],0,4);

    $html =  "<fieldset><legend><h3>&nbsp;Datos Básicos&nbsp;<button id=\"colapseBasic\" class=\"flip\" onclick=\"alternar(\"Basic\",1);return false;\">Ocultar</button>&nbsp;</h3></legend><a id=\"BasicAnc\" name=\"BasicAnc\"/>
                <div id=\"Basic\">
                  <table style=\"width: auto;\" border=\"0\" >
                    <tbody>";
    $html .= "<tr><td colspan=\"4\"><table><tbody><tr>".$this->makeTextBox("usrname","Nombre de Usuario",False,$perfil["usrname"],False)."</tr></tbody></table></td></tr>";
    $html .= "<tr id=\"ajaxUsr\"></tr>";
    $html .= "<tr>".$this->makeTextBox("nombre","Nombre",False,$perfil["nombre"]);
    $html .= $this->makeTextBox("apellido","Apellido",False,$perfil["apellido"])."</tr>";
    $html .= "<tr>".$this->makePasswdBox("passwd","Contraseña",False,$perfil["passwd"]);
    $html .= $this->makePasswdBox("passwd2","Confirme la contraseña",False,$perfil["passwd"])."</tr>";
    $html .= "<tr id=\"ajaxPasswd2\"><td></td></tr>";
    $html .= "<tr>".$this->makeDateInput("fechaNac","Fecha de Nacimiento",$dia,$mes,$anio,4)."</tr>";
    $html .= "<tr>".$this->makeRadioButtonsSet("sexo","Sexo",$sexLabels,$sexVals,$perfil["sexo"]);
    $html .= $this->makeDropDownList("tipo","Eres",$tipoOpts,$perfil["tipo"])."</tr>";
    $html .= "<tr id=\"ajaxSexo\"><td colspan=\"4\"></td></tr>
                    </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editContactData($perfil){
    $html = "<fieldset><legend><h3>&nbsp;Información de Contacto&nbsp;<button id=\"colapseContact\" class=\"flip\" onclick=\"alternar(\"Contact\",2);return false;\">Ocultar</button>&nbsp;</h3></legend><a id=\"ContactAnc\" name=\"ContactAnc\"/>
                <div id=\"Contact\">
                  <table style=\"width: auto;\" border=\"0\" >
                    <tbody>";
    $html .= "<tr>".$this->makeTextBox("email","E-Mail",False,$perfil["email"]);
    $html .= $this->makeTextBox("email2","Confirme el E-Mail",False,$perfil["email"])."</tr>";
    $html .= "<tr id=\"ajaxEmail2\"><td></td></tr>";
    $html .= "<tr>".$this->makeTextBox("emailAlt","E-Mail alternativo",False,$perfil["emailAlt"]);
    $html .= $this->makeTextBox("emailAlt2","Confirme el E-Mail",False,$perfil["emailAlt"])."</tr>";
    $html .= "<tr id=\"ajaxEmailAlt2\"><td></td></tr>";
    $html .= "<tr>".$this->makeTextBox("telefono","Teléfono",False,$perfil["telefono"]);
    $html .= $this->makeTextBox("tweeter","Tweeter",False,$perfil["tweeter"])."</tr>";
    $html .="<tr><td id=\"telefonoError\" colspan=\"2\"></td><td id=\"tweeterError\" colspan=\"2\"></td></tr>";
    $html .= "<tr>".$this->makeTextBox("ciudad","Ciudad de Origen",False,$perfil["ciudad"],True,2)."</tr>";
    $html .= "      </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editAcademicData($perfil){
    $html = "<fieldset><legend><h3>&nbsp;Información Académica&nbsp;<button id=\"colapseAcademic\" class=\"flip\" onclick=\"alternar(\"Academic\",3);return false;\">Ocultar</button>&nbsp;</h3></legend><a id=\"AcademicAnc\" name=\"AcademicAnc\"/>
                <div id=\"Academic\">
                  <table style=\"width: auto;\" border=\"0\">
                    <tbody>
                      <tr>
                        <td>";
    $html .= "<table><tbody>";
    $html .= "<tr>".$this->makeTextBox("carnet","Carnet",False,$perfil["carnet"])."</tr>";
    $html .= "<tr>".$this->makeTextBox("carrera","Carrera",False,$perfil["carrera"])."</tr>";
    $html .= "<tr>".$this->makeTextBox("colegio","Colegio",False,$perfil["colegio"])."</tr>";
    $html .= "</tbody></table></td>";
    $html .= "<td id=\"carnetError\"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editMiscData($perfil){
    $html = "<fieldset><legend><h3>&nbsp;Información Miscelánea&nbsp;<button id=\"colapseMisc\" class=\"flip\" onclick=\"alternar(\"Misc\",4);return false;\">Ocultar</button>&nbsp;</h3></legend><a id=\"MiscAnc\" name=\"MiscAnc\"/>
                <div id=\"Misc\">
                  <table style=\"width: auto;\" border=\"0\" >
                    <tbody>";
    $html .= "<tr>".$this->makeTextArea("actividadesExtra","Otras Actividades",$perfil["actividadesExtra"])."</tr>";
    $html .= "<tr>".$this->makeTextBox("trabajo","Trabajo",False,$perfil["trabajo"])."</tr>";
    $html .= "<tr>".$this->makeTextArea("bio","Bio",$perfil["bio"])."</tr>";
    $html .= "      </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editSecurityData($perfil){
    $html = "<fieldset><legend><h3>&nbsp;Información de Seguridad y Privacidad&nbsp;<button id=\"colapseSecurity\" class=\"flip\" onclick=\"alternar(\"Security\",5);return false;\">Ocultar</button>&nbsp;</h3></legend><a id=\"SecurityAnc\" name=\"SecurityAnc\"/>
                <div id=\"Security\">
                  <table style=\"width: auto;\" border=\"0\" >
                    <tbody>";
    $html .= "<tr><td><h4>AQUI PUEDEN PONER LO RELACIONADO CON LA SEGURIDAD AQUEL QUE SE ENCARGUE DE ELLO</h4></td></tr>";
    $html .= "      </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  public function viewEditPerfil($perfil,$status) {
    if (strcmp($status,"request") == 0) {
      $html = "";
      $html .= "<form name=\"registro\" action=\"editarPerfil.php?Action=edit&mode=submit\" method=\"POST\" enctype=\"multipart/form-data\">";
      $html .= "<table border=\"0\" style=\"width: auto;\">";
      $html .= "<tbody>";
      $html .= "<tr><td>";
      $html .= $this->editPhoto($perfil);
      $html .= "</td></tr>";
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
      $html .= "<input id=\"resetBtn\" type=\"reset\" value=\"Reestablecer Valores\"/>";
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