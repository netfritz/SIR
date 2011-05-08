<?php
require_once("DataBase.php");

class Carrera {
  // Atributos de la instancia (columnas de la tabla)
  private $nombre;
  private $direccion;
  private $coordinador;
  private $codigo;
  private $hola;

  // Cuando se altera la clave primaria, se guarda la vieja para
  // poder ubicar la fila en la BD y actualizarla
  private $oldcodigo;
  private $changedCodigo = False;

  // Determina si esta instancia ya existe o no en la BD
  private $new = False;

  // Por hacer:
  // - Validar entrada
  // - Verificar los errores de mysql y devolver cosas apropiadas
  


  public static function all() {
    DataBase::singleton();
    $res = mysql_query("SELECT * FROM Carrera;");
    while ($row = mysql_fetch_assoc($res)) {
      $car = new Carrera($row["codigo"],
			 $row["nombre"],
			 $row["direccion_coordinacion"],
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
    $res = mysql_query("SELECT * FROM Carrera WHERE codigo='".$key."';");
    if ($row = mysql_fetch_assoc($res)) {
      $car = new Carrera($row["codigo"],
			 $row["nombre"],
			 $row["direccion_coordinacion"],
			 $row["coordinador"]);
      $car->new = False;
      $car->changedCodigo = False;
      $car->oldcodigo = $row["codigo"];
      return $car;
    } else {
      return NULL;
    }
  }
  
  public function save() {
    DataBase::singleton();
    if ($this->new) {
      $res = mysql_query("INSERT INTO Carrera VALUES ('"
		  . $this->codigo ."', '". $this->nombre ."', '"
		  . $this->direccion ."', '". $this->coordinador ."');");
    } else {
      $res = mysql_query("UPDATE Carrera SET codigo='".$this->codigo
		  ."', nombre='".$this->nombre
		  ."', direccion_coordinacion='".$this->direccion
		  ."', coordinador='".$this->coordinador
		  ."' WHERE codigo='".$this->oldcodigo."';");
    }

    $this->new = False;
    $this->changedCodigo = False;
    $this->oldcodigo = $this->codigo;
  }

  public function delete() {
    DataBase::singleton();
    $res = mysql_query("DELETE FROM Carrera WHERE codigo='".$this->codigo."';");
  }

  public function __toString() {
    return $this->codigo . "  " . $this->nombre;
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

}
?>