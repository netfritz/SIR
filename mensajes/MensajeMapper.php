<?php
class MensajeMapper {
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

    public function getAtributosMensaje($mid) {
      DataBase::singleton();
      $query = "SELECT asunto,texto FROM Mensaje WHERE mid={$mid}";
      $result = mysql_query($query);
      if (mysql_num_rows($result)==0) {
        return NULL;
      } else {
        $row = mysql_fetch_assoc($result);
        $asunto = $row["asunto"];
        $texto = $row["texto"];
        return array("asunto" => $asunto, "texto" => $texto);
      }
    }

    public function getAtributosMensajeEnviado($mid) {
      DataBase::singleton();
      $query = "SELECT emisor,eliminado FROM Mensaje WHERE mid={$mid}";
      $result = mysql_query($query);
      if (mysql_num_rows($result)==0) {
	return NULL;
      } else {
	$row = mysql_fetch_assoc($result);
	$eliminado = $row["eliminado"];
	$emisor = $row["emisor"];
	return array("emisor" => $emisor, "eliminado" => $eliminado);
      }
    }

    public function getAtributosMensajeRecibido($pid,$mid) {
      DataBase::singleton();
      $query = "SELECT eliminado,leido FROM MensajeRecibido  WHERE mid={$mid} AND destinatario='{$pid}'";
      $result = mysql_query($query);
      if (mysql_num_rows($result)==0) {
	return NULL;
      } else {
	$row = mysql_fetch_assoc($result);
	$eliminado = $row["eliminado"];
	$leido = $row["leido"];
	return array("eliminado" => $eliminado, "leido" => $leido);
      }
    }

    public function updateMensaje($ms, $me, $lm) {
      DataBase::singleton();
      $mid = $this->mres($ms["mid"]);
      $as = $this->mres($ms["asunto"]);
      $tx = $this->mres($ms["texto"]);
      $emisor = $me["emisor"];
      $elim = $me["eliminado"];
      $query = "UPDATE Mensaje SET asunto='{$as}',texto='{$tx}',emisor='{$emisor}',eliminado={$elim} WHERE mid={$mid}";
      mysql_query($query) or die (mysql_error());
      foreach ($lm as $mr) {
	$dest = $mr["destinatario"];
	$elim = $mr["eliminado"];
	$leido = $mr["leido"];
	$query = "UPDATE MensajeRecibido SET eliminado={$elim},leido={$leido} WHERE mid={$mid} AND destinatario='{$dest}'";
	mysql_query($query) or die(mysql_error());
      }
    }

    public function insertMensaje($ms, $me, $lm) {
      DataBase::singleton();
      $as = $this->mres($ms["asunto"]);
      $tx = $this->mres($ms["texto"]);
      $emisor = $me["emisor"];
      $elim = $me["eliminado"];
      $query = "INSERT INTO Mensaje (asunto,texto,emisor,eliminado) VALUES ('{$as}','{$tx}','{$emisor}',0)";
      mysql_query($query);
      $mid = mysql_insert_id();
      var_export($lm);
      foreach ($lm as $mr) {
	$dest = $mr["destinatario"];
	$elim = $mr["eliminado"];
	$leido = $mr["leido"];
	$query = "INSERT INTO MensajeRecibido (mid,destinatario,eliminado,leido) VALUES ({$mid},'{$dest}',0,0)";
	echo $query;
	mysql_query($query) or die(mysql_error());
      }
    }

    private function mres($s) {
      return mysql_real_escape_string($s);
    }

    public function getDestinatarios($mid) {
      $query = "SELECT destinatario FROM MensajeRecibido WHERE mid={$mid}";
      $result = mysql_query($query);
      $lista = array();
      while ($row = mysql_fetch_assoc($result)) {
	$lista[] = $row["destinatario"];
      }
      return $lista;
    }

    /*
     * $pid: string, identificador del perfil del cual se extraerán los mensajes
     * $tipo: string, puede ser 'recibidos' o 'enviados'
     * Devuelve un arreglo con los identificadores de los mensajes relevantes.
     */
    public function obtenerMensajes($pid, $tipo) {
      DataBase::singleton();
      if ($tipo == "recibidos") {
        $query = "SELECT mid FROM MensajeRecibido WHERE destinatario='{$pid}'";
      } else if ($tipo = "enviados") {
        $query = "SELECT mid FROM Mensaje WHERE emisor='{$pid}'";
      } else {
        return NULL;
      }
      $result = mysql_query($query) or die (mysql_error());
      $mids = array();
      while ($row = mysql_fetch_assoc($result)) {
        $mids[] = $row["mid"];
      }
      return $mids;
    }
}
?>