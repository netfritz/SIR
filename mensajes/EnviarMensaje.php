<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
// Controlador para el caso de uso Enviar Mensaje

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
  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $fachada = FachadaMensajes::getInstance();
    $dests = explode(",", $_POST["dests"]);
    $fachada->enviarMensaje($_POST["asunto"],$_POST["texto"],
			    $_SESSION["perfil"],$dests);
    require("VistaEnviarMensajeExito.php");
  } else {
    require("VistaEnviarMensaje.php");
  }
}

?>