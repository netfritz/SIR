<?php
class Mensaje {

  private $mid;
  private $asunto;
  private $texto;
  private $emisor; //Instancia de MensajeEnviado
  private $dests; //Instancia de ListaMensajeRecibido

  // Atributo para determinar cómo se realizará la sincronización con la base de
  // datos
  private $nuevo; //Booleano

  public function __construct() {
    if (func_num_args() == 1) {
      // Obtener instancia de base de datos
      $mid = func_get_arg(0);
      $mapper = MensajeMapper::getInstance();
      $atts = $mapper->getAtributosMensaje($mid);
      if ($atts == NULL) {
	return NULL;
      }
      $this->mid = $mid;
      $this->asunto = $atts["asunto"];
      $this->texto = $atts["texto"];
      $this->emisor = new MensajeEnviado($this);
      $this->dests = new ListaMensajeRecibido($this);
      $this->nuevo = false;
    } else if (func_num_args() == 0) {
      $this->dests = new ListaMensajeRecibido();
      $this->dests->setMensaje($this);
      $this->nuevo = true;
    } else {
      return NULL;
    }
  }
  /*
   * Devuelve true si el emisor de este mensaje lo eliminó
   */
  public function esEliminadoEmisor() {
    return $this->emisor->esEliminado();
  }

  public function getId() {
    return $this->mid;
  }

  /*
   * $p: Perfil o string. Si es un perfil, se compara usando su operación equals
   *     Si es un string, se le pide a la fábrica de perfiles la instancia con
   *     ese string como identificador.
   * Devuelve true si $p es el emisor de este mensaje
   */
  public function esEmisor($p) {
    // Mientras tanto, en el futuro se cambiará a
    // $p->equals($this->emisor->getPerfil())
    return $p->getUsername()
      == $this->emisor->getPerfil()->getUsername();
  }

  /*
   * $p: Perfil o string. Si es un perfil, se compara usando su operación equals
   *     Si es un string, se le pide a la fábrica de perfiles la instancia con
   *     ese string como identificador.
   * Devuelve true si $p es uno de los destinatarios de este mensaje
   */
  public function esDestinatario($p) {
    return $this->dests->esDestinatario($p);
  }

  /*
   * $p: Perfil o string. Si es un perfil, se compara usando su operación equals
   *     Si es un string, se le pide a la fábrica de perfiles la instancia con
   *     ese string como identificador.
   * Devuelve true si $p eliminó este mensaje, false sino lo eliminó o no es
   * destinatario.
   */
  public function esEliminadoDest($p) {
    return $this->dests->esEliminado($p);
  }

  public function esLeidoDest($p) {
    return $this->dests->esLeido($p);
  }

  /*
   * $p: Perfil o string. Si es un perfil, se compara usando su operación equals
   *     Si es un string, se le pide a la fábrica de perfiles la instancia con
   *     ese string como identificador.
   * Marca el mensaje seleccionado com leído por el destinatario $p.
   * No regresa nada.
   */
  public function marcarLeido($p) {
    $this->dests->marcarLeido($p);
  }

  /*
   * Se encarga de sincronizar los cambios de este objeto en la base de datos.
   * Dependiendo de como fue instanciado se agrega una nueva instancia o se
   * intenta actualizar la existente.
   */
  public function save() {
    if ($this->nuevo) {
      $mapper = MensajeMapper::getInstance();
      $ms = $this->serialize();
      $me = $this->emisor->serialize();
      $lm = $this->dests->serialize();
      $mapper->insertMensaje($ms, $me, $lm);
      $this->nuevo = false;
    } else {
      // actualizar
      $mapper = MensajeMapper::getInstance();
      $ms = $this->serialize();
      $me = $this->emisor->serialize();
      $lm = $this->dests->serialize();
      $mapper->updateMensaje($ms, $me, $lm);
    }

  }

  public function setAsunto($a) {
    $this->asunto = $a;
  }

  public function setMensaje($m) {
    $this->texto = $m;
  }

  /*
   * $em: Perfil o string. Si es un perfil, se compara usando su operación equals
   *      Si es un string, se le pide a la fábrica de perfiles la instancia con
   *      ese string como identificador.
   */
  public function setEmisor($em) {
    $this->emisor = new MensajeEnviado();
    $this->emisor->setPerfil($em);
    $this->emisor->setMensaje($this);
    $this->emisor->setEliminado(false);
  }


  /*
   * $ds: Perfil o string. Si es un perfil, se compara usando su operación equals
   *      Si es un string, se le pide a la fábrica de perfiles la instancia con
   *      ese string como identificador.
   */
  public function agregarDestinatario($ds) {
    $fabperfil = FabricaPerfil::getInstance();
    $this->dests->agregarDestinatario($fabperfil->getPerfil($ds));
  }

  /*
   *
   */
  public function serialize() {
    return array("mid" => $this->mid,
		 "asunto" => $this->asunto,
		 "texto" => $this->texto);
  }

  public function getAsunto() {
    return $this->asunto;
  }

  public function getMensaje() {
    return $this->texto;
  }

  public function getEmisor() {
    return $this->emisor->getPerfil();
  }

  public function getDestinatarios() {
    return $this->dests->getDestinatarios();
  }

}

?>