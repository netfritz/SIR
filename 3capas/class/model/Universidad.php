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
    $this->nombre= $nombre; 
    $this->pais= $pais;
    $this->estado=$estado;
    $this->ciudad=$ciudad;
    $this->direccion=$direccion;
    $this->rector=$rector;
    $this->url=$url;
    $this->nueva=TRUE;
  }

  public static function all(){
    DataBase::singleton();
    $query=mysql_query("SELECT * FROM Universidad;");
    if($query){
      while($tupla=mysql_fetch_assoc($query)){
        $univ=new Universidad($tupla["nombre"],$tupla["pais"],$tupla["estado"],$tupla["ciudad"],$tupla["direccion"],$tupla["rector"],$tupla["url"]);
        $all[]=$univ;
        $univ->nueva= FALSE;
      }
    }else{
      return null;
    }
    return $all;
  }

  public static function getByKey($key) {
    DataBase::singleton();

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
    $this->pais=$pais;
  }
  public function setEstado($estado){
    $this->estado=$estado;
  }
  public function setCiudad($ciudad){
    $this->ciudad=$ciudad;
  }
  public function setDireccion($direccion){
    $this->direccion=$direccion;
  }
  public function setRector($rector){
    $this->rector=$rector;
  }
  public function setUrl($url){
    $this->url=$url;
  }
}

?>
