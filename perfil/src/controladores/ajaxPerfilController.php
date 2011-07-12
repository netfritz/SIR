<?php
$srcFolder = "/home/victor/projects/ingSoftware/SIR/src/";
$classes = array("mappers/Perfil.php",
                 "fachadas/PerfilFachada.php"
                 );
foreach ($classes as $class)
  require_once($srcFolder.$class);

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