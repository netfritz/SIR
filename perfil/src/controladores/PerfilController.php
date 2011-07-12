<?php
//echo "\n\n".getcwd()."\n\n";
$srcFolder = "/home/victor/projects/ingSoftware/SIR/src/";
$classes = array("fachadas/PerfilFachada.php",
                 "vistas/PerfilView.php"//,
                 //                 "../../SYS/usuario1/Muro/Muro.php"
                 );

foreach ($classes as $class)
  require_once($srcFolder.$class);

/*************************************************************************/
/**                   Sección de cableado jejeje  =)                    **/
/*************************************************************************/
$_SESSION['k_username'] = "admin";                                   /**/
//$_GET["Action"] = "edit";
//$_GET["mode"] = "request";
//$_GET["mode"] = "submit";
/*$_GET["Action"] = "create";
$_POST["usrname"] = "profe";
$_POST["passwd"] = "holaa";
$_POST["passwd2"] = "holaa";
$_POST["email"] = "throoze@gmail.com";
$_POST["email2"] = "throoze@gmail.com";
$_POST["fechaNac_anio"] = "0000";
$_POST["fechaNac_mes"] = "00";
$_POST["fechaNac_dia"] = "00";
$_POST["nombre"] = "Victor";
$_POST["apellido"] = "De Ponte";
$_POST["tipo"] = "Estudiante";
$_POST["sexo"] = "M";*/

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
        isset($_POST["email"]) && isset($_POST["fechaNac_anio"]) &&
        isset($_POST["fechaNac_mes"]) && isset($_POST["fechaNac_dia"]) &&
        isset($_POST["nombre"]) && isset($_POST["apellido"])) {
      $data["usrname"] = $_POST["usrname"];
      $data["passwd"] = $_POST["passwd"];
      $data["passwd2"] = $_POST["passwd2"];
      $data["email"] = $_POST["email"];
      $data["email2"] = $_POST["email2"];
      $data["fechaNac"] = $_POST["fechaNac_anio"]."-".
                          (((int)$_POST["fechaNac_mes"]) < 10 ? "0".$_POST["fechaNac_mes"] : $_POST["fechaNac_mes"] )."-".
                          (((int)$_POST["fechaNac_dia"]) < 10 ? "0".$_POST["fechaNac_dia"] : $_POST["fechaNac_dia"] );
      $data["nombre"] = $_POST["nombre"];
      $data["apellido"] = $_POST["apellido"];
      $data["carnet"] = NULL;
      $data["tipo"] = $_POST["tipo"];
      $data["sexo"] = $_POST["sexo"];
      $data["telefono"] = NULL;
      $data["emailAlt"] = NULL;
      $data["tweeter"] = NULL;
      $data["ciudad"] = NULL;
      $data["carrera"] = NULL;
      $data["colegio"] = NULL;
      $data["actividadesExtra"] = NULL;
      $data["foto"] = NULL;
      $data["trabajo"] = NULL;
      $data["bio"] = NULL;
      $data["seguridad_ID"] = 1; // cableado, seguridad default
      $data["muro_ID"] = 2;      // cableado, hay que cambiarlo.
      $data["esAdmin"] = False;
      $data["estado"] = "activo";
      $fachada = PerfilFachada::singleton();
      $creacion = $fachada->createPerfil($data);
      echo "\n\n\nadsvijbadsvkjbadsvkjbadsbkj\n\nmuroid = ".$data["muro_ID"]."\n\n";
      if ($creacion == True) {
        echo $vista->viewCreatePerfil();
      } else {
        echo $vista->viewErrors($creacion);
      }
    }
  } else if (strcmp($_GET["Action"],"edit") == 0) {
    if (isset($_GET["mode"])) {
      if (strcmp($_GET["mode"],"request") == 0) {
        if (isset($_SESSION["k_username"])) {
          $fachada = PerfilFachada::singleton();
          $perfil = $fachada->getPerfil($_SESSION["k_username"]);
          if (!is_null($perfil)) {
            echo $vista->viewEditPerfil($perfil,"request");
          } else {
            echo $vista->viewError("Problemas buscando la información del usuario: (".$_SESSION["k_username"].")");
          }
        } else {
          echo $vista->viewError("No se ha iniciado sesión.");
        }
      } else if (strcmp($_GET["mode"],"submit") == 0) {
        if (isset($_SESSION["k_username"]) && isset($_POST["passwd"]) &&
            isset($_POST["email"]) && isset($_POST["bdate"]) &&
            isset($_POST["name"]) && isset($_POST["lastname"])) {
          $data["usrname"] = $_SESSION["k_username"];
          $data["passwd"] = $_POST["passwd"];
          $data["passwd2"] = $_POST["passwd2"];
          $data["email"] = $_POST["email"];
          $data["email2"] = $_POST["email2"];
          $data["fechaNac"] = $_POST["fechaNac_anio"]."-".
                          (((int)$_POST["fechaNac_mes"]) < 10 ? "0".$_POST["fechaNac_mes"] : $_POST["fechaNac_mes"] )."-".
                          (((int)$_POST["fechaNac_dia"]) < 10 ? "0".$_POST["fechaNac_dia"] : $_POST["fechaNac_dia"] );
          $data["nombre"] = $_POST["nombre"];
          $data["apellido"] = $_POST["apellido"];
          $data["carnet"] = $_POST["carnet"];
          $data["tipo"] = $_POST["tipo"];
          $data["sexo"] = $_POST["sexo"];
          $data["telefono"] = $_POST["telefono"];
          $data["emailAlt"] = $_POST["emailAlt"];
          $data["tweeter"] = $_POST["tweeter"];
          $data["ciudad"] = $_POST["ciudad"];
          $data["carrera"] = $_POST["carrera"];
          $data["colegio"] = $_POST["colegio"];
          $data["actividadesExtra"] = $_POST["actividadesExtra"];
          $data["foto"] = $_POST["foto"];
          $data["trabajo"] = $_POST["trabajo"];
          $data["bio"] = $_POST["bio"];
          $data["seguridad_ID"] = 1; // cableado para que funcione
          $data["muro_ID"] = 2;//Muro::Crear_Muro(999999,0);
          $data["esAdmin"] = False;
          $data["estado"] = "activo";
          $fachada = PerfilFachada::singleton();
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
      $fachada = PerfilFachada::singleton();
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