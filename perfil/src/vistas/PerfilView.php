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
      if ($val == (int)$day) {
        $html .= '<option selected value="'.$val.'">'.$val.'</option>\n';
      } else {
        $html .= '<option value="'.$val.'">'.$val.'</option>\n';
      }
    }
    $html .= '</select></td>';
    $html .= '<th><label for="'.$id.'_mes">Mes:</label></th>';
    $html .= '<td><select id="'.$id.'_mes" name="'.$id.'_mes">';
    foreach ($meses as $k => $val) {
      if ($k == (int)$month) {
        $html .= '<option selected value="'.$k.'">'.$val.'</option>\n';
      } else {
        $html .= '<option value="'.$k.'">'.$val.'</option>\n';
      }
    }
    $html .= '</select></td>';
    $html .= '<th><label for="'.$id.'_anio">Año:</label></th>';
    $html .= '<td><select id="'.$id.'_anio" name="'.$id.'_anio">';
    foreach ($anios as $val) {
      if ($val == (int)$year) {
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
    $val = ($value != False ? "value=\"".$value."\"" : "");
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
    return "<td colspan=\"2\"><input class=\"submitButton\" id=\"{$id}\" type=\"submit\" value=\"{$value}\"/></td>";
  }

  private function makeRadioButtonsSet($id,$label,$labels,$vals,$selected = ""){
    $html = "";
    $html .= "<th><label for=\"{$id}\">{$label}:</label></th>";
    $html .= "<td>";
    $html .= "<table><tbody>";
    foreach ($vals as $k => $val) {
      $html .= "<tr>";
      $html .= "<td><label for=\"{$id}{$val}\">{$labels[$k]}</label></td>";
      $html .= "<td><input class=\"radio{$id}\" type=\"radio\" name=\"{$id}\" value=\"{$vals[$k]}\"".(strcmp($selected,$val) == 0 ? " checked" : "")."/></td>";
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
    $html =  "<form id=\"regForm\" name=\"registro\" action=\"/rspinf-usb/perfil/registro.php?Action=create\" method=\"POST\">
                <fieldset><legend><h2>Registro:&nbsp;&nbsp;</h2></legend>
                  <table style=\"width: auto;\">
                    <tbody>";
    $html .= "<tr>".$this->makeTextBox("usrname","Nombre de Usuario&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr id=\"ajaxUsr\"></tr>";
    $html .= "<tr>".$this->makeTextBox("nombre","Nombre&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr>".$this->makeTextBox("apellido","Apellido&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr>".$this->makeTextBox("email","E-mail&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr id=\"ajaxEmail\"></tr>";
    $html .= "<tr>".$this->makeTextBox("email2","Confirme su E-mail&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr id=\"ajaxEmail2\"></tr>";
    $html .= "<tr>".$this->makePasswdBox("passwd","Contraseña&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr id=\"ajaxPasswd\"></tr>";
    $html .= "<tr>".$this->makePasswdBox("passwd2","Confirme su contraseña&nbsp;&nbsp;*",true)."</tr>";
    $html .= "<tr id=\"ajaxPasswd2\"></tr>";
    $html .= "<tr>".$this->makeDateInput("fechaNac","Fecha de Nacimiento&nbsp;&nbsp;*","1","1","2000")."</tr>";
    $html .= "<tr>".$this->makeRadioButtonsSet("sexo","Sexo&nbsp;&nbsp;*",$sexLabels,$sexVals)."</tr>";
    $html .= "<tr>".$this->makeDropDownList("tipo","Eres&nbsp;&nbsp;*",$tipoOpts,"Estudiante")."</tr>";
    $html .= "<tr>".$this->makeSubmitButton("submitBtn","Enviar!")."</tr>";
    $html .= "       <p>* campos obligatorios</p>
                   </tbody>
                 </table>
               </fieldset>
             </form><br/><br/><br/><br/>";
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

    $html = "<fieldset><legend><h3>&nbsp;<button type=\"button\" id=\"colapsePhoto\" class=\"FotoFlip\"/>Ocultar</button>&nbsp;Foto de Perfil&nbsp;</h3></legend><a id=\"PhotoAnc\" name=\"PhotoAnc\"/>
                <div id=\"Photo\">";
    $html .= "<div id=\"image\">";
    // FOTO
    $html .= $image;
    $html .= "</div>";


    // WIDGET PARA LA CARGA DE ARCHIVO
    $html .= "<div id=\"uploadWidget\">";
    $html .= "<h4>Elija un archivo local como su nueva foto de perfil:</h4><br/>";
    $html .= "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"2000000\">
              <input name=\"foto\" type=\"file\" id=\"foto\">";
    $html .="</div>";
    $html .= "</div>
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
    $dia = (int)substr($perfil["fechaNac"],8,2);
    $mes = (int)substr($perfil["fechaNac"],5,2);
    $anio = (int)substr($perfil["fechaNac"],0,4);

    $html =  "<fieldset><legend><h3>&nbsp;<button type=\"button\" id=\"colapseBasic\" class=\"BasicFlip\">Ocultar</button>&nbsp;Datos Básicos&nbsp;</h3></legend><a id=\"BasicAnc\" name=\"BasicAnc\"/>
                <div id=\"Basic\">
                  <table style=\"width: auto;\" border=\"0\" >
                    <tbody>";
    $html .= "<tr><td colspan=\"4\"><table><tbody><tr>".$this->makeTextBox("usrname","Nombre de Usuario",False,$perfil["usrname"],False)."</tr></tbody></table></td></tr>";
    $html .= "<tr id=\"ajaxUsr\" class=\"error\"></tr>";
    $html .= "<tr>".$this->makeTextBox("nombre","Nombre",False,$perfil["nombre"]);
    $html .= $this->makeTextBox("apellido","Apellido",False,$perfil["apellido"])."</tr>";
    $html .= "<tr>".$this->makePasswdBox("passwd","Contraseña",False,$perfil["passwd"]);
    $html .= $this->makePasswdBox("passwd2","Confirme la contraseña",False,$perfil["passwd"])."</tr>";
    $html .= "<tr id=\"ajaxPasswd\" class=\"error\"><td></td></tr>";
    $html .= "<tr>".$this->makeDateInput("fechaNac","Fecha de Nacimiento",$dia,$mes,$anio,4)."</tr>";
    $html .= "<tr>".$this->makeRadioButtonsSet("sexo","Sexo",$sexLabels,$sexVals,$perfil["sexo"]);
    $html .= $this->makeDropDownList("tipo","Eres",$tipoOpts,$perfil["tipo"])."</tr>";
    $html .= "<tr id=\"ajaxSexo\" class=\"error\"><td colspan=\"4\"></td></tr>
                    </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editContactData($perfil){
    $html = "<fieldset><legend><h3>&nbsp;<button id=\"colapseContact\" class=\"ContactFlip\">Ocultar</button>&nbsp;Información de Contacto&nbsp;</h3></legend><a id=\"ContactAnc\" name=\"ContactAnc\"/>
                <div id=\"Contact\">
                  <table style=\"width: auto;\" border=\"1\" >
                    <tbody>";
    $html .= "<tr>".$this->makeTextBox("email","E-Mail",False,$perfil["email"]);
    $html .= $this->makeTextBox("email2","Confirme el E-Mail",False,$perfil["email"])."</tr>";
    $html .= "<tr id=\"ajaxEmailRow\"><td colspan=\"2\" id=\"ajaxEmail\" class=\"error\"></td><td colspan=\"2\" id=\"ajaxEmail2\" class=\"error\"></td></tr>";
    $html .= "<tr>".$this->makeTextBox("emailAlt","E-Mail alternativo",False,$perfil["emailAlt"]);
    $html .= $this->makeTextBox("emailAlt2","Confirme el E-Mail",False,$perfil["emailAlt"])."</tr>";
    $html .= "<tr id=\"ajaxEmailAltRow\"><td colspan=\"2\" id=\"ajaxEmailAlt\" class=\"error\"></td><td colspan=\"2\" id=\"ajaxEmailAlt2\" class=\"error\"></td></tr>";
    $html .= "<tr>".$this->makeTextBox("telefono","Teléfono",False,$perfil["telefono"]);
    $html .= $this->makeTextBox("tweeter","Tweeter",False,$perfil["tweeter"])."</tr>";
    $html .="<tr><td id=\"telefonoError\" class=\"error\" colspan=\"2\"></td><td id=\"tweeterError\" class=\"error\" colspan=\"2\"></td></tr>";
    $html .= "<tr>".$this->makeTextBox("ciudad","Ciudad de Origen",False,$perfil["ciudad"],True,2)."</tr>";
    $html .= "      </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  private function editAcademicData($perfil){
    $html = "<fieldset><legend><h3>&nbsp;<button id=\"colapseAcademic\" class=\"AcadFlip\">Ocultar</button>&nbsp;Información Académica&nbsp;</h3></legend><a id=\"AcademicAnc\" name=\"AcademicAnc\"/>
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
    $html = "<fieldset><legend><h3>&nbsp;<button id=\"colapseMisc\" class=\"MiscFlip\">Ocultar</button>&nbsp;Información Miscelánea&nbsp;</h3></legend><a id=\"MiscAnc\" name=\"MiscAnc\"/>
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
    $html = "<fieldset><legend><h3>&nbsp;<button id=\"colapseSecurity\" class=\"SecurityFlip\">Ocultar</button>&nbsp;Información de Seguridad y Privacidad&nbsp;</h3></legend><a id=\"SecurityAnc\" name=\"SecurityAnc\"/>
                <div id=\"Security\">
                  <table style=\"width: auto;\" border=\"0\" >
                    <tbody>";
    $html .= "<tr><td><h4><a href=\"/rspinf-usb/Seguridad/privDatos.php\">Editar Seguridad</h4></td></tr>";
    $html .= "      </tbody>
                  </table>
                </div>
              </fieldset>";
    return $html;
  }

  public function viewEditPerfil($perfil,$status) {
    if (strcmp($status,"request") == 0) {
      $html = "<br/><br/><br/>";
      $html .= "<form name=\"registro\" action=\"editarPerfil.php?Action=edit&mode=submit\" method=\"POST\" enctype=\"multipart/form-data\">";
      $html .= "<button type=\"button\" id=\"showAll\" class=\"showAllFlip\">Mostrar Todos</button>&nbsp;<button type=\"button\" id=\"hideAll\" class=\"hideAllFlip\">Ocultar Todos</button>";
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
      $html .= "<input id=\"submitBtn\" class=\"submitBtn\" type=\"submit\" value=\"Guardar Cambios\"/>";
      $html .= "<input id=\"resetBtn\" type=\"reset\" value=\"Reestablecer Valores\"/>";
      $html .= "</td></tr>";
      $html .= "</tbody>";
      $html .= "</table>";
      $html .= "</form><br/><br/><br/>";
      return $html;
    } else if (strcmp($status,"success") == 0) {
      $msg = "<br/><br/><br/><div id=\"successMsg\"><table style=\"border: 1;\"><h2>Cambios guardados satisfactoriamente</h2></table></div><br/><br/><ul><li><a href=\"/rspinf-usb/perfil/editarPerfil.php?Action=edit&mode=request\">Volver a editar el perfil</a></li><li><a href=\"/rspinf-usb/perfil/verPerfil.php?userq=".$_SESSION["k_username"]."\">Volver a ver el perfil</a></li><li><a href=\"/rspinf-usb/\">Volver al inicio</a></li></ul><br/><br/><br/>";
    }
    return $msg;
  }

  public function viewCreatePerfil($error = NULL) {
    if (is_null($error)) {
      $html = "<br/><br/><br/><h2>Perfil creado exitosamente!</h2><br/><p>Ahora puedes <a href=\"/rspinf-usb/Login/login.php\">Iniciar Sesión</a></p>";
    } else {
      $html = "<h2>Hubo errores haciendo el registro!</h2><br/><p>Error:<br/>".$error."</p>";
    }

    return $html;
  }

  private function showAdministracion($usr,$isAdmin){
    
    $html = "<tr><td><fieldset><legend><h3>&nbsp;Administración&nbsp;</h3></legend>";
    $html .= "<a id=\"disableAcc\" href=\"/rspinf-usb/administrador/accionesAdmin/desactivarCuentaAdminInterfaz.php?perfilActual=".$usr."\" onClick=\"return show_confirm3();\">Desactivar la cuenta de este usuario</a><br><br>";
    $html .= "<a id=\"warnUser\" href=\"/rspinf-usb/administrador/accionesAdmin/enviarAdvertenciaInterfaz.php?perfilActual=".$usr."\" onClick=\"return show_confirm2();\">Enviar Advertencia a este usuario</a><b/><br>";
    if (!$isAdmin) {
      $html .= "<a id=\"setAsAdmin\" href=\"/rspinf-usb/administrador/accionesAdmin/designarAdministradorInterfaz.php?perfilActual=".$usr."\" onClick=\"return show_confirm();\">Designar a este usuario como administrador</a><br/><br/>";
    }
    $html .= "</fieldset></td><tr>";
    return $html;
  }

  private function showSugerencias($usr){
    $html = "<tr><td><form onsubmit=\"return false;\"><fieldset><legend><h3>&nbsp;Sugerencias&nbsp;</h3></legend><ul>";
    $html .= "<li>Sugerencia1</li>";
    $html .= "<li>Sugerencia2</li>";
    $html .= "<li>Sugerencia3</li>";
    $html .= "<li>Sugerencia4</li>";
    $html .= "<li>Sugerencia5</li>";
    $html .= "<li>Sugerencia6</li>";
    $html .= "<li>Sugerencia7</li>";
    $html .= "</ul></fieldset></form></td><tr>";
    return $html;
  }

  private function viewNombre($usrname,$nombre,$apellido){
    $html = "<table><tbody>";
    $html .= "<tr><td><h1 style=\"font-size: 3em;color: #0B610B;\">{$nombre}&nbsp;&nbsp;{$apellido}</h1></td></tr>";
    $html .= "<tr><td><h3>Username: {$usrname}</h3></td></tr>";
    $html .= "</tbody></table>";
    return $html;
  }

  private function viewFotoPerfil($perfil){
    if (is_null($perfil["foto"])) {
      $pic = "";
      if (strcmp($perfil["sexo"],"M") == 0) {
        $pic = "maleShape.gif";
      } else if (strcmp($perfil["sexo"],"F") == 0) {
        $pic = "femaleShape.png";
      }
      $html = "<img style=\"width: 150px; height: 150px;\" src=\"images/{$pic}\" alt=\"Foto de Perfil\" />";
    } else {
      $html = "";
    }
    return $html;
  }

  public function showSocialMenu($usrname,$fotos,$isOwner, $isAdmin,$friendship, $solicitud) {
    $html = "<ul style=\"list-style-type: none;padding: 0px 0px 0px 0px;\">";
    $invitaciones = "";
    if (!$solicitud && !$friendship) {
      $invitaciones .= "<a href=\"/rspinf-usb/Solicitud/solicitudes.php?userq=".$usrname."\"><li class=\"socialMenu\"><p>Enviar Solicitud de Amistad</p></li></a>";
    } else if ($solicitud && !$friendship) {
      $invitaciones .= "<li style=\"color: gray;\" class=\"socialMenu\"><p>Solicitud de Amistad Enviada</p></li>";
    }
    if ($isOwner || $isAdmin) {
      $html .= "<a href=\"/rspinf-usb/mensajes/ListarMensajes.php\"><li class=\"socialMenu\"><p>Centro de Mensajes</p></li></a>";
      $html .= "<a href=\"/rspinf-usb/perfil/editarPerfil.php?mode=request\"><li class=\"socialMenu\"><p>Editar Perfil</p></li></a>";
    }
    if (!$isOwner) {
      $html .= $invitaciones;
      $html .= "<a href=\"/rspinf-usb/mensajes/EnviarMensaje.php?pid=".$usrname."\"><li class=\"socialMenu\"><p>Enviar Mensaje</p></li></a>";
    }
    if ($fotos || $isAdmin) {
    $html .= "<a href=\"/rspinf-usb/fotos/Vistas/albumes.php\"><li class=\"socialMenu\"><p>Ver Álbumes</p></li></a>";
    }
    $html .= "</ul>";
    return $html;
  }

  private function showFotos() {
    $html = "";
    return $html;
  }

  private function showDatosPerfil($perfil,$owner) {
    $labels = array("email" => "Email",
                    "fechaNac" => "Fecha de Nacimiento",
                    "carnet" => "Carnet",
                    "tipo" => "Categoría",
                    "nombre" => "Nombre",
                    "apellido" => "Apellido",
                    "sexo" => "Sexo",
                    "telefono" => "Teléfono",
                    "emailAlt" => "Email Alternativo",
                    "tweeter" => "Tweeter",
                    "ciudad" => "Ciudad",
                    "carrera" => "Carrera",
                    "colegio" => "Colegio",
                    "actividadesExtra" => "Actividades Extracurriculares",
                    "trabajo" => "Trabajo",
                    "bio" => "Biografía"
                    );
    $labelBasic = array("nombre" => "Nombre",
                        "apellido" => "Apellido",
                        "sexo" => "Sexo",
                        "tipo" => "Categoría"
                        );
    $labelContact = array("email" => "Email",
                          "telefono" => "Teléfono",
                          "emailAlt" => "Email Alternativo",
                          "tweeter" => "Tweeter"
                          );
    $labelAcad = array("carnet" => "Carnet",
                       "carrera" => "Carrera",
                       "colegio" => "Colegio"
                       );
    $labelMisc = array("actividadesExtra" => "Actividades Extracurriculares",
                       "trabajo" => "Trabajo",
                       "bio" => "Biografía"
                       );

    foreach ($labels as $key => $val) {
      $keys[] = $key;
      $values[] = $val;
    }
    $sexos = array("M" => "Masculino","F" => "Femenino");
    $meses = array (1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $dia = substr($perfil["fechaNac"],8,2);
    $mes = $meses[(int)substr($perfil["fechaNac"],5,2)];
    $anio = substr($perfil["fechaNac"],0,4);
    $html = "<fieldset><legend><h3>&nbsp;Datos&nbsp;</h3></legend>";
    $html .= "<table><tbody><tr><td>";

    $html .= "<fieldset><legend><h3>&nbsp;Datos Básicos&nbsp;</h3></legend><table><tbody>";
    foreach ($labelBasic as $key => $val) {
      $html .= "<tr>
                  <td><label for=\"id{$key}\">{$val}:&nbsp;</label></td>
                  <td class=\"dato\"><p id=\"id{$key}\">".$perfil["$key"]."</p></td>
                </tr>";
    }
    $html .= "<tr>
                  <td><label for=\"idfechaNac\">Fecha de Nacimiento:&nbsp;</label></td>
                  <td class=\"dato\"><p id=\"idfechaNac\">".$dia." de ".$mes." de ".$anio."</p></td>
                </tr>";
    $html .= "</tbody></table></fieldset>";

    $html .= "<fieldset><legend><h3>&nbsp;Datos de Contacto&nbsp;</h3></legend><table><tbody>";
    foreach ($labelContact as $key => $val) {
      $html .= "<tr>
                  <td><label for=\"id{$key}\">{$val}:&nbsp;</label></td>
                  <td class=\"dato\"><p id=\"id{$key}\">".$perfil["$key"]."</p></td>
                </tr>";
    }
    $html .= "</tbody></table></fieldset>";

    $html .= "<fieldset><legend><h3>&nbsp;Datos Académicos&nbsp;</h3></legend><table><tbody>";
    foreach ($labelAcad as $key => $val) {
      $html .= "<tr>
                  <td><label for=\"id{$key}\">{$val}:&nbsp;</label></td>
                  <td class=\"dato\"><p id=\"id{$key}\">".$perfil["$key"]."</p></td>
                </tr>";
    }
    $html .= "</tbody></table></fieldset>";

    $html .= "<fieldset><legend><h3>&nbsp;Datos Misceláneos&nbsp;</h3></legend><table><tbody>";
    foreach ($labelMisc as $key => $val) {
      $html .= "<tr>
                  <td><label for=\"id{$key}\">{$val}:&nbsp;</label></td>
                  <td class=\"dato\"><p id=\"id{$key}\">".$perfil["$key"]."</p></td>
                </tr>";
    }
    $html .= "</tbody></table></fieldset>";
    
    $html .= "<fieldset><legend><h3>&nbsp;Materias&nbsp;</h3></legend><table><tbody>";
    $html .= "<tr><td>";
    $html .= "<form action=\"/rspinf-usb/ModuloMaterias/verMaterias.php\" method=\"post\">
            <input type=\"hidden\" name=\"user\" value=\"".$perfil["usrname"]."\"  />
            <input type=\"submit\" value=\"Ver Materias Cursadas\" />
            </form>";
    if ($owner) {
    $html .= "<form action=\"/rspinf-usb/ModuloMaterias/agregarMateriaForm2.php\" method=\"post\">
            <input type=\"hidden\" name=\"user\" value=\"".$perfil["usrname"]."\"  /> 
            <input type=\"submit\" value=\"Agregar Materia Cursada\" />
            </form>";
    $html .= "<form action=\"/rspinf-usb/ModuloMaterias/EditarMaterias.php\" method=\"post\">
            <input type=\"hidden\" name=\"user\" value=\"".$perfil["usrname"]."\"  /> 
            <input type=\"submit\" value=\"Editar Materia Cursada\" />
            </form>";
    }
    $html .= "</td></tr>";
    $html .= "</tbody></table></fieldset>";

    $html .= "</td></tr></tbody></table>";
    $html .= "</fieldset>";

    return $html;
  }

  private function showMuroPerfil() {
    $html = "";
    $html = "<table><tbody>";
    $html .= "<tr><td><div style=\"width: 400px;\">";
    ob_start();
    require($_SESSION['dir']."/Muro/InsertarMuro.php");
    $html .= ob_get_contents();
    ob_end_clean();
    $html .= "</div></td></tr>";
    $html .= "</tbody></table>";
    return $html;
  }

  public function viewShowPerfil($viewer,$perfil, $isOwner, $friendship, $solicitud,$seguridadFotos, $seguridadMuro, $seguridadDatos) {
    $sugerencias = "<table><tbody>";
    if ($viewer["esAdmin"] && !$isOwner) {
       
      $sugerencias .= $this->showAdministracion($perfil["usrname"], $perfil["esAdmin"]);
    }
    $sugerencias .= $this->showSugerencias($perfil["usrname"]);
    $sugerencias .= "</tbody></table><br/><br/><br/><br/>";

    $fotoPerfil = $this->viewFotoPerfil($perfil);
    $nombre = $this->viewNombre($perfil["usrname"],$perfil["nombre"],$perfil["apellido"]);

    $barraIzq = "<table><tbody>";
    $barraIzq .= "<tr><td>".$this->showSocialMenu($perfil["usrname"],$seguridadFotos,$isOwner,$viewer["esAdmin"],$friendship,$solicitud)."</td></tr>";
    if ($seguridadFotos) {
      $barraIzq .= "<tr><td><fieldset><legend>&nbsp;Fotos&nbsp;</legend>".$this->showFotos()."</fieldset></td></tr>";
    }
    $barraIzq .= "</tbody></table>";

    $centro = "<table><tbody>";
    if ($seguridadDatos) {
      $centro .= "<tr><td>".$this->showDatosPerfil($perfil,$isOwner)."</td></tr>";
    }
    if ($seguridadMuro) {
      $centro .= "<tr><td>".$this->showMuroPerfil($perfil)."</td></tr>";
    }
    $centro .= "</tbody></table>";

    $contenido = "<table><tbody>";
    $contenido .= "<tr><td>".$fotoPerfil."</td><td>".$nombre."</td></tr>";
    $contenido .= "<tr><td>".$barraIzq."</td><td>".$centro."</td></tr>";
    $contenido .= "</tbody></table><br/><br/><br/><br/><br/>";

    $html = "                        <!-- Barra Lateral -->
                        <div id=\"barlateral\">
                            <div class=\"panel\">
                        <form method='post' action='/rspinf-usb/Abuso/abusoReportado.php' onsubmit=\"return show_confirm()\">
                            <br><p>
                            Tipo de abuso: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                            <select name=\"tipo\">
                                <option value=\"Foto ofensiva\">Foto ofensiva</option>
                                <option value=\"Comentario ofensivo\">Comentario ofensivo</option>
                                <option value=\"Violacion de Copyright\">Violaci&oacuten de Copyright</option>
                                <option value=\"Spam\">Spam</option>
                            </select>
                            <br><p>
                                Descr&iacutebenos con mas detalle el problema:<br />
                                <textarea name='message' rows='10' cols='30'>
                                </textarea><br/>
                                <input type='submit' value=\"Reportar\"/>
                        </form>
                    </div>
                            <h3><p class=\"flip\">Reportar abuso</p></h3>
                            <ul>";

    $html .= $sugerencias;

    $html .= "                            </ul>
                        </div>
                        <!-- Fin Barra Lateral -->
             <!-- Contenido -->
                <div id=\"content\"><br/><br/><br/><br/><br/><br/>";

    $html .= $contenido;

    return $html;
  }

  public function viewError($msg) {
    return utf8_encode("<div id=\"errorBox\"class=\"error\"><p>{$msg}</p></div>");
  }

  public function viewErrors($msgArr) {
    $out = "";
    foreach ($msgArr as $error) {
      $out .= "<li>{$error}<\li>";
    }
    return utf8_encode("<div id=\"errorBox\"class=\"error\"><ul>{$out}</ul></div>");
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