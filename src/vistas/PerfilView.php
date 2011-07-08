<?php
class PerfilView {
  private static $instance; // Representa la unica instancia de esta clase

  public function viewRegisterEmpty(){
    return "<form name=\"registro\" action=\"/?Action=create\" method=\"POST\">
                      <table>
                        <tbody>
                          <div id=\"usrnameContainer\">
                            <tr>
                              <label for=\"usrnameTBox\">Username:</label>
                            </tr><br/>
                            <tr>
                              <input id=\"usrnameTBox\" name=\"usrname\" type=\"text\" class=\"field\"/>
                            </tr><br/>
                            <tr>
                              <label for=\"usrnameTBox\" class=\"error\"></label>
                            </tr><br/>
                          </div>
                          <tr>
                            <label for=\"nameTBox\">Nombre:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"nameTBox\" name=\"name\" type=\"text\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"nameTBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"lnameTBox\">Apellido:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"lnameTBox\" name=\"lastname\" type=\"text\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"lnameTBox\" class=\"error\"></label>
                          </tr><br/>
                          <div id=\"emailContainer\">
                            <tr>
                              <label for=\"emailTBox\"> E-Mail: </label>
                            </tr><br/>
                            <tr>
                              <input id=\"emailTBox\" name=\"email\" type=\"text\" class=\"field\"/>
                            </tr><br/>
                            <tr>
                              <label for=\"emailTBox\" class=\"error\"></label>
                            </tr><br/>
                          </div>
                          <tr>
                            <label for=\"email2TBox\"> Reescriba su email:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"email2TBox\" name=\"email2\" type=\"text\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"email2TBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"passwdTBox\">Contraseña:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"passwdTBox\" name=\"passwd\" type=\"password\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"passwdTBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"passwd2TBox\">Reescriba su Contraseña:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"passwd2TBox\" name=\"passwd2\" type=\"password\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"passwd2TBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"bdateTBox\">Fecha de Nacimiento:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"bdateTBox\" name=\"bdate\" type=\"text\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"bdateTBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"tipo\">Eres:</label>
                          </tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <tr>
                            <select id=\"tipo\" name=\"tipo\" class=\"field\">
                               <option value=\"Estudiante\" selected=\"selected\">Estudiante</option>
                               <option value=\"Profesor\">Profesor</option>
                            </select>
                          </tr><br/>
                          <input id=\"submitButton\" type=\"submit\" value=\"Enviar!\">
                        </tbody>
                      </table>
                    </form>";
  }

  public function viewEditPerfil($perfil,$status) {
    if (strcmp($status,"request") == 0) {
      $msg = "<form name=\"registro\" action=\"editarPerfil.php?Action=edit&mode=submit\" method=\"POST\">
                      <table>
                        <tbody>
                        <h3>Datos Básicos:</h3>
                          <div id=\"usrnameContainer\">
                            <tr>
                              <label for=\"usrnameTBox\">Username:</label>
                            </tr><br/>
                            <tr>
                              <input id=\"usrnameTBox\" name=\"usrname\" type=\"readonly\" class=\"field\" value=\"".$perfil['usrname']."\" disabled/>
                            </tr><br/><br/>
                          </div>
                          <tr>
                            <label for=\"nameTBox\">Nombre:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"nameTBox\" name=\"name\" type=\"text\" class=\"field\" value=\"".$perfil['nombre']."\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"nameTBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"lnameTBox\">Apellido:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"lnameTBox\" name=\"lastname\" type=\"text\" class=\"field\" value=\"".$perfil['apellido']."\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"lnameTBox\" class=\"error\"></label>
                          </tr><br/>
                          <div id=\"emailContainer\">
                            <tr>
                              <label for=\"emailTBox\"> E-Mail: </label>
                            </tr><br/>
                            <tr>
                              <input id=\"emailTBox\" name=\"email\" type=\"text\" class=\"field\" value=\"".$perfil['email']."\"/>
                            </tr><br/>
                            <tr>
                              <label for=\"emailTBox\" class=\"error\"></label>
                            </tr><br/>
                          </div>
                          <tr>
                            <label for=\"email2TBox\"> Reescriba su email:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"email2TBox\" name=\"email2\" type=\"text\" class=\"field\" value=\"".$perfil['email']."\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"email2TBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"passwdTBox\">Contraseña:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"passwdTBox\" name=\"passwd\" type=\"password\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"passwdTBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"passwd2TBox\">Reescriba su Contraseña:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"passwd2TBox\" name=\"passwd2\" type=\"password\" class=\"field\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"passwd2TBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"bdateTBox\">Fecha de Nacimiento:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"bdateTBox\" name=\"bdate\" type=\"text\" class=\"field\" value=\"".$perfil['fechaNac']."\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"bdateTBox\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                          <tr>
                            <label for=\"carnet\">Carnet:</label>
                          </tr><br/>
                          <tr>
                            <input id=\"carnet\" name=\"carnet\" type=\"text\" class=\"field\" value=\"".$perfil['carnet']."\"/>
                          </tr><br/>
                          <tr>
                            <label for=\"carnet\" class=\"error\"></label>
                          </tr><br/>
                          <tr>
                            <label for=\"tipo\">Eres:</label>
                          </tr>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          <tr>
                            <select id=\"tipo\" name=\"tipo\" class=\"field\">";
      if (strcmp($perfil["tipo"],"Estudiante") == 0) {
        $msg .= "
                               <option value=\"Estudiante\" selected=\"selected\">Estudiante</option>
                               <option value=\"Profesor\">Profesor</option>";
      } else if (strcmp($perfil["tipo"],"Profesor") == 0) {
        $msg .= "
                               <option value=\"Estudiante\">Estudiante</option>
                               <option value=\"Profesor\" selected=\"selected\">Profesor</option>";
      }
      $msg .= "
                            </select>
                          </tr><br/>
                          <input id=\"submitButton\" type=\"submit\" value=\"Enviar!\">
                        </tbody>
                      </table>
                    </form>";
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