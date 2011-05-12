<?php

abstract class interfazAll {
  protected $instancias;
  protected $mensajes;

  public function __construct($instancias, $mensajes=array()) {
    $this->instancias = $instancias;
    $this->mensajes = $mensajes;
  }

  abstract public function printv();

}

abstract class interfazForm {
  protected $instancia;
  protected $mensajes;
  protected $nuevo;

  public function  __construct($instancia, $nuevo=False, $mensajes=array()) {
    $this->instancia = $instancia;
    $this->mensajes = $mensajes;
    $this->nuevo = $nuevo;
  }

  abstract public function printv();

}
?>