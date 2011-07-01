<?php
require_once("../fachadas/PerfilFachada.php");
require_once("../vistas/VistaPerfil.php");
/**
 * Se buscan los parámetros recibidos por GET. Si se recibe un 'Action', se
 * muestra el formulario vacío. Si no, se muestra lo que corresponda, según
 * lo recibido.
 */
if (isset($_GET["Action"])) {
  if (strcmp($_GET["Action"],"create")) {
    if (isset($_POST["usrname"]) && isset($_POST["passwd"]) && 
        isset($_POST["email"]) && isset($_POST["bdate"]) && 
        isset($_POST["name"]) && isset($_POST["lastname"])) {
      $data["username"] = $_POST["username"];
      $data["passwd"] = $_POST["passwd"];
      $data["email"] = $_POST["email"];
      $data["bdate"] = $_POST["bdate"];
      $data["name"] = $_POST["name"];
      $data["lastname"] = $_POST["lastname"];
      $data["isAdmin"] = False;
      $data["isNew"] = True;
      $fachada = PerfilFachada::getInstance();
      $creacion = $fachada->createPerfil($data);
      if (is_null($creacion)) {
        echo viewCreatePerfil(NULL,"success");
      } else {
        echo viewErrors($creacion);
      }
    }
  } else if (strcmp($_GET["Action"],"edit")) {
    if (isset($_GET["mode"])) {
      if (strcmp($_GET["mode"],"request")) {
        if (isset($_SESSION["usrname"])) {
          $fachada = PerfilFachada::getInstance();
          $perfil = $fachada->getPerfil($_SESSION["usrname"]);
          if (!is_null($perfil)) {
            echo viewEditPerfil($perfil,"edit");
          } else {
            echo viewError("Problemas buscando la información del usuario: (".$_SESSION["usrname"].")");
          }
        } else {
          echo viewError("No se ha iniciado sesión.");
        }
      } else if (strcmp($_GET["mode"],"submit")) {
        if (isset($_POST["usrname"]) && isset($_POST["passwd"]) && 
            isset($_POST["email"]) && isset($_POST["bdate"]) && 
            isset($_POST["name"]) && isset($_POST["lastname"])) {
          $data["username"] = $_POST["username"];
          $data["passwd"] = $_POST["passwd"];
          $data["email"] = $_POST["email"];
          $data["bdate"] = $_POST["bdate"];
          $data["name"] = $_POST["name"];
          $data["lastname"] = $_POST["lastname"];
          $data["isAdmin"] = False;
          $data["isNew"] = False;
          $fachada = PerfilFachada::getInstance();
          $actualizacion = $fachada->editPerfil($data);
          if (is_null($actualizacion)) {
            echo viewEditPerfil(NULL,"success");
          } else {
            echo viewErrors($actualizacion);
          }
        }
      } else {
        echo viewError("Parámetros inválidos: (".$_GET["mode"].")");
      }
    } else {
      echo viewError("Parámetros inválidos: No se envió el modo de edición!");
    }
  } else if (strcmp($_GET["Action"],"show")) {
    if (isset($_POST("usrname"))) {
      $fachada = PerfilFachada::getInstance();
      $perfil = $fachada->getPerfil($_POST["usrname"]);
      echo viewShowPerfil($perfil);
    } else {
      echo viewError("Usuario inválido o inexistente.");
    }
  }else {
    echo viewError("Acción solicitada inválida: (".$_GET["Action"].").");
  }
} else {
  echo viewRegisterEmpty();
}
?>