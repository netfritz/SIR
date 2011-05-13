<?php
require_once("DataBase.php");

class Carrera {
  // Atributos de la instancia (columnas de la tabla)
  private $nombre;
  private $direccion;
  private $coordinador;
  private $codigo;

  // Determina si esta instancia ya existe o no en la BD
  private $new = False;

  public static function all() {
    DataBase::singleton();
    $res = mysql_query("SELECT * FROM Carrera;");
    $ret = array();
    while ($row = mysql_fetch_assoc($res)) {
      $car = new Carrera($row["codigo"],
			 $row["nombre"],
			 $row["direccion_coordinacion"],
			 $row["coordinador"]);
      $car->new = False;
      $ret[] = $car;
    }
    return $ret;

  }

  public static function getByKey($key) {
    DataBase::singleton();
    $key = mysql_real_escape_string(stripslashes($key));
    $res = mysql_query("SELECT * FROM Carrera WHERE codigo='{$key}'");
    if ($row = mysql_fetch_assoc($res)) {
      $car = new Carrera($row["codigo"],
			 $row["nombre"],
			 $row["direccion_coordinacion"],
			 $row["coordinador"]);
      $car->new = False;
      return $car;
    } else {
      return NULL;
    }
  }
  
  public function save() {
    DataBase::singleton();
    if ($this->new) {
      $res = mysql_query("INSERT INTO Carrera VALUES (
                         '{$this->codigo}', '{$this->nombre}', 
                         '{$this->direccion}', '{$this->coordinador}')");
    } else {
      $res = mysql_query("UPDATE Carrera SET nombre='{$this->nombre}', 
                         direccion_coordinacion='{$this->direccion}', 
                         coordinador='{$this->coordinador}' 
                         WHERE codigo='{$this->codigo}'");
    }
    $this->new = False;
  }

  public function delete() {
    DataBase::singleton();
    $res = mysql_query("DELETE FROM Carrera WHERE codigo='{$this->codigo}'");
  }

  public function __toString() {
    return $this->codigo . "  " . $this->nombre;
  }

  public function __construct($codigo, $nombre, $direccion, $coordinador) {
    $this->codigo = mysql_real_escape_string(stripslashes($codigo));
    $this->nombre = mysql_real_escape_string(stripslashes($nombre));
    $this->direccion = mysql_real_escape_string(stripslashes($direccion));
    $this->coordinador = mysql_real_escape_string(stripslashes($coordinador));
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
    $this->nombre = mysql_real_escape_string(stripslashes($nom));
  }

  public function setDireccion($dir) {
    $this->direccion = mysql_real_escape_string(stripslashes($dir));
  }

  public function setCoordinador($coo) {
    $this->coordinador = mysql_real_escape_string(stripslashes($coo));
  }

}
?>
