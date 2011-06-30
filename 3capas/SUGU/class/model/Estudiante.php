<?php
require_once("DataBase.php");

class Estudiante {
  
  /**
   * Cada uno de los siguientes representa un campo en la tabla Estudiante de la 
   * base de datos. Cada instancia de este objeto representará una tupla en di-
   * cha tabla.
   */
  private $doc_id;
  private $carnet;
  private $nombre;
  private $apellido;
  private $fecha_nac;
  private $colegio_origen;
  
  /**
   * Indica si esta instancia está recien creada o proviene de una consulta a la
   * base de datos. Útil para el método save(), para identificar si debe ejecu-
   * tarse una sentencia 'INSERT' o una sentencia 'UPDATE' al hacer el query a la
   * base de datos.
   */
  private $es_nuevo;  

  /* Indica si se está en fase debugging o no. */
  public static $debug = True;

  /* Contenedor de la salida de todas los métodos dinámicos de la clase */
  protected $out;

  /* Métodos mágicos */
  
  /**
   * Constructor de la clase. Es llamado cada vez que esta clase es instanciada.
   */
  public function __construct($doc_id, $carnet, $nombre, $apellido, $fecha_nac, $colegio_origen) {
    $this->doc_id = $doc_id;
    $this->carnet = $carnet;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->fecha_nac = $fecha_nac;
    $this->colegio_origen = $colegio_origen;
    $this->es_nuevo = True;
  }

  /**
   * Destructor de la clase. Es llamado cada vez que dejan de haber referencias 
   * a una instancia de la clase.
   */
  public function __destruct() {
    unset($this->doc_id);
    unset($this->carnet);
    unset($this->nombre);
    unset($this->apellido);
    unset($this->fecha_nac);
    unset($this->colegio_origen);
    unset($this->es_nuevo);
  }

  /**
   * Método mágico que devuelve la representación de un objeto de la clase como
   * un objeto de tipo String. Es llamado cada vez que se llame al objeto en un
   * contexto de tipo String.
   */
  public function __toString() {
    $str = "(".$this->doc_id.") ".$this->nombre." ".$this->apellido;
    return $str;
  }

  /* Getters y Setters */

  public function getDoc_id(){
    return $this->doc_id;
  }
  
  public function getCarnet(){
    return $this->carnet;
  }
  
  public function setCarnet($value){
    $this->carnet = $value;
  }

  public function getNombre(){
    return $this->nombre;
  }

  public function setNombre($value){
    $this->nombre = $value;
  }

  public function getApellido(){
    return $this->apellido;
  }
  
  public function setApellido($value){
    $this->apellido = $value;
  }
  
  public function getFecha_nac(){
    return $this->fecha_nac;
  }

  public function setFecha_nac($value){
    $this->fecha_nac = $value;
  }
  
  public function getColegio_origen(){
    return $this->colegio_origen;
  }

  public function setColegio_origen($value){
    $this->colegio_origen = $value;
  }

  /* Otros métodos */

  /**
   * Devuelve el resultado de la última operación de la clase ejecutada.
   */
  public function fetchOut(){
    return $this->out;
  }

  /**
   * Muestra errores relacionados con consulta a la base de datos.
   */
  public static function show_mysql_errors($query) {
    if (self::$debug){
      // ^ La idea es tener un setting para saber si se esta en fase debugging
      echo "\nConsulta:\n\t".$query."\nError:\n\t".mysql_error();
    }
  }

  /**
   * Devuelve un arreglo con tantas instancias como tuplas haya en la base de 
   * datos.
   */
  public static function all(){
    DataBase::singleton();
    $query = "SELECT * FROM Estudiante";
    $ans = mysql_query($query);
    if ($ans) {
      if (mysql_num_rows($ans) > 0) {
        while ($row = mysql_fetch_assoc($ans)) {
          $student = new Estudiante($row["documento_id"],
                                    $row["carnet"],
                                    $row["nombre"],
                                    $row["apellido"],
                                    $row["fecha_nac"],
                                    $row["colegio_origen"]);
          $student->es_nuevo = False;
          $ret[] = $student;
        }
      } else {        
        return NULL;
      }
    } else {
      self::show_mysql_errors($query);
      return "Error al listar todos los Estudiantes.";
    }
    return $ret;
  }

  /**
   * Se encarga de eliminar la tupla correspondiente a esta instancia de la 
   * clase de la base de datos. Devuelve un mensaje indicando el estado de 
   * la consulta.
   */
  public function delete(){
    DataBase::singleton();
    $query = "DELETE FROM Estudiante WHERE documento_id='".$this->doc_id."'";
    $ans = mysql_query($query);
    if ($ans) {
      if (mysql_affected_rows() == 1) {
        $this->out = "Se ha borrado al Estudiante ".$this." con éxito...";
        return True;
      } else {
        $this->out = "Error al borrar un Estudiante de la base de datos.";
        if (self::debug){
          // ^ La idea es tener un setting para saber si se esta en fase debugging
          self::show_mysql_errors($query);
        }
        return False;
      }
    } else {
      $this->out = "Error al intentar borrar al Estudiante ".$this." de la base de datos.";
      self::show_mysql_errors($query);
      return False;
    }
  }

  /**
   * 
   */
  public static function getByKey($key){
    DataBase::singleton();
    $query = "SELECT * FROM Estudiante WHERE documento_id = '".$key."'";
    $ans = mysql_query($query);
    if ($ans) {
      $nr = mysql_num_rows($ans);
      if ($nr == 1) {
        if ($row = mysql_fetch_assoc($ans)) {
          $student = new Estudiante($row["documento_id"],
                                    $row["carnet"],
                                    $row["nombre"],
                                    $row["apellido"],
                                    $row["fecha_nac"],
                                    $row["colegio_origen"]);
          $student->es_nuevo = False;
        } else {
          return NULL;
        }
      } else if ($nr == 0) {
        return NULL;
      }
    } else {
      self::show_mysql_errors($query);
      return "Error al buscar el Estudiante ".$this.".";
    }
    return $student;
  }

  /**
   * Se encarga de salvar esta instancia de Estudiante en la base de datos.
   * Discrimina entre hacer un 'INSERT' o un 'UPDATE'.
   */
  public function save(){
    DataBase::singleton();
    if ($this->es_nuevo) {
      $query = "INSERT INTO Estudiante VALUES ('"
        . $this->doc_id ."', '". $this->carnet ."', '"
        . $this->nombre ."', '". $this->apellido ."', '"
        . $this->fecha_nac ."', '". $this->colegio_origen
        ."')";
    } else {
      $query = "UPDATE Estudiante SET documento_id='".$this->doc_id
        ."', carnet='".$this->carnet
        ."', nombre='".$this->nombre
        ."', apellido='".$this->apellido
        ."', fecha_nac='".$this->fecha_nac
        ."', colegio_origen='".$this->colegio_origen
        ."' WHERE documento_id='".$this->doc_id."'";
    }
    if (mysql_query($query)) {
      $this->es_nuevo = True;
      return True;
    } else {
      $this->out = "Problema al tratar de salvar el objeto ".$this." en la base de datos.";
      self::show_mysql_errors($query);
      return False;
    }
  }
}
?>