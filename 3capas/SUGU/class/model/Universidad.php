<?php

include("DataBase.php");

class Universidad{

  private $id; 
  public $nombre;
  private $pais;
  private $estado;
  private $ciudad;
  private $direccion;
  private $rector;
  private $url;
  private $nueva= FALSE;

  public function __construct($nombre,$pais,$estado,$ciudad,$direccion,$rector,$url) {
    $this->nombre= mysql_real_escape_string(stripslashes($nombre)); 
    $this->pais=  mysql_real_escape_string(stripslashes($pais));
    $this->estado= mysql_real_escape_string(stripslashes($estado));
    $this->ciudad= mysql_real_escape_string(stripslashes($ciudad));
    $this->direccion= mysql_real_escape_string(stripslashes($direccion));
    $this->rector= mysql_real_escape_string(stripslashes($rector));
    $this->url= mysql_real_escape_string(stripslashes($url));
    $this->nueva=TRUE;
  }

  public static function all(){
    DataBase::singleton();
    $query=mysql_query("SELECT * FROM Universidad;");
    if($query){
      if (mysql_num_rows($query) > 0) {
        while($tupla=mysql_fetch_assoc($query)){
          $univ=new Universidad($tupla["nombre"],$tupla["pais"],$tupla["estado"],$tupla["ciudad"],$tupla["direccion"],$tupla["rector"],$tupla["url"]);
          $all[]=$univ;
          $univ->nueva= FALSE;
        }
        return $all;
      }else{
        return null;
      }
    }else{
      return null;
    }
   
  }

  public static function getByKey($key) {
    DataBase::singleton();
    $key= mysql_real_escape_string(stripslashes($key));
    $result=mysql_query("SELECT * FROM Universidad WHERE nombre='" .$key."'");
    $tupla=mysql_fetch_assoc($result);
    if(!$tupla){
      return null;
    }else{
     
      $univ= new Universidad($tupla["nombre"],$tupla["pais"],$tupla["estado"],$tupla["ciudad"],$tupla["direccion"],$tupla["rector"],$tupla["url"]);
      $univ->nueva=FALSE;
      return $univ;
    }

  }

  public function save() {
    DataBase::singleton();
    if ($this->nueva) {
      $ins = mysql_query("INSERT INTO Universidad
           (nombre,pais,estado,ciudad,direccion,rector,url) VALUES
          ('" . $this->nombre ."','" .$this->pais. "',
 		   '" . $this->estado . "','" .$this->ciudad."',
           '" . $this->direccion . "','" .$this->rector ."',
           '" . $this->url ."');");
    } else {
      $ins = mysql_query("UPDATE Universidad SET
                         pais='".$this->pais
                         ."', estado='".$this->estado
                         ."', ciudad='".$this->ciudad
                         ."', direccion='".$this->direccion
                         ."', rector='".$this->rector
                         ."', url='".$this->url
                         ."' WHERE nombre='".$this->nombre."';");
    }

    $this->nueva = False;
  }
  public function delete() {
    DataBase::singleton();
    $del = mysql_query("DELETE FROM Universidad WHERE nombre='".$this->nombre."';");
    $this->nueva=TRUE;
  }

  public function __toString() {
    $cadena = $this->nombre;
    $cadena.= "," .$this->pais .",". $this->estado;
    $cadena.= "," .$this->ciudad .",". $this->direccion;
    $cadena.= "," .$this->rector .",". $this->url;
    return($cadena);
  }

  // Funciones para obtener los valores de los atributos

  public function getNombre(){
    return $this->nombre;
  }
  public function getPais(){
    return $this->pais;
  }
  public function getEstado(){
    return $this->estado;
  }
  public function getCiudad(){
    return $this->ciudad;
  }
  public function getDireccion(){
    return $this->direccion;
  }
  public function getRector(){
    return $this->rector;
  }
  public function getUrl(){
    return $this->url;
  }

  // Funciones para modificar los valores de los atributos

  public function setPais($pais){
    $this->pais=mysql_real_escape_string(stripslashes($pais));
  }
  public function setEstado($estado){
    $this->estado=mysql_real_escape_string(stripslashes($estado));
  }
  public function setCiudad($ciudad){
    $this->ciudad=mysql_real_escape_string(stripslashes($ciudad));
  }
  public function setDireccion($direccion){
    $this->direccion=mysql_real_escape_string(stripslashes($direccion));
  }
  public function setRector($rector){
    $this->rector=mysql_real_escape_string(stripslashes($rector));
  }
  public function setUrl($url){
    $this->url=mysql_real_escape_string(stripslashes($url));
  }
}

?>
