<?php
$srcFolder = "/home/victor/projects/ingSoftware/SIR/src/";
$classes = array("fachadasBD/FachadaBDPerfil.php"
                 );
foreach ($classes as $class)
  require_once($srcFolder.$class);
class Perfil {

  private $usrname;
  private $passwd;
  private $email;
  private $fechaNac;
  private $carnet;
  private $tipo;
  private $nombre;
  private $apellido;
  private $sexo;
  private $telefono;
  private $emailAlt;
  private $tweeter;
  private $ciudad;
  private $carrera;
  private $colegio;
  private $actividadesExtra;
  private $foto;
  private $trabajo;
  private $bio;
  private $seguridad_ID;
  private $muro_ID;
  private $esAdmin;
  private $isNew;
  private $estado;

  public function __construct() {
    if (func_num_args()==0) {
      $this->isNew = True;
    } else if (func_num_args()==1) {
      $args = func_get_args();
      $P = FachadaBDPerfil::getInstance();
      $att = $P -> buscarPerfil($args[0]);
      if ($att==false) {
        return null;
      } else {
        $this->usrname = $args[0];
        $this->passwd = $att["passwd"];
        $this->email = $att["email"];
        $this->fechaNac = $att["fechaNac"];
        $this->carnet = $att["carnet"];
        $this->tipo = $att["tipo"];
        $this->nombre = $att["nombre"];
        $this->apellido = $att["apellido"];
        $this->sexo = $att["sexo"];
        $this->telefono = $att["telefono"];
        $this->emailAlt = $att["emailAlt"];
        $this->tweeter = $att["tweeter"];
        $this->ciudad = $att["ciudad"];
        $this->carrera = $att["carrera"];
        $this->colegio = $att["colegio"];
        $this->actividadesExtra = $att["actividadesExtra"];
        $this->foto = $att["foto"];
        $this->trabajo = $att["trabajo"];
        $this->bio = $att["bio"];
        $this->seguridad_ID = $att["Seguridad_ID"];
        $this->muro_ID = $att["Muro_ID"];
        $this->esAdmin = $att["esAdmin"];
        $this->estado = $att["estado"];
        $this->isNew = False;
      }
    } else {
      return null;
    }
  }
  
  public function getUsrname(){
    return $this->usrname;
  }

