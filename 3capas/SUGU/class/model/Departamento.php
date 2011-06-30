<?php
require_once("DataBase.php");

class Departamento {

  // Atributos
  private $id;
  private $universidad;
  private $codigo;
  private $nombre;
  private $direccion;
  
  private $new = FALSE;

  // funciones de modificacion 
  function __construct($universidad, $codigo, $nombre, $direccion) {
    $this->id = NULL;
    $this->universidad = $universidad;
    $this->codigo = $codigo;
    $this->nombre = $nombre;
    $this->direccion = $direccion;
    $this->new = TRUE;
  }

  public static function all() {
    DataBase::singleton();
    $res = mysql_query("SELECT * FROM Departamento");
    $arr = array();
    while ($fila = mysql_fetch_assoc($res)) {
      $dep = new Departamento ($fila["universidad"],
			       $fila["codigo"], 
			       $fila["nombre"], 
			       $fila["direccion"]);
      $dep->id = $fila["id"];
      $dep->new = False;
      $arr[] = $dep;
    }
    return $arr;
  }

  public static function getByKey($id) {
    DataBase::singleton();
    $bus=mysql_query("SELECT * FROM Departamento WHERE id={$id}");
    if ($fila=mysql_fetch_assoc($bus)) {
      $dep= new Departamento($fila["universidad"],$fila["codigo"],$fila["nombre"],$fila["direccion"]);
      $dep->id = $fila["id"];
      $dep->new = False;
      return $dep;
    } else {
      return NULL;
    }
  }
    
  public function save() {
    DataBase::singleton();
    if ($this->new) {
      $res = mysql_query("INSERT INTO Departamento (universidad, codigo, nombre, direccion) 
                         VALUES ('{$this->universidad}', '{$this->codigo}', '{$this->nombre}', '{$this->direccion}')");
    } else {
      $res = mysql_query("UPDATE Departamento SET universidad='{$this->universidad}', codigo='{$this->codigo}', 
                          nombre='{$this->nombre}', direccion='{$this->direccion}' 
                          WHERE id={$this->id}");
    }
    $this->new = False;
  }


  public function delete() {
    DataBase::singleton();
    $res = mysql_query("DELETE FROM Departamento WHERE id='{$this->id}'");
  }

  public function __toString() {
    return "{$this->id}";
  }

  // funciones de modificacion directa y obtencion de atributos
  public function getId() {
    return $this->id;
  }
  
  public function getUniversidad() {
    return $this->universidad;
  }

  public function getCodigo() {
    return $this->codigo;
  }

  public function getNombre() {
    return $this->nombre;
  }

  public function getDireccion() {
    return $this->direccion;
  }

  public function setNombre($nom) {
    $this->nombre = $nom;
  }

  public function setCodigo($cod) {
    $this->codigo = $cod;
  }

  public function setDireccion($dir) {
    $this->direccion = $dir;
  }

  public function setUniversidad($uni) {
    $this->universidad = $uni;
  }
    
}

?>

