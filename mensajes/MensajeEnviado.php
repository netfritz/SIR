<?php
class MensajeEnviado {

  private $eliminado;
  private $mensaje;
  private $perfil;

  public function __construct() {
    if (func_num_args() == 1) {
      $men = func_get_arg(0);
      $mapper = MensajeMapper::getInstance();
      $atts = $mapper->getAtributosMensajeEnviado($men->getId());
      if ($atts == NULL) {
	return NULL;
      }
      $this->mensaje = $men;
      $perffab = FabricaPerfil::getInstance();
      $this->perfil = $perffab->getPerfil($atts["emisor"]);
      $this->eliminado = $atts["eliminado"];
      return $this;
    } else if (func_num_args() == 0) {
      // Instancia nueva
      return $this;
    } else {
      return NULL;
    }
  }

  public function esEliminado() {
    return $this->eliminado;
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

  public function serialize() {
    return array("eliminado" => $this->eliminado, "emisor" => $this->perfil->getUsername());
  }
}
?>