<?php

require_once("DataBase.php");

class Departamento{

// Atributos
private  $id;
private $codigo;
private $nombre;
private $direccion;

private $new = FALSE;

// funciones de modificacion 
 function __construct($id,$codigo,$nombre,$direccion){
$this->id = $id;
$this->codigo = $codigo;
$this->nombre = $nombre;
$this->direccion = $direccion;
$this->new = TRUE;
}

public static function all() {
    DataBase::singleton();
    $bus = mysql_query("SELECT * FROM Departamento;");
    while ($fila = mysql_fetch_assoc($res)) {
      $dep = new Departamento($fila["id"], $fila["codigo"], $fila["nombre"], $fila["direccion"]);
      $dep->new = False;
      $res[] = $dep;
    }
    return $res;
  }

public static function getByKey($key) {
   DataBase::singleton();
   $bus=mysql_query("SELECT * FROM Departamento WHERE id='" .$key."'");
   if(!$bus){
     return null;
   }else{
     $fila=mysql_fetch_assoc($res);
     $dep= new Departamento($fila["id"],$fila["codigo"],$fila["nombre"],$fila["direccion"]);
     $dep->nueva=FALSE;
     return $dep;
   }



public function save() {
    DataBase::singleton();
    if ($this->new) {
      $res = mysql_query("INSERT INTO Departamento VALUES ('"
		  . $this->id ."', '". $this->codigo ."', '"
		  . $this->nombre ."', '". $this->direccion ."');");
    } else {
      $res = mysql_query("UPDATE Departamento SET id='" .$this->id ."', codigo='".$this->codigo
		  ."', nombre='".$this->nombre  ."', direccion='" .$this->direccion."';");
    }

    $this->new = False;
  }


  public function delete() {
    DataBase::singleton();
    $res = mysql_query("DELETE FROM Departamento WHERE id='".$this->id."';");
  }

  public function __toString() {
    return $this->id ;
  }

// funciones de modificacion directa y obtencion de atributos

  public function geID() {
    return $this->ID;
  }

  public function getCodigo() {
    return $this->codigo;
  }

  public function getNombre() {
    return $this->nombrer;
  }

  public function geDireccion() {
    return $this->direccion;
  }

  public function setNombre($nom) {
    $this->nombre = $nom;
  }

  public function setDireccion($dir) {
    $this->direccion = $dir;
  }

  public function setDireccion($dir) {
    $this->direccion = $dir;
  }

  public function setId($ide) {
    $this->id = $ide
  }

}
?>

