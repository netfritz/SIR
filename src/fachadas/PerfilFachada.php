<?php
$srcFolder = "/home/victor/projects/ingSoftware/SIR/src/";
$classes = array("mappers/Perfil.php",
                 "fabricas/PerfilFactory.php"
                 );
foreach ($classes as $class)
  require_once($srcFolder.$class);


class PerfilFachada {
  private static $instance; // Representa la unica instancia de esta clase

  public function perfilValidator($data){
    return NULL;
  }

  public function editPerfil($data) {
    $errors = $this->perfilValidator($data);
    if (is_null($errors)) {
      $fabrica = PerfilFactory::getInstance();
      $perfil = $fabrica->getPerfil($data["usrname"]);
      if (is_null($perfil)) {
        $errors[] = "error!";
        return $errors;
      }
      // Seteo los nuevos atributos:
      $perfil->setDatosPerfil($data["passwd"],
                              NULL,
                              NULL,
                              $data["name"],
                              $data["lastname"],
                              $data["email"],
                              $data["bdate"]);
      return $perfil->save();
    } else {
      return $errors;
    }
  }

  public function getPerfil($usrname) {
    $fabrica = PerfilFactory::getInstance();
    $perfil = $fabrica->getPerfil($usrname);
    if (is_null($perfil)) {
      return NULL;
    } else {
      $data["usrname"] = $perfil->getUsername();
      $data["email"] = $perfil->getEmail();
      $data["name"] = $perfil->getName();
      $data["lastname"] = $perfil->getApellido();
      $data["bdate"] = $perfil->getFecha_nac();
      return $data;
    }
  }

  public function createPerfil($date) {
    $errors = $this->perfilValidator($data);
    if (is_null($errors)) {
      $fabrica = PerfilFactory::getInstance();
      $perfil = $fabrica->getPerfil($data["usrname"]);
      if (is_null($perfil)) {
        $errors[] = "error!";
        return $errors;
      }
      // Seteo los nuevos atributos:
      $perfil->setUsername($data["usrname"]);
      $perfil->setDatosPerfil($data["passwd"],
                              NULL,
                              NULL,
                              $data["name"],
                              $data["lastname"],
                              $data["email"],
                              $data["bdate"]);
      return $perfil->save();
    } else {
      return $errors;
    }
  }

  public function exists($value,$attr="usrname"){
    if (strcmp($attr,"usrname") == 0) {
      return Perfil::existe($value);
    } else if (strcmp($attr,"email") == 0) {
      return Perfil::existe($value,"email");
    }
  }

  //#####################################################################//
  //                        Inicio del Singleton                         //
  //#####################################################################//
  
  /**
   * Para evitar que instancien esta clase, se crea un constructor privado
   * (Tomado del manual de php:
   *             http://php.net/manual/en/language.oop5.patterns.php)
   */
  private function __construct() {

  }

  /**
   * Evita que los usuarios clonen el objeto
   * (Tomado del manual de php:
   *             http://php.net/manual/en/language.oop5.patterns.php)
   */
  public function __clone(){
    trigger_error('No se permite la clonación de este objeto.', E_USER_ERROR);
  }

  /**
   * Método que garantiza que sólo habrá una instancia de esta clase, con los 
   * dos métodos anteriores junto con este, se crea un "Singleton Pattern" 
   * con lo cual emulamos lo que sería una clase estática (lo que en java 
   * hacemos con "public static class blah {}").
   * (Tomado del manual de php:
   *             http://php.net/manual/en/language.oop5.patterns.php)
   */
  public static function singleton() {
    if (!isset(self::$instance)) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

  //#####################################################################//
  //                          Fin del Singleton                          //
  //                       Inicio Logica de Negocios                     //
  //#####################################################################//
}
?>