  public function getPasswd(){
    return $this->passwd;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getFechaNac(){
    return $this->fechaNac;
  }

  public function getCarnet(){
    return $this->carnet;
  }

  public function getTipo(){
    return $this->tipo;
  }

  public function getNombre(){
    return $this->nombre;
  }

  public function getApellido(){
    return $this->apellido;
  }

  public function getSexo(){
    return $this->sexo;
  }

  public function getTelefono(){
    return $this->telefono;
  }

  public function getEmailAlt(){
    return $this->emailAlt;
  }

  public function getTweeter(){
    return $this->tweeter;
  }

  public function getCiudad(){
    return $this->ciudad;
  }

  public function getCarrera(){
    return $this->carrera;
  }

  public function getColegio(){
    return $this->colegio;
  }

  public function getActividadesExtra(){
    return $this->actividadesExtra;
  }

  public function getFoto(){
    return $this->foto;
  }

  public function getTrabajo(){
    return $this->trabajo;
  }

  public function getBio(){
    return $this->bio;
  }

  public function getSeguridad_ID(){
    return $this->seguridad_ID;
  }
  
  public function getMuro_ID(){
    return $this->muro_ID;
  }
  
  public function getEsAdmin(){
    return $this->esAdmin;
  }

  public function getIsNew(){
    return $this->isNew;
  }

  public function getEstado(){
    return $this->estado;
  }
  
  public function setUsrname($value){
    $this->usrname = $value;
  }

  public function setPasswd($value){
    $this->passwd = $value;
  }

  public function setEmail($value){
    $this->email = $value;
  }

  public function setFechaNac($value){
    $this->fechaNac = $value;
  }

  public function setCarnet($value){
    $this->carnet = $value;
  }

  public function setTipo($value){
    $this->tipo = $value;
  }

  public function setNombre($value){
    $this->nombre = $value;
  }

  public function setApellido($value){
    $this->apellido = $value;
  }

  public function setSexo($value){
    $this->sexo = $value;
  }

  public function setTelefono($value){
    $this->telefono = $value;
  }

  public function setEmailAlt($value){
    $this->emailAlt = $value;
  }

  public function setTweeter($value){
    $this->tweeter = $value;
  }

  public function setCiudad($value){
    $this->ciudad = $value;
  }

  public function setCarrera($value){
    $this->carrera = $value;
  }

  public function setColegio($value){
    $this->colegio = $value;
  }

  public function setActividadesExtra($value){
    $this->actividadesExtra = $value;
  }

  public function setFoto($value){
    $this->foto = $value;
  }

  public function setTrabajo($value){
    $this->trabajo = $value;
  }

  public function setBio($value){
    $this->bio = $value;
  }

  public function setSeguridad_ID($value){
    $this->seguridad_ID = $value;
  }
  
  public function setMuro_ID($value){
    $this->muro_ID = $value;
  }
  
  public function setEsAdmin($value){
    $this->esAdmin = $value;
  }

  public function setIsNew($value){
    $this->isNew = $value;
  }

  public function setEstado($value){
    $this->estado = $value;
  }

  public function setDatosPerfil($usrname,
                                 $passwd,
                                 $email,
                                 $fechaNac,
                                 $carnet,
                                 $tipo,
                                 $nombre,
                                 $apellido,
                                 $sexo,
                                 $telefono,
                                 $emailAlt,
                                 $tweeter,
                                 $ciudad,
                                 $carrera,
                                 $colegio,
                                 $actividadesExtra,
                                 $foto,
                                 $trabajo,
                                 $bio,
                                 $seguridad_ID,
                                 $muro_ID,
                                 $esAdmin = False,
                                 $isNew = False,
                                 $estado = "activo") {
    $this->usrname = $usrname;
    $this->passwd = $passwd;
    $this->email = $email;
    $this->fechaNac = $fechaNac;
    $this->carnet = $carnet;
    $this->tipo = $tipo;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->sexo = $sexo;
    $this->telefono = $telefono;
    $this->emailAlt = $emailAlt;
    $this->tweeter = $tweeter;
    $this->ciudad = $ciudad;
    $this->carrera = $carrera;
    $this->colegio = $colegio;
    $this->actividadesExtra = $actividadesExtra;
    $this->foto = $foto;
    $this->trabajo = $trabajo;
    $this->bio = $bio;
    $this->seguridad_ID = $seguridad_ID;
    $this->muro_ID = $muro_ID;
    $this->esAdmin = $esAdmin;
    $this->estado = $estado;
    $this->isNew = $isNew;
  }

  public function asArrayAssoc(){
    $perfil["usrname"] = $this->usrname;
    $perfil["passwd"] = $this->passwd;
    $perfil["email"] = $this->email;
    $perfil["fechaNac"] = $this->fechaNac;
    $perfil["carnet"] = $this->carnet;
    $perfil["tipo"] = $this->tipo;
    $perfil["nombre"] = $this->nombre;
    $perfil["apellido"] = $this->apellido;
    $perfil["sexo"] = $this->sexo;
    $perfil["telefono"] = $this->telefono;
    $perfil["emailAlt"] = $this->emailAlt;
    $perfil["tweeter"] = $this->tweeter;
    $perfil["ciudad"] = $this->ciudad;
    $perfil["carrera"] = $this->carrera;
    $perfil["colegio"] = $this->colegio;
    $perfil["actividadesExtra"] = $this->actividadesExtra;
    $perfil["foto"] = $this->foto;
    $perfil["trabajo"] = $this->trabajo;
    $perfil["bio"] = $this->bio;
    $perfil["seguridad_ID"] = $this->seguridad_ID;
    $perfil["muro_ID"] = $this->muro_ID;
    $perfil["esAdmin"] = $this->esAdmin;
    $perfil["isNew"] = $this->isNew;
    $perfil["estado"] = $this->estado;
    return $perfil;
  }
    
  public static function existe($value, $attr = "usrname") {
    $fachadaBD = FachadaBDPerfil::getInstance();
    if (strcmp($attr,"usrname") == 0) {
      if ($fachadaBD->existePerfil($value))
        return TRUE;
      return FALSE;
    } else if (strcmp($attr,"email") == 0) {
      if ($fachadaBD->existePerfil($value,"email"))
        return TRUE;
      return FALSE;
    }
  }

  public function save() {
    $P = FachadaBDPerfil::getInstance();
    return $P->salvarPerfil($this->asArrayAssoc());
  }
  
  public function toString(){
    $str = "Perfil:\n".
      "\tusrname = \"".(is_null($this->usrname) ? "NULL" : $this->usrname)."\"\n".
      "\tpasswd = \"".(is_null($this->passwd) ? "NULL" :$this->passwd)."\"\n".
      "\temail = \"".(is_null($this->email)? "NULL" : $this->email)."\"\n".
      "\tfechaNac = \"".(is_null($this->fechaNac)? "NULL" : $this->fechaNac)."\"\n".
      "\tcarnet = \"".(is_null($this->carnet)? "NULL" : $this->carnet)."\"\n".
      "\ttipo = \"".(is_null($this->tipo)? "NULL" : $this->tipo)."\"\n".
      "\tnombre = \"".(is_null($this->nombre)? "NULL" : $this->nombre)."\"\n".
      "\tapellido = \"".(is_null($this->apellido)? "NULL" : $this->apellido)."\"\n".
      "\tsexo = \"".(is_null($this->sexo)? "NULL" : $this->sexo)."\"\n".
      "\ttelefono = \"".(is_null($this->telefono)? "NULL" : $this->telefono)."\"\n".
      "\temailAlt = \"".(is_null($this->emailAlt)? "NULL" : $this->emailAlt)."\"\n".
      "\ttweeter = \"".(is_null($this->tweeter)? "NULL" : $this->tweeter)."\"\n".
      "\tciudad = \"".(is_null($this->ciudad)? "NULL" : $this->ciudad)."\"\n".
      "\tcarrera = \"".(is_null($this->carrera)? "NULL" : $this->carrera)."\"\n".
      "\tcolegio = \"".(is_null($this->colegio)? "NULL" : $this->colegio)."\"\n".
      "\tactividadesExtra = \"".(is_null($this->actividadesExtra)? "NULL" : $this->actividadesExtra)."\"\n".
      "\tfoto = \"".(is_null($this->foto)? "NULL" : $this->foto)."\"\n".
      "\ttrabajo = \"".(is_null($this->trabajo)? "NULL" : $this->trabajo)."\"\n".
      "\tbio = \"".(is_null($this->bio)? "NULL" : $this->bio)."\"\n".
      "\tseguridad_ID = \"".(is_null($this->seguridad_ID) ? "NULL" : $this->seguridad_ID)."\"\n".
      "\tmuro_ID = \"".(is_null($this->muro_ID)? "NULL" : $this->muro_ID)."\"\n".
      "\tesAdmin = \"".(is_null($this->esAdmin)? "NULL" : $this->esAdmin)."\"\n".
      "\testado = \"".(is_null($this->estado)? "NULL" : $this->estado)."\"\n".
      "\tisNew = \"".(is_null($this->isNew)? "NULL" : $this->isNew)."\"\n".
      "------------------------------------\n";
    return $str;
  }

}
?>