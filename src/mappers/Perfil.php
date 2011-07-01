<?php
require_once("../fachadasBD/FachadaBDPerfil.php");
class Perfil {

    private $username;
    private $password;
    private $email;   
    private $bdate;   
    private $secId;
    private $wallId;
    private $name;
    private $lastname;
    private $isAdmin;
    private $isNew;
    
     
    public function __construct() {
      if (func_num_args()==0){

	$this->isNew = True;

      }elseif(func_num_args()==1){

	$args = func_get_args();
       	$P = FachadaBDPerfil::getInstance();
	$att = $P -> buscarPerfil($args[0]);
	if ($att==false){
	  return null;
	}else{
	  $this->username = $args[0];
	  $this->password = att["password"];
	  $this->email = att["email"];
	  $this->bdate = att["fechaNacimiento"];
	  $this->secId = att["Seguridad_ID"];
	  $this->wallId = att["Muro_ID"];
	  $this->name = att["nombre"];
	  $this->lastname = att["apellido"];
	  $this->isAdmin = att["es_Admin"];
	  $this->isNew = False;
	} 
      }else{
	return null;
      }

    }

    public function existe() {
        $P = FachadaBDPerfil::getInstance();
        if ($P->existePerfil($this->username))
            return TRUE;
        return FALSE;
    }

    public function setDatosPerfil($password, $segId, $muroId, $nombre, $apellido, $correo, $fecha_nac, $isAdmin=false) {
        $this->password = $password;
	$this->secId = $secId;
	$this->wallId = $muroId;
	$this->isAdmin = $isAdmin;
        $this->name = $nombre;
        $this->lastname = $apellido;
        $this->email = $correo;
        $this->bdate = $fecha_nac;
    }

    public function save() {
        $P = FachadaBDPerfil::getInstance();
        if ($P->salvarPerfil($this))
            return TRUE;
        return FALSE;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getName() {
      return $this->name;
    }

    public function getApellido() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getFecha_nac() {
        return $this->bdate;
    }

    public function getbday() {
      return $this->bdate;
    }
    
    private function getisNew(){
      return $this->isNew;
    }

    private function getsecId(){
      return $this->secId;
    }
    
    private function gewallId(){
      return $this->wallId;
    }
   
    private function getisAdmin(){
      return $this->isAdmin;
    }

    private function setisNew($isnew){
      return $this->isNew = $isnew;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function setName($nombre) {
        $this->name = $nombre;
    }

    public function setApellido($apellido) {
        $this->lastname = $apellido;
    }

    public function setEmail($correo) {
        $this->email = $correo;
    }

    public function setFecha_nac($fecha_nac) {
        $this->bdate = $fecha_nac;
    }

    private function setsecId($secId){
      return $this->secId = $secId;
    }

    private function setwallId($wallId){
      return $this->isNew = $isnew;
    }
    
    private function setisAdmin($isAdmin){
      return $this->isAdmin = $isAdmin;
    }    
}

?>
