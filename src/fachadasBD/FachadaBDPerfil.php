<?php

require_once 'DataBase.php';
require_once 'Perfil.php';

//Utiliza el patron Singleton
class FachadaBDPerfil {

    private static $instance;

    private function __construct() {
        
    }

    public static function getInstance() { //metodo Singleton
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    public function buscarPerfil($user) {
        DataBase::singleton(); //Conexion a BD establecida.
        $sqlQuery = "SELECT user FROM Pinf.Perfil WHERE user = '$user'";
        $queryResult = mysql_query($sqlQuery);
        if (!$queryResult) {
            $row = false;
        }elseif (mysql_num_rows()<=0){
	  $row = false;
	}else{ 
	  $row = mysql_fetch_assoc($queryResult);
	}
        return $row;
        
    }

    public function existePerfil($user) {
        DataBase::singleton(); //Conexion a BD establecida.
        $sqlQuery = "SELECT user FROM Pinf.Perfil WHERE user = '$user'";
        $queryResult = mysql_query($sqlQuery);
        if (!$queryResult) {
            die("ERROR: PerfilMapper.existePerfil(): " . mysql_error());
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
        $att["user"] = $perfil->getUsername();
        $att["pswd"] = $perfil->getPassword();
	$att["mail"] = $perfil->getEmail();        
	$att["fechaN"] = $perfil->getFecha_nac();
	$att["secId"] = $perfil->getsecId();
	$att["wallId"] = $perfil->getwallId();
	$att["name"] = $perfil->getName();
        $att["lastname"] = $perfil->getApellido();
	$att["isAdmin"] = $perfil->getisNew();
        
       

        $sqlQuery = "INSERT INTO Pinf.Perfil VALUES " .
                "('$att[user]', '$att[pswd]', '$att[mail]', '$att[fechaN]', '$att[secId]','att[wallId]','$att[name]', '$att[lastname]', 'att[isAdmin]') ";
        $queryResult = mysql_query($sqlQuery);
        return $queryResult;
    }

}

?>
