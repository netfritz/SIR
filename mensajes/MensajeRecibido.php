<?php
class MensajeRecibido {

  private $mensaje;
  private $perfil;
  private $eliminado;
  private $leido;

  public function __construct() {
    if (func_num_args() == 2) {
      // Obtener instancia de base de datos
      $p = func_get_arg(0);
      $m = func_get_arg(1);
      $mapper = MensajeMapper::getInstance();
      $atts = $mapper->getAtributosMensajeRecibido($p->getUsername(), $m->getId());
      if ($atts == NULL) {
	return NULL;
      }
      $this->mensaje = $m;
      $this->perfil = $p;
      $this->eliminado = $atts["eliminado"];
      $this->leido = $atts["leido"];

    } else if (func_num_args() == 0) {
      // Instancia nueva
      $this->nuevo = true;
    } else {
      return NULL;
    }
  }

  public function serialize() {
    return array("eliminado" => $this->eliminado,
		 "leido" => $this->leido,
		 "destinatario" => $this->perfil->getUsername());
  }

  public function setPerfil($p) {
    $this->perfil = $p;
  }

  public function getPerfil() {
    return $this->perfil;
  }

  public function setMensaje($m) {
    $this->mensaje = $m;
  }

  public function setEliminado($el) {
    $this->eliminado = $el;
  }

  public function esEliminado() {
    return $this->eliminado;
  }

  public function esLeido() {
    return $this->leido;
  }

  public function setLeido($le) {
    $this->leido = $le;
  }
}
?>