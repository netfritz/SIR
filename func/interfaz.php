abstract class interfazAll {
  protected $instancias;
  protected $mensajes;

  public __construct($instancias, $mensajes=array()) {
    $this->instancias = $instancias;
    $this->mensajes = $mensajes;
  }

  abstract public print();

}

abstract class interfazForm {
  protected $instancia;
  protected $mensajes;

  public __construct($instancia=NULL, $mensajes=array()) {
    $this->instancia = $instancia;
    $this->mensajes = $mensajes;
  }

  abstract public print();

}

