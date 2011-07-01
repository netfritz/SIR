<?php 
require_once ("registrarFachada.php");

$result=registrarse($_POST["usr"],$_POST["nom"],$_POST["ap"],$_POST["em1"],$_POST["co1"],$_POST["genero"],$_POST["fe"]);

  if ($result){
    echo("REGISTRO EXITOSO");
  }else{
    echo("REGISTRO FALLIDO");
      };

?>
