<?php
// Controlador para el caso de uso Listar Mensajes

function __autoload($class_name) {
    include $class_name . '.php';
}

// Sesion de prueba
$_SESSION["perfil"] = new Perfil("jose");

// Verificar si el usuario está logeado
if (!isset($_SESSION["perfil"])) {
  /* $vista = new VistaLogin(); */
  /* $vista->render(); */
  /* exit(); */
} else {
  if (!array_key_exists("tipo",$_GET)) {
    $tipo = "recibidos";
  } else {
    $tipo = $_GET["tipo"];
  }
  $perfil = $_SESSION["perfil"];
  $fachada = FachadaMensajes::getInstance();
  $lista = $fachada->listarMensajes($perfil, $tipo);

  /* $vista = new VistaListarMensajes(); */
  /* $vista->render(array("perfil" => $perfil, "lista" => $lista)); */
  /* exit(); */

  require("VistaListarMensajes.php");

}
?>