<?php 
if (!isset($_SESSION))
  session_start();
$ajax = false;
//echo "<p>Dominio: ".$_SERVER['HTTP_HOST']."<br/>Ruta: ".$_SERVER["DOCUMENT_ROOT"]."<br/>SessionDir: ".(isset($_SESSION['dir']) ? $_SESSION['dir'] : "No esta seteado el directorio!!! =/")."<br/><br/><p>";
//$srcFolder = "Roraima/perfil/src/";
$srcFolder = $_SERVER['DOCUMENT_ROOT']."/rspinf-usb/perfil/src/";
$classes = array("fachadas/PerfilFachada.php",
                 "vistas/PerfilView.php"
                 );

foreach ($classes as $class)
  require_once($srcFolder.$class);

require_once($_SERVER['DOCUMENT_ROOT']."/rspinf-usb/Muro/Muro.php");
require_once($_SERVER['DOCUMENT_ROOT']."/rspinf-usb/Seguridad/seguridad.php");

/*************************************************************************/
/**                   Sección de cableado jejeje  =)                    **/
/*************************************************************************/
//$_SESSION['k_username'] = "admin";                                   /**/
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
      $data["seguridadId"] = Seguridad::Crear_Seguridad('','',"Todos","Todos","Todos"); // seguridad default
      $data["muroId"] = Muro::Crear_Muro(5);
      $data["esAdmin"] = False;
      $data["estado"] = "activo";
      $fachada = PerfilFachada::singleton();
      try {
        $creacion = $fachada->createPerfil($data);
      } catch (DatosInvalidosException $e) {
        echo $vista->viewError($e->getMsg());
        exit(1);
      }
      //echo "<p>muroid = ".$data["muroId"]."</p>";
      if ($creacion) {
        echo $vista->viewCreatePerfil();
      }
    }
  } else if (strcmp($_GET["Action"],"edit") == 0) {
    if (isset($_GET["mode"])) {
      if (strcmp($_GET["mode"],"request") == 0) {
        if (isset($_SESSION["k_username"])) {
          $fachada = PerfilFachada::singleton();
          try {
            $perfil = $fachada->getPerfil($_SESSION["k_username"]);
          } catch (NoExisteException $e) {
            echo $vista->viewError("Problemas buscando la información del usuario: (".$_SESSION["k_username"].")");
            exit(1);
          }
          if (!is_null($perfil)) {
            echo $vista->viewEditPerfil($perfil,"request");
          }
        } else {
          echo $vista->viewError("No se ha iniciado sesión.");
          exit(1);
        }
      } else if (strcmp($_GET["mode"],"submit") == 0) {
        if (isset($_SESSION["k_username"]) && isset($_POST["passwd"]) &&
            isset($_POST["email"]) && isset($_POST["fechaNac_anio"]) && isset($_POST["fechaNac_mes"]) && isset($_POST["fechaNac_dia"]) &&
            isset($_POST["nombre"]) && isset($_POST["apellido"])) {
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
          echo "<p>Esta seteado foto?: ".(isset($_POST["foto"]) ? $_POST["foto"] : "nuoj")."</p>";
          // Guardo la foto:
          if (isset($_POST["foto"]) && $_FILES["foto"]["size"] > 0) {
            echo "Se subió el archivo!";
            $fileName = $_FILES["foto"]["name"];
            $tmpName  = $_FILES["foto"]["tmp_name"];
            $fileSize = $_FILES["foto"]["size"];
            $fileType = $_FILES["foto"]["type"];

            // Leo el archivo:
            $fp      = fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);

            if(!get_magic_quotes_gpc()) {
              $fileName = addslashes($fileName);
            }

            // Preparo para el almacenamiento:
            $data["nombreFoto"] = $fileName;
            $data["tamFoto"] = $fileSize;
            $data["formatoFoto"] = $fileType;
            $data["foto"] = $content;
          } else {
            echo "NO Se subió el archivo!";
            $data["nombreFoto"] = NULL;
            $data["tamFoto"] = NULL;
            $data["formatoFoto"] = NULL;
            $data["foto"] = NULL;
          }
          $data["trabajo"] = $_POST["trabajo"];
          $data["bio"] = $_POST["bio"];
          $fachada = PerfilFachada::singleton();
          try {
            $actualizacion = $fachada->editPerfil($data);
          } catch (DatosInvalidosException $e) {
            echo $vista->viewError($e->getMsg());
            exit(1);
          }
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
    if (isset($_GET["userq"])) {
      $fachada = PerfilFachada::singleton();
      try {
        $perfil = $fachada->getPerfil($_GET["userq"]);
        $viewer = $fachada->getPerfil($_SESSION["k_username"]);
        $exito = true;
      } catch (NoExisteException $e) {
        $exito = false;
        echo $vista->viewError($e->getMsg());
        exit(1);
      }
      if ($exito) {
      /************************************************************************
       *      Aqui tienes que setear las variables de seguridad, eleazar!     *
       ************************************************************************
       * Por defecto estan seteadas a true... cambia esos valores y ponle los *
       * correspondientes a la seguridad que tiene el id que esta en la varia-*
       * ble a contincuacion:                                                 *
       * El id de seguridad esta en:                                          *
       * $perfil["seguridadId"]                                               *
       * Saber si el usuario que ve es administrador o no:                    *
       *            $_SESSION["es_Admin"]                                     *
       * El id del usuario que estas viendo esta en:                          *
       * $_GET["userq"]                                                       *
       * El id del usuario que está viendo (el que esta loggeado) esta en:    *
       * $_SESSION["k_username"]                                              *
       ************************************************************************
       * Pon tu código aqui: */
        require_once($_SESSION['dir'] . "/Seguridad/seguridad.php");
        require_once($_SESSION['dir'].'/basedatos.php');
        $database = new basedatos("seguridad");
        $seguridad = new seguridad($perfil["seguridadId"]);
        $arr = $seguridad->devolverSeguridadActual($_GET['userq'], $viewer["esAdmin"]);
        $seguridadFotos = $arr[0];
        $seguridadMuro = $arr[2];
        $seguridadDatos = $arr[1];
        $isOwner = (strcmp($_GET['userq'],$_SESSION["k_username"]) == 0);
        $friendship = ($database->existeAmistad($_SESSION["k_username"],$_GET['userq']));
        $solicitud = ($database->existeSolicitud($_SESSION["k_username"],$_GET['userq']));
        $_SESSION["id_muro"] = $perfil["muroId"];
      /************************************************************************/;
        echo $vista->viewShowPerfil($viewer,$perfil,$isOwner,$friendship,$solicitud,$seguridadFotos, $seguridadMuro, $seguridadDatos);
      }
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