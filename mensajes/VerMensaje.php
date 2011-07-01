<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
// Controlador para el caso de uso Ver Mensaje

function __autoload($class_name) {
    include $class_name . '.php';
}

// Session de prueba
$_SESSION["perfil"] = new Perfil("jose");

// Verificar si el usuario está logeado
if (!isset($_SESSION["perfil"])) {
  /* $vista = new VistaLogin(); */
  /* $vista->render(); */
  /* exit(); */
  echo ("logeate");
} else {
  if (!array_key_exists("mid",$_GET)) {
    // mensaje no existe
    echo "No existe";
  }
  $fachada = FachadaMensajes::getInstance();
  $m = $fachada->leerMensaje($_SESSION["perfil"],$_GET["mid"]);
  if ($m == NULL) {
    // mensaje no existe
    echo "No existe";
  }
  require("VistaVerMensaje.php");
}

?>