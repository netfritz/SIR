<?php
class FachadaMensajes {
  // Fachada para el módulo de mensajes
  private static $instance;

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
   * $perfil: Perfil, es el usuario que pretende leer el mensaje
   * $mid: entero, es el identificador del mensaje que se quiere leer
   */
  public function leerMensaje($perfil, $mid) {
    if (is_string($perfil)) {
      $perffab = FabricaPerfil::getInstance();
      $perfil = $perffab->getPerfil($perfil);
    } else if (is_object($perfil) && get_class($perfil)=="Perfil") {
      // Bien
    } else {
      // El tipo está mal, lanzar error
    }

    $msjfab = FabricaMensaje::getInstance();
    $m = $msjfab->getMensaje($mid);
    if ($m->esEmisor($perfil)) {
      if ($m->esEliminadoEmisor()) {
	return NULL;
      } else {
	return $m;
      }
    }

    if (!$m->esDestinatario($perfil) || $m->esEliminadoDest($perfil)) {
      return NULL;
    }

    $m->marcarLeido($perfil);
    $m->save();
    return $m;
  }

  /*
   * $perfil: Perfil, es el usuario que quiere obtener sus mensajes
   * $tipo: string, puede ser 'recibidos' o 'enviados'
   */
  public function listarMensajes($perfil, $tipo) {
    if (is_string($perfil)) {
      $perffab = FabricaPerfil::getInstance();
      $perfil = $perffab->getPerfil($perfil);
    } else if (is_object($perfil) && get_class($perfil)=="Perfil") {
      // Bien
    } else {
      // El tipo está mal, lanzar error
    }

    return new ListaMensaje($perfil, $tipo);
  }

  /*
   * $asunto: string, asunto del mensaje
   * $texto: string, cuerpo del mensaje
   * $emisor: Perfil, usuario que envia el mensaje
   * $dests: arreglo de strings, los identificadores de los usuarios que van a
   *         recibir los mensajes.
   */
  public function enviarMensaje($asunto, $texto, $emisor, $dests) {
    $m = new Mensaje();
    $m->setAsunto($asunto);
    $m->setMensaje($texto);
    $m->setEmisor($emisor);
    foreach ($dests as $d) {
      $m->agregarDestinatario($d);
    }
    $m->save();
  }

}
?>