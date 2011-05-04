<?php
class DataBase{
  private static var $instance; // Representa la unica instancia de esta clase

  private var $db = "sir";         // Estos valores deben ser cambiados manual-
  private var $usr = "root";       // mente por los correspondientes al servidor
  private var $passwd = "";        // mysql que cada quien esté usando. Estos 
  private var $host = "localhost"; // son los valores por default.

  private var $link;               // Almacena el identificador de la conexión
  private static var $linked;      // Verdadero si hay una conexión abierta.

  
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

  /**
   * Se encarga de crear la conexión a la base de datos. No recibe ningún 
   * parámetro.
   */
  public function connect(){
    $this->link = mysql_connect($this->host,$this->usr,$this->passwd) or
      die("Problemas al conectarse a la base de datos");
    $this->linked = True;
    mysql_select_db($db,$link) or
      die("Problemas al seleccionar la base de datos");
    return $this->link;
  }
  
  /**
   * Se encarga de cerrar la conexión con la base de datos. No recibe ningún
   * parámetro.
   */
  public function close(){
    $this->linked = False;
    return mysql_close($this->link);
  }
}
?>