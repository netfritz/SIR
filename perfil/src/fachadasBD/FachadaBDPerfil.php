<?php
if (!isset($ajax) || !$ajax) {
  $srcFolder = $_SERVER['DOCUMENT_ROOT']."/rspinf-usb/perfil/src/";
  $classes = array("bd/DataBase.php",
                   "mappers/Perfil.php",
                   "excepciones/DatosInvalidosException.php"
                   );
  foreach ($classes as $class)
    require_once($srcFolder.$class);
}

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
    $existeUsrname = (isset($perfil["usrname"]) && !is_null($perfil["usrname"]));
    $existePasswd = (isset($perfil["passwd"]) && !is_null($perfil["passwd"]));
    $existeEmail = (isset($perfil["email"]) && !is_null($perfil["email"]));
    $existeFechaNac = (isset($perfil["fechaNac"]) && !is_null($perfil["fechaNac"]));
    $existeCarnet = (isset($perfil["carnet"]) && !is_null($perfil["carnet"]));
    $existeTipo = (isset($perfil["tipo"]) && !is_null($perfil["tipo"]));
    $existeNombre = (isset($perfil["nombre"]) && !is_null($perfil["nombre"]));
    $existeApellido = (isset($perfil["apellido"]) && !is_null($perfil["apellido"]));
    $existeSexo = (isset($perfil["sexo"]) && !is_null($perfil["sexo"]));
    $existeTelefono = (isset($perfil["telefono"]) && !is_null($perfil["telefono"]));
    $existeEmailAlt = (isset($perfil["emailAlt"]) && !is_null($perfil["emailAlt"]));
    $existeTweeter = (isset($perfil["tweeter"]) && !is_null($perfil["tweeter"]));
    $existeCiudad = (isset($perfil["ciudad"]) && !is_null($perfil["ciudad"]));
    $existeCarrera = (isset($perfil["carrera"]) && !is_null($perfil["carrera"]));
    $existeColegio = (isset($perfil["colegio"]) && !is_null($perfil["colegio"]));
    $existeActividadesExtra = (isset($perfil["actividadesExtra"]) && !is_null($perfil["actividadesExtra"]));
    $existeFoto = (isset($perfil["foto"]) && !is_null($perfil["foto"]));
    $existeTrabajo = (isset($perfil["trabajo"]) && !is_null($perfil["trabajo"]));
    $existeBio = (isset($perfil["bio"]) && !is_null($perfil["bio"]));
    $existeSeguridadId = (isset($perfil["seguridadId"]) && !is_null($perfil["seguridadId"]));
    $existeMuroId = (isset($perfil["muroId"]) && !is_null($perfil["muroId"]));
    $existeEsAdmin = (isset($perfil["esAdmin"]) && !is_null($perfil["esAdmin"]));
    $existeNombreFoto = (isset($perfil["nombreFoto"]) && !is_null($perfil["nombreFoto"]));
    $existeTamFoto = (isset($perfil["tamFoto"]) && !is_null($perfil["tamFoto"]));
    $existeFormatoFoto = (isset($perfil["formatoFoto"]) && !is_null($perfil["formatoFoto"]));
    $existeEstado = (isset($perfil["estado"]) && !is_null($perfil["estado"]));
    $existeIsNew = (isset($perfil["isNew"]) && !is_null($perfil["isNew"]));

    $usrname = (!$existeUsrname ? "NULL" : "'".mysql_real_escape_string($perfil["usrname"])."'");
    $passwd = (!$existePasswd ? "NULL" : "'".mysql_real_escape_string($perfil["passwd"])."'");
    $email = (!$existeEmail ? "NULL" : "'".mysql_real_escape_string($perfil["email"])."'");
    $fechaNac =(!$existeFechaNac ? "NULL" : "'".mysql_real_escape_string($perfil["fechaNac"])."'");
    $carnet = (!$existePasswd ? "00-00000" : "'".mysql_real_escape_string($perfil["carnet"])."'");
    $tipo = (!$existeTipo ? "NULL" : "'".mysql_real_escape_string($perfil["tipo"])."'");
    $nombre =(!$existeNombre ? "NULL" : "'".mysql_real_escape_string($perfil["nombre"])."'");
    $apellido =(!$existeApellido ? "NULL" : "'".mysql_real_escape_string($perfil["apellido"])."'");
    $sexo = (!$existeSexo ? "NULL" : "'".mysql_real_escape_string($perfil["sexo"])."'");
    $telefono =(!$existeTelefono ? "NULL" : "'".mysql_real_escape_string($perfil["telefono"])."'");
    $emailAlt =(!$existeEmailAlt ? "NULL" : "'".mysql_real_escape_string($perfil["emailAlt"])."'");
    $tweeter =(!$existeTweeter ? "NULL" : "'".mysql_real_escape_string($perfil["tweeter"])."'");
    $ciudad = (!$existeCiudad ? "NULL" : "'".mysql_real_escape_string($perfil["ciudad"])."'");
    $carrera =(!$existeCarrera ? "NULL" : "'".mysql_real_escape_string($perfil["carrera"])."'");
    $colegio =(!$existeColegio ? "NULL" : "'".mysql_real_escape_string($perfil["colegio"])."'");
    $actividadesExtra = (!$existeActividadesExtra ? "NULL" : "'".mysql_real_escape_string($perfil["actividadesExtra"])."'");
    $foto = (!$existeFoto ? "NULL" : "'".mysql_real_escape_string($perfil["foto"])."'");
    $trabajo = (!$existeTrabajo ? "NULL" : "'".mysql_real_escape_string($perfil["trabajo"])."'");
    $bio = (!$existeBio ? "NULL" : "'".mysql_real_escape_string($perfil["bio"])."'");
    $seguridadId =(!$existeSeguridadId ? "NULL" : "'".mysql_real_escape_string($perfil["seguridadId"])."'");
    $muroId = (!$existeMuroId ? "NULL" : "'".mysql_real_escape_string($perfil["muroId"])."'");
    $esAdmin = (!$existeEsAdmin ? "NULL" : "'".mysql_real_escape_string($perfil["esAdmin"])."'");
    $nombreFoto = (!$existeNombreFoto ? "NULL" : "'".mysql_real_escape_string($perfil["esAdmin"])."'");
    $tamFoto = (!$existeTamFoto ? "NULL" : "'".mysql_real_escape_string($perfil["esAdmin"])."'");
    $formatoFoto = (!$existeFormatoFoto ? "NULL" : "'".mysql_real_escape_string($perfil["esAdmin"])."'");


    if (!$existeFoto) {
      $foto = $nombreFoto = $tamFoto = $formatoFoto = "NULL";
    } else {
      $foto = "'".$perfil["foto"]."'";
      $nombreFoto = "'".$perfil["nombreFoto"]."'";
      $tamFoto = "'".$perfil["tamFoto"]."'";
      $formatoFoto = "'".$perfil["formatoFoto"]."'";
    }

    if ($existeEstado) {
      $estado = (is_null($perfil["estado"]) ? "activo" : "'".mysql_real_escape_string($perfil["estado"])."'");
    } else {
      $estado = "activo";
    }

    if($perfil["isNew"]){
      $sqlQuery = "INSERT INTO Perfil (".
        "usrname, passwd, email, fechaNac, carnet, tipo, nombre, apellido, ".
        "sexo, telefono, emailAlt, tweeter, ciudad, carrera, colegio, ".
        "actividadesExtra, foto, trabajo, bio, seguridadId, muroId, esAdmin, ".
        "estado, nombreFoto, tamFoto, formatoFoto".
        ") VALUES (".
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
        $seguridadId.",".
        $muroId.",".
        $esAdmin.",".
        $estado.",".
        $nombreFoto.",".
        $tamFoto.",".
        $formatoFoto.
        ")";
    } else {
      $sqlQuery = "UPDATE Perfil SET ";
      $sqlQuery .= ($existeUsrname ? "usrname = ".$usrname : "");
      $sqlQuery .= ($existePasswd ? ", passwd = ".$passwd : "");
      $sqlQuery .= ($existeEmail ? ", email = ".$email : "");
      $sqlQuery .= ($existeFechaNac ? ", fechaNac = ".$fechaNac : "");
      $sqlQuery .= ($existeCarnet ? ", carnet = ".$carnet : "");
      $sqlQuery .= ($existeTipo ? ", tipo = ".$tipo : "");
      $sqlQuery .= ($existeNombre ? ", nombre = ".$nombre : "");
      $sqlQuery .= ($existeApellido ? ", apellido = ".$apellido : "");
      $sqlQuery .= ($existeSexo ? ", sexo = ".$sexo : "");
      $sqlQuery .= ($existeTelefono ? ", telefono = ".$telefono : "");
      $sqlQuery .= ($existeEmailAlt ? ", emailAlt = ".$emailAlt : "");
      $sqlQuery .= ($existeTweeter ? ", tweeter = ".$tweeter : "");
      $sqlQuery .= ($existeCiudad ? ", ciudad = ".$ciudad : "");
      $sqlQuery .= ($existeCarrera ? ", carrera = ".$carrera : "");
      $sqlQuery .= ($existeColegio ? ", colegio = ".$colegio : "");
      $sqlQuery .= ($existeActividadesExtra ? ", actividadesExtra = ".$actividadesExtra : "");
      $sqlQuery .= ($existeFoto ? ", foto = ".$foto : "");
      $sqlQuery .= ($existeTrabajo ? ", trabajo = ".$trabajo : "");
      $sqlQuery .= ($existeBio ? ", bio = ".$bio : "");
      $sqlQuery .= ($existeEstado ? ", estado = ".$estado : "");
      $sqlQuery .= ($existeFoto && $existeNombreFoto ? ", nombreFoto = ".$nombreFoto : "");
      $sqlQuery .= ($existeFoto && $existeTamFoto ? ", tamFoto = ".$tamFoto : "");
      $sqlQuery .= ($existeFoto && $existeFormatoFoto ? "formatoFoto = ".$formatoFoto : "");
      $sqlQuery .= "WHERE usrname = ".$usrname;
    }
    $queryResult = mysql_query($sqlQuery);
    //echo "<p>Query:<br/>".$sqlQuery."<br/>Error:<br>".mysql_error()."</p>";
    if (!$queryResult) {
      throw new DatosInvalidosException("Problema al salvar el perfil con usrname (".$usrname."): ".mysql_error()."");
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
