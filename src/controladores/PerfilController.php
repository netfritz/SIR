<?php
//echo "\n\n".getcwd()."\n\n";
$srcFolder = "/home/victor/projects/ingSoftware/SIR/src/";
$classes = array("fachadas/PerfilFachada.php",
                 "vistas/PerfilView.php"
                 );

foreach ($classes as $class)
  require_once($srcFolder.$class);

/*************************************************************************/
/**                   Sección de cableado jejeje  =)                    **/
/*************************************************************************/
$_SESSION['usrname'] = "jose";                                         /**/ 
//$_GET["Action"] = "edit";                                            /**/
//$_GET["mode"] = "request";                                           /**/
/*************************************************************************/
/*************************************************************************/

/**
 * Se buscan los parámetros recibidos por GET. Si se recibe un 'Action', se
 * muestra el formulario vacío. Si no, se muestra lo que corresponda, según
 * lo recibido.
 */
$vista = PerfilView::Singleton();
if (isset($_GET["Action"])) {
  if (strcmp($_GET["Action"],"create") == 0) {
    if (isset($_POST["usrname"]) && isset($_POST["passwd"]) && 
        isset($_POST["email"]) && isset($_POST["bdate"]) && 
        isset($_POST["name"]) && isset($_POST["lastname"])) {
      $data["username"] = $_POST["username"];
      $data["passwd"] = $_POST["passwd"];
      $data["passwd2"] = $_POST["passwd2"];
      $data["email"] = $_POST["email"];
      $data["email2"] = $_POST["email2"];
      $data["bdate"] = $_POST["bdate"];
      $data["name"] = $_POST["name"];
      $data["lastname"] = $_POST["lastname"];
      $fachada = PerfilFachada::getInstance();
      $creacion = $fachada->createPerfil($data);
      if (is_null($creacion)) {
        echo $vista->viewCreatePerfil(NULL,"success");
      } else {
        echo $vista->viewErrors($creacion);
      }
    }
  } else if (strcmp($_GET["Action"],"edit") == 0) {
    if (isset($_GET["mode"])) {
      if (strcmp($_GET["mode"],"request") == 0) {
        if (isset($_SESSION["usrname"])) {
          $fachada = PerfilFachada::singleton();
          $perfil = $fachada->getPerfil($_SESSION["usrname"]);
          if (!is_null($perfil)) {
            echo $vista->viewEditPerfil($perfil,"request");
          } else {
            echo $vista->viewError("Problemas buscando la información del usuario: (".$_SESSION["usrname"].")");
          }
        } else {
          echo $vista->viewError("No se ha iniciado sesión.");
        }
      } else if (strcmp($_GET["mode"],"submit") == 0) {
        if (isset($_POST["usrname"]) && isset($_POST["passwd"]) && 
            isset($_POST["email"]) && isset($_POST["bdate"]) && 
            isset($_POST["name"]) && isset($_POST["lastname"])) {
          $data["username"] = $_POST["username"];
          $data["passwd"] = $_POST["passwd"];
          $data["passwd2"] = $_POST["passwd2"];
          $data["email"] = $_POST["email"];
          $data["email2"] = $_POST["email2"];
          $data["bdate"] = $_POST["bdate"];
          $data["name"] = $_POST["name"];
          $data["lastname"] = $_POST["lastname"];
          $fachada = PerfilFachada::getInstance();
          $actualizacion = $fachada->editPerfil($data);
          if ($actualizacion == True || is_null($actualizacion)) {
            echo $vista->viewEditPerfil(NULL,"success");
          } else {
            echo $vista->viewErrors($actualizacion);
          }
        }
      } else {
        echo $vista->viewError("Parámetros inválidos: (".$_GET["mode"].")");
      }
    } else {
      echo $vista->viewError("Parámetros inválidos: No se envió el modo de edición!");
    }
  } else if (strcmp($_GET["Action"],"show") == 0) {
    if (isset($_POST["usrname"])) {
      $fachada = PerfilFachada::getInstance();
      $perfil = $fachada->getPerfil($_POST["usrname"]);
      echo $vista->viewShowPerfil($perfil);
    } else {
      echo $vista->viewError("Usuario inválido o inexistente.");
    }
  }else {
    echo $vista->viewError("Acción solicitada inválida: (".$_GET["Action"].").");
  }
} else {
  echo $vista->viewRegisterEmpty();
}
?>