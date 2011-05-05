<html>
<head>
<tittle> <Center>Universidad <br> </Center> </tittle>
</head>

<body>

<?php

include("/home/jennifer/SIR/DataBase.php");

class Universidad{

private $id; 
private $nombre;
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
}

public static function all(){
DataBase::singleton();
$tabla= array("hola","hola2");
return $tabla;
}

 public static function getByKey($key) {}
 public function save() {}
public function delete() {}
public function toString() {}

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
public function setNombre(){
return $this->nombre;
}
public function setPais(){
return $this->pais;
}
public function setEstado(){
return $this->estado;
}
public function setCiudad(){
return $this->ciudad;
}
public function setDireccion(){
return $this->direccion;
}
public function setRector(){
return $this->rector;
}
public function setUrl(){
return $this->url;
}

public function insertarNombre(){}
public function insertarPais(){}
public function insertarEstado(){}
public function insertarCiudad(){}
public function insertarDireccion(){}
public function insertarRector(){}
public function insertarUrl(){}

public function modificarID(){}
public function modificarNombre(){}
public function modificarPais(){}
public function modificarEstado(){}
public function modificarCiudad(){}
public function modificarDireccion(){}
public function modificarRector(){}
public function modificarUrl(){}

public function eliminarRegistro(){} // No se si este sea un metodo..

public function buscarPorNombre(){}
public function buscarPorPais(){}
public function buscarPorEstado(){}
public function buscarPorCiudad(){}
public function buscarPorDireccion(){}
public function buscarPorRector(){}
public function buscarPorUrl(){}

}

$universidad= new Universidad("Universidad Simon Bolivar","Venezuela","Miranda","Sartenejas","un lugar","Planchart", "algo largo");

$tupla= $universidad->all();
echo $tupla;
?>
</body>
</html>
