<?php
class PerfilView {
  private static $instance; // Representa la unica instancia de esta clase

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

  //#####################################################################//
  //                          Fin del Singleton                          //
  //                     Inicio Generación de Vistas                     //
  //#####################################################################//

  public function viewRegisterEmpty(){
    return "<form name=\"registro\" action=\"bienvenida.php?Action=create&mode=request\" method=\"POST\">
                      <table>
                        <tbody>
                          <tr>
                            <label>Username:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"usrname\" type=\"text\" class=\"field\"/>
                          </tr><br/><br/>
			              <tr>
                            <label>Nombre:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"name\" type=\"text\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Apellido:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"lastname\" type=\"text\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label> E-Mail: </label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"email\" type=\"text\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label> Reescriba su email:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"email2\" type=\"text\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Contraseña:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"passwd\" type=\"password\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Reescriba su Contraseña:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"passwd2\" type=\"password\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Fecha de Nacimiento:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"bdate\" type=\"text\" class=\"field\"/>
                          </tr><br/><br/>
                          <input type=\"submit\" value=\"Enviar!\">
                        </tbody>
                      </table>
                    </form>";
  }
  
  public function viewEditPerfil($perfil,$status) {
    if (strcmp($status,"edit")) {
      $msg = "<form name=\"registro\" action=\"bienvenida.php?Action=edit&mode=submit\" method=\"POST\">
                      <table>
                        <tbody>
                          <tr>
                            <label>Username:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"usrname\" type=\"text\" class=\"field\" value=\"{$perfil['usrname']}\"/>
                          </tr><br/><br/>
			              <tr>
                            <label>Nombre:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"name\" type=\"text\" class=\"field\" value=\"{$perfil['name']}\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Apellido:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"lastname\" type=\"text\" class=\"field\" value=\"{$perfil['lastname']}\"/>
                          </tr><br/><br/>
                          <tr>
                            <label> E-Mail: </label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"email\" type=\"text\" class=\"field\" value=\"{$perfil['email']}\"/>
                          </tr><br/><br/>
                          <tr>
                            <label> Reescriba su email:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"email2\" type=\"text\" class=\"field\" value=\"{$perfil['email2']}\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Contraseña:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"passwd\" type=\"password\" class=\"field\" />
                          </tr><br/><br/>
                          <tr>
                            <label>Reescriba su Contraseña:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"passwd2\" type=\"password\" class=\"field\"/>
                          </tr><br/><br/>
                          <tr>
                            <label>Fecha de Nacimiento:</label>
                          </tr><br/><br/>
                          <tr>
                            <input name=\"bdate\" type=\"text\" class=\"field\" value=\"{$perfil['bdate']}\"/>
                          </tr><br/><br/>
                          <input type=\"submit\" value=\"Enviar!\">
                        </tbody>
                      </table>
                    </form>";
    }
  }

}
?>