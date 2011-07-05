<?php
class FabricaMensaje {
  private static $instance;

  // Arreglo asociativo que mapea identificadores de Mensaje a instancias de
  // Mensaje
  private $mensajes;

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
   * $mid: entero, identificador del mensaje que se quiere obtener
   * Clase que maneja a las instancias de Mensaje
   * Si la instancia pedida ya fue creada, se devuelve, sino, se
   * instancia y se devuelve.
   * Sirve para evitar instanciar más de una vez la misma instancia.
   */
  public function getMensaje($mid) {
    if (isset($this->mensajes[$mid])) {
      return $this->mensajes[$mid];
    } else {
      $m = new Mensaje($mid);
      if ($m != NULL) {
        $this->mensajes[$mid] = $m;
	return $m;
      } else {
	return NULL;
      }
    }
  }
}
?>