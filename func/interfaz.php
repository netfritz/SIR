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
  protected $nuevo;

  public __construct($instancia=NULL, $nuevo=False, $mensajes=array()) {
    $this->instancia = $instancia;
    $this->mensajes = $mensajes;
    $this->nuevo = $nuevo;
  }

  abstract public print();

}