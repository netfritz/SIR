<?php
require_once("../mappers/Perfil.php");
class PerfilFactory {
  private static $instance;

  /* Arreglo asociativo que mapea identificadores de perfiles a perfiles */
  private $perfiles;

  private function __construct() {

  }

  public static function getInstance() { //metodo Singleton
    if (!isset(self::$instance)) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

  /*
   * $pid: string, identificador del perfil que se quiere obtener
   * Clase que maneja a las instancias de Perfil
   * Si la instancia pedida ya fue creada, se devuelve, sino, se
   * instancia y se devuelve.
   * Sirve para evitar instanciar más de una vez la misma instancia.
   */
  public function getPerfil($usrname) {
    if (isset($this->perfiles["{$usrname}"])) {
      return $this->perfiles["{$usrname}"];
    } else {
      $p = new Perfil($usrname);
      if (!$p->isEmpty()) {
        $this->perfiles["{$usrname}"] = $p;
      } else {
        return NULL;
      }
    }
  }
}
?>
