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
  // Si la instancia es NULL, es para crear una nueva instancia
  protected $instancia;
  // Arreglo de strings para imprimir antes del formulario
  // Se puede usar para mostrar errores de validacion
  protected $mensajes;
  // Determina si la instancia ya existe o no en la BD
  // Se usa para determinar si se puede cambiar o no el campo clave
  // El campo clave se puede alterar si $instancia es NULL o si
  // $instancia no es NULL y $nuevo es True
  // En este ultimo caso quiere decir que el usuario fallo validacion
  // y se esta precargando el formulario con los datos que puso anteriormente
  protected $nuevo;

  // Si no se psan argumentos se asume que es para crear una instancia nueva
  public function  __construct($instancia=NULL, $nuevo=True, $mensajes=array()) {
    $this->instancia = $instancia;
    $this->mensajes = $mensajes;
    $this->nuevo = $nuevo;
  }

  abstract public function printv();

}
?>