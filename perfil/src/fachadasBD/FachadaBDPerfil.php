<?php
/*    $usrname = ;
    $passwd = ;
    $email = ;
    $fechaNac = ;
    $carnet = ;
    $tipo = ;
    $nombre = ;
    $apellido = ;
    $sexo = ;
    $telefono = ;
    $emailAlt = ;
    $tweeter = ;
    $ciudad = ;
    $carrera = ;
    $colegio = ;
    $actividadesExtra = ;
    $foto = ;
    $trabajo = ;
    $bio = ;
    $seguridad_ID = ;
    $muro_ID = ;
    $esAdmin = ;*/
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
    DataBase::getInstance(); //Conexion a BD establecida.
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
    DataBase::getInstance(); //Conexion a BD establecida.
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
    DataBase::getInstance();


    $usrname = (is_null($perfil["usrname"]) ? "NULL" : "'".mysql_real_escape_string($perfil["usrname"])."'");
    $passwd = (is_null($perfil["passwd"]) ? "NULL" : "'".mysql_real_escape_string($perfil["passwd"])."'");
    $email = (is_null($perfil["email"]) ? "NULL" : "'".mysql_real_escape_string($perfil["email"])."'");
    $fechaNac =(is_null($perfil["fechaNac"]) ? "NULL" : "'".mysql_real_escape_string($perfil["fechaNac"])."'");
    $carnet = (is_null($perfil["carnet"]) ? "00-00000" : "'".mysql_real_escape_string($perfil["carnet"])."'");
    $tipo = (is_null($perfil["tipo"]) ? "NULL" : "'".mysql_real_escape_string($perfil["tipo"])."'");
    $nombre =(is_null($perfil["nombre"]) ? "NULL" : "'".mysql_real_escape_string($perfil["nombre"])."'");
    $apellido =(is_null($perfil["apellido"]) ? "NULL" : "'".mysql_real_escape_string($perfil["apellido"])."'");
    $sexo = (is_null($perfil["sexo"]) ? "NULL" : "'".mysql_real_escape_string($perfil["sexo"])."'");
    $telefono =(is_null($perfil["telefono"]) ? "NULL" : "'".mysql_real_escape_string($perfil["telefono"])."'");
    $emailAlt =(is_null($perfil["emailAlt"]) ? "NULL" : "'".mysql_real_escape_string($perfil["emailAlt"])."'");
    $tweeter =(is_null($perfil["tweeter"]) ? "NULL" : "'".mysql_real_escape_string($perfil["tweeter"])."'");
    $ciudad = (is_null($perfil["ciudad"]) ? "NULL" : "'".mysql_real_escape_string($perfil["ciudad"])."'");
    $carrera =(is_null($perfil["carrera"]) ? "NULL" : "'".mysql_real_escape_string($perfil["carrera"])."'");
    $colegio =(is_null($perfil["colegio"]) ? "NULL" : "'".mysql_real_escape_string($perfil["colegio"])."'");
    $actividadesExtra = (is_null($perfil["actividadesExtra"]) ? "NULL" : "'".mysql_real_escape_string($perfil["actividadesExtra"])."'");
    $foto = (is_null($perfil["foto"]) ? "NULL" : "'".mysql_real_escape_string($perfil["foto"])."'");
    $trabajo = (is_null($perfil["trabajo"]) ? "NULL" : "'".mysql_real_escape_string($perfil["trabajo"])."'");
    $bio = (is_null($perfil["bio"]) ? "NULL" : "'".mysql_real_escape_string($perfil["bio"])."'");
    $seguridad_ID =(is_null($perfil["seguridad_ID"]) ? "NULL" : "'".mysql_real_escape_string($perfil["seguridad_ID"])."'");
    $muro_ID = (is_null($perfil["muro_ID"]) ? "NULL" : "'".mysql_real_escape_string($perfil["muro_ID"])."'");
    $esAdmin = (is_null($perfil["esAdmin"]) ? "NULL" : "'".mysql_real_escape_string($perfil["esAdmin"])."'");
    if (isset($perfil["estado"])) {
      $estado = (is_null($perfil["estado"]) ? "activo" : "'".mysql_real_escape_string($perfil["estado"])."'");
    } else {
      $estado = "activo";
    }

    if($perfil["isNew"]){
      $sqlQuery = "INSERT INTO Perfil VALUES (".
                                               $usrname.",".
                                               $passwd.",".
                                               $email.",".
                                               $fechaNac.",".
                                               $carnet.",".
                                               $tipo.",".
                                               $nombre.",".
                                               $apellido.",".
                                               $sexo.",".
                                               $telefono.",".
                                               $emailAlt.",".
                                               $tweeter.",".
                                               $ciudad.",".
                                               $carrera.",".
                                               $colegio.",".
                                               $actividadesExtra.",".
                                               $foto.",".
                                               $trabajo.",".
                                               $bio.",".
                                               $seguridad_ID.",".
                                               $muro_ID.",".
                                               $esAdmin.",".
                                               $estado.
                                            ")";
    } else {
      $sqlQuery = "UPDATE Perfil SET ".
                                     "usrname = ".$usrname.",".
                                     "passwd = ".$passwd.",".
                                     "email = ".$email.",".
                                     "fechaNac = ".$fechaNac.",".
                                     "carnet = ".$carnet.",".
                                     "tipo = ".$tipo.",".
                                     "nombre = ".$nombre.",".
                                     "apellido = ".$apellido.",".
                                     "sexo = ".$sexo.",".
                                     "telefono = ".$telefono.",".
                                     "emailAlt = ".$emailAlt.",".
                                     "tweeter = ".$tweeter.",".
                                     "ciudad = ".$ciudad.",".
                                     "carrera = ".$carrera.",".
                                     "colegio = ".$colegio.",".
                                     "actividadesExtra = ".$actividadesExtra.",".
                                     "foto = ".$foto.",".
                                     "trabajo = ".$trabajo.",".
                                     "bio = ".$bio.",".
                                     "Seguridad_ID = ".$seguridad_ID.",".
                                     "Muro_ID = ".$muro_ID.",".
                                     "esAdmin = ".$esAdmin.
                                     "estado = ".$estado.
                  "WHERE usrname = ".$usrname;
    }
    $queryResult = mysql_query($sqlQuery);
    echo "<p>Query:<br/>".$sqlQuery."<br/>Error:<br>".mysql_error()."</p>";
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
