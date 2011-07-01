<?php
class ListaMensaje {

  private $mensajes;

  public function __construct() {
    if (func_num_args() == 2) {
      $p = func_get_arg(0);
      $tipo = func_get_arg(1);
      $mapper = MensajeMapper::getInstance();
      $mids = $mapper->obtenerMensajes($p->getUsername(), $tipo);
      $msjfab = FabricaMensaje::getInstance();
      $this->mensajes = array();
      foreach ($mids as $mid) {
	$this->mensajes[] = $msjfab->getMensaje($mid);
      }
      return $this;
    } else {
      return NULL;
    }
  }

  public function getMensajes() {
    return $this->mensajes;
  }

}
?>