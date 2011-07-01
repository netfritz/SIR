<?php
class ListaMensajeRecibido {

  private $mensaje;
  private $lista;

  private $nuevo;

  public function __construct() {
    if (func_num_args()==1) {
      $this->mensaje = func_get_arg(0);
      $this->nuevo = false;
    } else {
      $this->nuevo = true;
    }
    $this->lista = array();
  }

  public function agregarDestinatario($p) {
   $pid = $p->getUsername();
   if (!array_key_exists($pid,$this->lista)) {
     $mr = new MensajeRecibido();
     $mr->setPerfil($p);
     $mr->setMensaje($this->mensaje);
     $mr->setEliminado(false);
     $mr->setLeido(false);
     $this->lista[$pid] = $mr;
   }
  }

  public function esDestinatario($p) {
    $pid = $p->getUsername();
    if (!array_key_exists($pid,$this->lista)) {
      // Vamos a instanciarlo a ver
      $this->lista[$pid] = new MensajeRecibido($p, $this->mensaje);
    }
    return ($this->lista[$pid]!=NULL);
  }

  public function esEliminado($p) {
    $pid = $p->getUsername();
    if (!array_key_exists($pid,$this->lista)) {
      // Vamos a instanciarlo a ver
      $this->lista[$pid] = new MensajeRecibido($p, $this->mensaje);
    }
    return $this->lista[$pid]->esEliminado();
  }

  public function esLeido($p) {
    $pid = $p->getUsername();
    if (!array_key_exists($pid,$this->lista)) {
      // Vamos a instanciarlo a ver
      $this->lista[$pid] = new MensajeRecibido($p, $this->mensaje);
    }
    return $this->lista[$pid]->esLeido();
  }

  public function marcarLeido($p) {
    $pid = $p->getUsername();
    if (!array_key_exists($pid,$this->lista)) {
      // Vamos a instanciarlo a ver
      $this->lista[$pid] = new MensajeRecibido($p, $this->mensaje);
    }
    $this->lista[$pid]->setLeido(true);
    $this->nuevo = true;
  }

  public function serialize() {
    $salida = array();
    foreach ($this->lista as $elem) {
      if ($elem != NULL) {
	$salida[] = $elem->serialize();
      }
    }
    return $salida;
  }

  public function setMensaje($m) {
    $this->mensaje = $m;
  }

  public function getDestinatarios() {
    // Esta función está chimba por ahora
    // Para la próxima la hago como dios manda
    $mapper = MensajeMapper::getInstance();
    $dests = $mapper->getDestinatarios($this->mensaje->getId());
    $fabperf = FabricaPerfil::getInstance();
    $perfiles = array();
    foreach ($dests as $d) {
      $perfiles[] = $fabperf->getPerfil($d);
    }
    return $perfiles;
  }

}
?>