<?php
public class FabricaMensaje {
  private static $instance;

  // Arreglo asociativo que mapea identificadores de Mensaje a instancias de
  // Mensaje
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

  public function getPerfil($pid) {
    if (isset($this->perfiles["{$pid}"])) {
      return $this->perfiles["{$pid}"];
    } else {
      $p = new Perfil($pid);
      if ($p != NULL) {
        $this->perfiles["{$pid}"] = $p;
      } else {
	return NULL;
      }
    }
  }
}
?>
