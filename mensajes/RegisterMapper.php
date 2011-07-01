<?php

require_once 'DataBase.php';
require_once 'Perfil.php';

//Utiliza el patron Singleton
class PerfilMapper {

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
        $att["nom"] = $perfil->getNombre();
        $att["ape"] = $perfil->getApellido();
        $att["mail"] = $perfil->getCorreo();
        $att["fechaN"] = $perfil->getFecha_nac();

        $sqlQuery = "INSERT INTO Pinf.Perfil VALUES " .
                "('$att[user]', '$att[pswd]', '$att[nom]', '$att[ape]', " .
                "'$att[mail]', '$att[fechaN]', 0, 0, 0)";
        $queryResult = mysql_query($sqlQuery);
        return $queryResult;
    }

}

?>
