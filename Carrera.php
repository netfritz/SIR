<?php
require_once("DataBase.php");

class Carrera {
  private $nombre;
  private $direccion;
  private $coordinador;
  private $codigo;
  private $oldcodigo;

  private $new = False;
  private $changedCodigo = False;

  private function __construct() {
    // No hago nada
  }

  public static function all() {
    DataBase::singleton();
    $res = mysql_query("SELECT * FROM Carrera;");
    while ($row = mysql_fetch_assoc($res)) {
      $car = new Carrera($row["codigo"],
			 $row["nombre"],
			 $row["direccion"],
			 $row["coordinador"]);
      $car->new = False;
      $car->changedCodigo = False;
      $car->oldcodigo = $row["codigo"];
      $ret[] = $car;
    }
    return $ret;
  }

  public static function getByKey($key) {
    DataBase::singleton();
    $res = mysql_query("SELECT * FROM Carrera WHERE codigo=".$key.";");
    $car = new Carrera($row["codigo"],
		       $row["nombre"],
		       $row["direccion"],
		       $row["coordinador"]);
    $car->new = False;
    $car->changedCodigo = False;
    $car->oldcodigo = $row["codigo"];
    return $car;
  }
  
  public function save() {
    DataBase::singleton();
    if ($this->new) {
      mysql_query("INSERT INTO Carrera VALUES ("
		  . $this->codigo .", ". $this->nombre .", "
		  . $this->direccion .", ". $this->coordinador .");");
    } else {
      mysql_query("UPDATE Carrera SET codigo=".$this->codigo
		  .", nombre=".$this->nombre
		  .", direccion=".$this->direccion
		  .", coordinador=".$this->coordinador
		  ." WHERE codigo=".$this->oldcodigo.";");
    }
    
    $this->new = False;
    $car->changedCodigo = False;
    $car->oldcodigo = $row["codigo"];
  }

  public function delete() {
    DataBase::singleton();
    mysql_query("DELETE FROM Carrera WHERE codigo=".$this->codigo.";");
  }

  public function toString() {
    echo $this->codigo . "  " . $this->nombre;
  }

  public function __construct($codigo, $nombre, $direccion, $coordinador) {
    $this->codigo = $codigo;
    $this->nombre = $nombre;
    $this->direccion = $direccion;
    $this->coordinador = $coordinador;
    $this->new = True;
  }

  public function getNombre() {
    return $this->nombre;
  }

  public function getDireccion() {
    return $this->direccion;
  }

  public function getCoordinador() {
    return $this->coordinador;
  }

  public function getCodigo() {
    return $this->codigo;
  }

  public function setNombre($nom) {
    $this->nombre = $nom;
  }

  public function setDireccion($dir) {
    $this->direccion = $dir;
  }

  public function setCoordinador($coo) {
    $this->coordinador = $coo;
  }

  public function setCodigo($cod) {
    if (!$this->changedCodigo) {
      $this->oldcodigo = $this->codigo;
      $this->changedCodigo = True;
    }
    $this->codigo = $cod;
  }

?>