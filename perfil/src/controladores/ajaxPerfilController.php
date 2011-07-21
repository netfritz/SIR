<?php
//$srcFolder = $_SERVER['DOCUMENT_ROOT']."/rspinf-usb/perfil/src/";
$srcFolder = "../";
$ajax = true;
$classes = array("bd/DataBase.php",
                 "fachadasBD/FachadaBDPerfil.php",
                 "mappers/Perfil.php",
                 "fabricas/PerfilFactory.php",
                 "fachadas/PerfilFachada.php"
                 );
foreach ($classes as $class)
  require_once($srcFolder.$class);

//$_POST["function"] = "askForUsr";
//$_POST["usrname"] = "admin";

function getByAttr($attr, $value) {
  if (strcmp($attr,"usrname") == 0) {
    $fachada = PerfilFachada::singleton();
    return $fachada->exists($value);
  } else if (strcmp($attr,"email") == 0) {
    $fachada = PerfilFachada::singleton();
    return $fachada->exists($value,"email");
  }
  return NULL;
}

if (isset($_POST["function"])) {
  if (strcmp($_POST["function"],"askForUsr") == 0) {
    if (isset($_POST["usrname"])) {
      if (getByAttr("usrname",$_POST["usrname"])) {
        $return["exists"] = True;
        echo json_encode($return);
      } else {
        $return["exists"] = False;
        echo json_encode($return);
      }
    }
  } else if (strcmp($_POST["function"],"askForEmail") == 0) {
    if (isset($_POST["email"])) {
      if (getByAttr("email",$_POST["email"])) {
        $return["exists"] = True;
        echo json_encode($return);
      } else {
        $return["exists"] = False;
        echo json_encode($return);
      }
    }
  }
}
?>