<?php
$srcFolder = "/home/victor/projects/ingSoftware/SIR/src/";
$classes = array("bd/DataBase.php",
                 "mappers/Perfil.php"
                 );
foreach ($classes as $class)
  require_once($srcFolder.$class);


//Utiliza el patron Singleton
class FachadaBDPerfil {

  private static $instance;   // Representa la unica instancia de esta clase

  public function buscarPerfil($user) {
    DataBase::singleton(); //Conexion a BD establecida.
    $sqlQuery = "SELECT * FROM Perfil WHERE usrname = '".$user."'";
    $queryResult = mysql_query($sqlQuery);
    if (!$queryResult) {
      $row = false;
    }elseif (mysql_num_rows($queryResult)!=1){
      $row = false;
    }else{
      $row = mysql_fetch_assoc($queryResult);
    }
    return $row;

  }

  public function existePerfil($value, $attr = "usrname") {
    DataBase::singleton(); //Conexion a BD establecida.
    if (strcmp($attr,"usrname") == 0) {
      $sqlQuery = "SELECT usrname FROM Perfil WHERE usrname = '".mysql_real_escape_string($value)."'";
    } else if (strcmp($attr,"email") == 0) {
      $sqlQuery = "SELECT usrname FROM Perfil WHERE email = '".mysql_real_escape_string($value)."'";
    }

    $queryResult = mysql_query($sqlQuery);
    if (!$queryResult) {
      die("ERROR: FachadaBDPerfil.existePerfil(): " . mysql_error());
    }
    $row = mysql_fetch_assoc($queryResult);
    if (!($row)) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function salvarPerfil($perfil) {
    DataBase::singleton();

    if($perfil["isNew"]){
      $sqlQuery = "INSERT INTO Perfil VALUES ('".mysql_real_escape_string($perfil["usrname"])."', '"
                                                .mysql_real_escape_string($perfil["passwd"])."', '"
                                                .mysql_real_escape_string($perfil["email"])."', '"
                                                .mysql_real_escape_string($perfil["fechaNac"])."', '"
                                                .mysql_real_escape_string($perfil["carnet"])."', '"
                                                .mysql_real_escape_string($perfil["tipo"])."', '"
                                                .mysql_real_escape_string($perfil["nombre"])."', '"
                                                .mysql_real_escape_string($perfil["apellido"])."', '"
                                                .mysql_real_escape_string($perfil["sexo"])."', '"
                                                .mysql_real_escape_string($perfil["telefono"])."', '"
                                                .mysql_real_escape_string($perfil["emailAlt"])."', '"
                                                .mysql_real_escape_string($perfil["tweeter"])."', '"
                                                .mysql_real_escape_string($perfil["ciudad"])."', '"
                                                .mysql_real_escape_string($perfil["carrera"])."', '"
                                                .mysql_real_escape_string($perfil["colegio"])."', '"
                                                .mysql_real_escape_string($perfil["actividadesExtra"])."', '"
                                                .mysql_real_escape_string($perfil["foto"])."', '"
                                                .mysql_real_escape_string($perfil["trabajo"])."', '"
                                                .mysql_real_escape_string($perfil["bio"])."', '"
                                                .mysql_real_escape_string($perfil["seguridad_ID"])."', '"
                                                .mysql_real_escape_string($perfil["muro_ID"])."', '"
                                                .mysql_real_escape_string($perfil["esAdmin"])."')";
    } else {
      $sqlQuery = "UPDATE Perfil SET ".
                                     "usrname = '".mysql_real_escape_string($perfil["usrname"])."',".
                                     "passwd = '".mysql_real_escape_string($perfil["passwd"])."',".
                                     "email = '".mysql_real_escape_string($perfil["email"])."',".
                                     "fechaNac = '".mysql_real_escape_string($perfil["fechaNac"])."',".
                                     "carnet = '".mysql_real_escape_string($perfil["carnet"])."',".
                                     "tipo = '".mysql_real_escape_string($perfil["tipo"])."',".
                                     "nombre = '".mysql_real_escape_string($perfil["nombre"])."',".
                                     "apellido = '".mysql_real_escape_string($perfil["apellido"])."',".
                                     "sexo = '".mysql_real_escape_string($perfil["sexo"])."',".
                                     "telefono = '".mysql_real_escape_string($perfil["telefono"])."',".
                                     "emailAlt = '".mysql_real_escape_string($perfil["emailAlt"])."',".
                                     "tweeter = '".mysql_real_escape_string($perfil["tweeter"])."',".
                                     "ciudad = '".mysql_real_escape_string($perfil["ciudad"])."',".
                                     "carrera = '".mysql_real_escape_string($perfil["carrera"])."',".
                                     "colegio = '".mysql_real_escape_string($perfil["colegio"])."',".
                                     "actividadesExtra = '".mysql_real_escape_string($perfil["actividadesExtra"])."',".
                                     "foto = '".mysql_real_escape_string($perfil["foto"])."',".
                                     "trabajo = '".mysql_real_escape_string($perfil["trabajo"])."',".
                                     "bio = '".mysql_real_escape_string($perfil["bio"])."',".
                                     "Seguridad_ID = '".mysql_real_escape_string($perfil["seguridad_ID"])."',".
                                     "Muro_ID = '".mysql_real_escape_string($perfil["muro_ID"])."',".
                                     "esAdmin = '".mysql_real_escape_string($perfil["esAdmin"])."'".
                  "WHERE usrname = '".mysql_real_escape_string($perfil["usrname"])."'";
    }
    $queryResult = mysql_query($sqlQuery);
    if (!$queryResult) {
      $errors[] = mysql_error();
      return $errors;
    }
    return $queryResult;
  }

  //#####################################################################//
  //                        Inicio del Singleton                         //
  //#####################################################################//

  private function __construct() {

  }

  public static function getInstance() { //metodo Singleton
    if (!isset(self::$instance)) {
      $c = __CLASS__;
      self::$instance = new $c;
    }
    return self::$instance;
  }

}

?>
