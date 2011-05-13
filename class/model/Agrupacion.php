<?php

/* Clase que maneja los datos de las agrupaciones estudiantiles en las
 * universidades registradas en la base de datos. Provee los métodos necesarios
 * para esto. */

require_once("DataBase.php");

class Agrupacion {

    // Variables de Agrupacion
    private $universidad;
    private $nombre;
    private $presidente;
    private $mision;
    private $vision;
    private $nueva;

    // Metodo Constructor
    function Agrupacion($uni, $nomb, $presi, $mi, $vi) {
        $this->universidad = $uni;
        $this->nombre = $nomb;
        $this->presidente = $presi;
        $this->mision = $mi;
        $this->vision = $vi;
        $this->nueva = TRUE;
    }

    // Retorna un arreglo con todas las instancias de la clase
    public static function all() {
        DataBase::singleton();
        $sql = "SELECT * FROM AgrupacionEstudiantil";
        $ConsultaID = @mysql_query($sql);
        $arreglo=null;
        if ($ConsultaID){
            while ($fila = mysql_fetch_assoc($ConsultaID)) {
                $instancia = new Agrupacion($fila["universidad"], $fila["nombre"],
                   $fila["presidente"], $fila["mision"], $fila["vision"]);
                $instancia->nueva=FALSE;
                $arreglo[] = $instancia;
            }
            return($arreglo);
        }else{
            return(null);
        }
    }
    
    // Retorna la instancia cuyo Id está compuesto de los parámetros univ y nomb
    public static function getByKey($univ, $nomb) {
        DataBase::singleton();
        $sql = "SELECT * FROM AgrupacionEstudiantil WHERE universidad ='{$univ}' 
            and '{$nomb}'= nombre";
        $ConsultaID = @mysql_query($sql);

        if(!($fila = @mysql_fetch_assoc($ConsultaID))) {return null;}

        $Instancia = new Agrupacion($fila["universidad"], $fila["nombre"], $fila["presidente"], $fila["mision"], $fila["vision"]);
        $Instancia->nueva = FALSE;
        return($Instancia);
    }

    // Guarda en la Base de datos la instancia. Diferencia entre un objeto nuevo y una modificación
    public function save() {
        DataBase::singleton();
        if ($this->nueva) {
            $sql = "INSERT INTO AgrupacionEstudiantil VALUES ('$this->universidad',
                '$this->nombre', '$this->presidente', '$this->mision', '$this->vision')";
            @mysql_query($sql);
        } else {
            $sql = "UPDATE AgrupacionEstudiantil 
                SET presidente='{$this->presidente}',
                mision ='$this->mision', vision ='$this->vision' 
                WHERE (universidad= '{$this->universidad}' AND nombre = '{$this->nombre}')";
            @mysql_query($sql);
        }
        $this->nueva = false;
    }

    // Elimina la instancia de la Base de Datos
    public function delete() {
        DataBase::singleton();
        $sql = "DELETE FROM AgrupacionEstudiantil
            WHERE universidad = '" . $this->universidad . "' and nombre = '" . $this->nombre ."';";
        @mysql_query($sql);
	$this->nueva= true;
    }

    // Devuelve una cadena con los atributos de la instancia
    public function __toString() {
    $cadena = $this->universidad;
    $cadena.= "," .$this->nombre .",". $this->presidente;
    $cadena.= "," .$this->mision .",". $this->vision;
    return($cadena);
    }

    // Funciones para obtener los atributos
    function getUniversidad() {
        return ($this->universidad);
    }

    function getNombre() {
        return ($this->nombre);
    }

    function getPresidente() {
        return ($this->presidente);
    }

    function getMision() {
        return ($this->mision);
    }

    function getVision() {
        return ($this->vision);
    }

    function getNueva() {
        return ($this->nueva);
    }

    // Funciones para establecer los atributos
    // Modifica el atributo de la instancia por el del parámetro
    function setUniversidad($univ) {
        $this->universidad = $univ;
    }

    function setNombre($nomb) {
        $this->nombre = $nomb;
    }

    function setPresidente($pres) {
        $this->presidente = $pres;
    }

    function setMision($mi) {
        $this->mision = $mi;
    }

    function setVision($vi) {
        $this->vision = $vi;
    }

    function setNueva() {
        $this->nueva = false;
    }

}

// Fin de la clase Agrupacion.
?>
