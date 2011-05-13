<?php
require_once("DataBase.php");

class Materia{
  
  private $id;
  private $dpto;
  private $codigo;
  private $nombre;
  
  private $new = False;
  
  // - funcion all, muestra todas las materias en la tabla

  public static function all(){
    DataBase::singleton();
    $rsql = mysql_query("SELECT * FROM Materia;");
    while ($fila = mysql_fetch_assoc($rsql)) {
      $mate = new Materia($fila["id"],
			  $fila["dpto"],
			  $fila["codigo"],
			  $fila["nombre"]);
      $mate->new = False;
      $ret[] = $mate;
    }
    return $ret;
  }

  public static function getByKey($key){
    Database::singleton();
    $key = mysql_real_escape_string(stripslashes($key));
    $rsql = mysql_query("SELECT * FROM Materia WHERE id=".$key.";");
    if ($fila = mysql_fetch_assoc($rsql)){
      $mate = new Materia($fila["id"],
			  $fila["dpto"],
			  $fila["codigo"],
			  $fila["nombre"]);
      $mate->new = False;
      return $mate;
    } else {
      return NULL;
    }
  } 
   public function save() {
    DataBase::singleton();
    if ($this->new) {
      $res = mysql_query("INSERT INTO Materia VALUES (
                         '{$this->id}', '{$this->dpto}', 
                         '{$this->codigo}', '{$this->nombre}')");
    } else {
      $res = mysql_query("UPDATE Materia SET dpto='{$this->dpto}', 
                         codigo='{$this->codigo}', 
                         nombre='{$this->nombre}' 
                         WHERE id='{$this->id}'");
    }
    $this->new = False;
  }

 
  
  public function delete() {
    DataBase::singleton();
    $res = mysql_query("DELETE FROM Materia WHERE id='".$this->id."';");
  }

  
  public function __toString() {
    return $this->codigo . "  " . $this->nombre;
  }
  
  public function __construct($id, $dpto, $codigo, $nombre) {
    $this->id = $id;
    $this->dpto = $dpto;
    $this->codigo = $codigo;
    $this->nombre = $nombre;
    $this->new = True;
  }

  public function getid() {
    return $this->id;
  }

  public function getdpto() {
    return $this->dpto;
  }

  public function getcodigo() {
    return $this->codigo;
  }

  public function getnombre() {
    return $this->nombre;
  }

  public function setnombre($nombre) {
    $this->nombre = $nombre;
  }

  public function setdpto($dpto) {
    $this->dpto = $dpto;
  }

  public function setcodigo($codigo) {
    $this->codigo = $codigo;
  }

 

 
  

}
?>