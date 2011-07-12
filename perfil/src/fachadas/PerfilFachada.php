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
        $errors[] = "PerfilFachada.editPerfil(): error instanciando el perfil!";
        return $errors;
      }
      // Seteo los nuevos atributos:
      $perfil->setDatosPerfil($data["usrname"],
                              $data["passwd"],
                              $data["email"],
                              $data["fechaNac"],
                              $data["carnet"],
                              $data["tipo"],
                              $data["nombre"],
                              $data["apellido"],
                              $data["sexo"],
                              $data["telefono"],
                              $data["emailAlt"],
                              $data["tweeter"],
                              $data["ciudad"],
                              $data["carrera"],
                              $data["colegio"],
                              $data["actividadesExtra"],
                              $data["foto"],
                              $data["trabajo"],
                              $data["bio"],
                              $data["seguridad_ID"],
                              $data["muro_ID"],
                              False,
                              False
                              );

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
    } else {;
      $answer = $perfil->asArrayAssoc();
      return $perfil->asArrayAssoc();
    }
  }

  public function createPerfil($data) {
    $errors = $this->perfilValidator($data);
    if (is_null($errors)) {
      $perfil = new Perfil();
      if (is_null($perfil)) {
        $errors[] = "PerfilFachada.editPerfil(): error creando el Perfil!";
        return $errors;
      }
      // Seteo los nuevos atributos:
      $perfil->setDatosPerfil($data["usrname"],
                              $data["passwd"],
                              $data["email"],
                              $data["fechaNac"],
                              $data["carnet"],
                              $data["tipo"],
                              $data["nombre"],
                              $data["apellido"],
                              $data["sexo"],
                              $data["telefono"],
                              $data["emailAlt"],
                              $data["tweeter"],
                              $data["ciudad"],
                              $data["carrera"],
                              $data["colegio"],
                              $data["actividadesExtra"],
                              $data["foto"],
                              $data["trabajo"],
                              $data["bio"],
                              $data["seguridad_ID"],
                              $data["muro_ID"],
                              False,
                              True
                              );
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