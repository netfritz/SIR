<?php

require_once 'DataBase.php';

/**
 * La clase Profesor abstrae el concepto de un profesor universitario.
 *
 * @author Soluciones Integrales Roraima
 */
class Profesor {

    private $documento_id;
    private $old_documento_id;
    private $dpto;
    private $old_dpto;
    private $carnet;
    private $nombre;
    private $apellido;
    private $titulo;
    private $new; //Indica si el objeto es nuevo o ya existia en la base de datos
    private $changedKey; //Indica si se cambio algunos de los atributos clave;

    function __construct($documento_id, $dpto, $carnet, $nombre, $apellido, $titulo = NULL) {
        $this->documento_id = $documento_id;
        $this->dpto = $dpto;
        $this->carnet = $carnet;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->titulo = $titulo;
        $this->new = TRUE;
    }

    public function getDocumento_id() {
        return $this->documento_id;
    }

    public function getDpto() {
        return $this->dpto;
    }

    public function getCarnet() {
        return $this->carnet;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setDocumento_id($documento_id) {
        $this->old_documento_id = $this->documento_id;
        $this->documento_id = $documento_id;
        $this->changedKey = TRUE;
    }

    public function setDpto($dpto) {
        $this->old_dpto = $this->dpto;
        $this->dpto = $dpto;
        $this->changedKey = TRUE;
    }

    public function setCarnet($carnet) {
        $this->carnet = $carnet;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public static function all() {
        DataBase::singleton();
        $sqlQuery = "SELECT * FROM Profesor";
        $result = mysql_query($sqlQuery);
        while ($row = mysql_fetch_assoc($result)) {
            $objectRow = new profesor($row["documento_id"], $row["dpto"],
                            $row["carnet"], $row["nombre"], $row["apellido"],
                            $row["titulo"]);
            $objectRow->new = FALSE;
            $objectRow->changedKey = FALSE;
            $objectRow->old_documento_id = $row["documento_id"];
            $objectRow->old_dpto = $row["dpto"];
            $array[] = $objectRow;
        }
        return $array;
    }

    public static function getByKey($documento_id, $dpto) {
        DataBase::singleton();
        $sqlQuery = "SELECT * FROM Profesor WHERE " .
                "documento_id = '".$documento_id."' AND dpto = '".$dpto."';" ;
        $result = mysql_query($sqlQuery);
        $row = mysql_fetch_assoc($result);
        if ($row) {
            $objectRow = new Profesor($row["documento_id"], $row["dpto"],
                            $row["carnet"], $row["nombre"], $row["apellido"],
                            $row["titulo"]);
            $objectRow->new = FALSE;
            $objectRow->changedKey = FALSE;
            $objectRow->old_documento_id = $row["documento_id"];
            $objectRow->old_dpto = $row["dpto"];
            return $objectRow;
        }
        return NULL;
    }

    public function __toString() {
        return "Nombre: $this->nombre" . PHP_EOL .
        "Apellido: $this->apellido" . PHP_EOL .
        "Departamento: $this->dpto" . PHP_EOL .
        "Documento de Identidad: $this->documento_id" . PHP_EOL;
    }

    public function delete() {
        DataBase::singleton();
        $sqlQuery = "DELETE FROM Profesor WHERE " .
                "documento_id = '$this->documento_id' AND dpto = '$this->dpto'";
        $res = mysql_query($sqlQuery);
    }

    public function save() {
        DataBase::singleton();
        if ($this->new) {
            $sqlQuery = "INSERT INTO Profesor VALUES ('$this->documento_id', " .
                    "'$this->dpto', '$this->carnet', '$this->nombre', " .
                    "'$this->apellido', '$this->titulo')";
            $res = mysql_query($sqlQuery);
            if (!$res) {
                die("ERROR Profesor.save(): No se pudo insertar.");
            }
        } else {
            $sqlQuery = "UPDATE Profesor" .
                    "SET documento_id = '$this->documento_id', " .
                    "dpto = '$this->dpto', carnet = '$this->carnet', " .
                    "nombre = '$this->nombre', apellido = '$this->apellido'" .
                    "titulo = '$this->titulo'" .
                    "WHERE documento_id = '$this->old_documento_id' AND" .
                    "dpto = '$this->old_dpto'";
            $res = mysql_query($sqlQuery);
            if (!$res) {
                die("ERROR Profesor.save(): No se pudo actualizar.");
            }
        }
    }

}

?>
