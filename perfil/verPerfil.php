<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
   session_start();
?>
<?php require($_SESSION['dir'].'/formatoPagina/encabezado.php') ?>
   <link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
   <script type="text/javascript">
function show_confirm()
{
var r=confirm("Éstas seguro de que deseas designar a esta persona como administrador?\n Si lo estás presiona 'Aceptar', en otro caso presiona 'Cancel' ");
if (r==true)
  {
	return true;
  }
else
  {
	return false;
  }
}
function show_confirm2()
{
var r=confirm("Éstas seguro de que deseas enviar una Advertencia a esta persona?\n Si lo estás presiona 'Aceptar', en otro caso presiona 'Cancel' ");
if (r==true)
  {
	return true;
  }
else
  {
	return false;
  }
}
function show_confirm3()
{
var r=confirm("Éstas seguro de que deseas dessactivar la cuenta de esta persona?\n Si lo estás presiona 'Aceptar', en otro caso presiona 'Cancel' ");
if (r==true)
  {
	return true;
  }
else
  {
	return false;
  }
}
</script>
<?php require($_SESSION['dir'].'/formatoPagina/menu.php') ?>

<?php
$_SESSION["entidad"] = "perfil";
if (isset($_GET["userq"])) {
  $_SESSION["clave_entidad"] = $_GET["userq"];
  $_GET["Action"] = "show";
  $srcFolder = $_SERVER['DOCUMENT_ROOT']."/rspinf-usb/perfil/src/";
  require($_SESSION['dir'].'/perfil/src/controladores/PerfilController.php');
} else {
  require($_SESSION['dir'].'/formatoPagina/inicioBL.php');
  require($_SESSION['dir'].'/formatoPagina/finBL.php');
  require($_SESSION['dir'].'/formatoPagina/inicioContenido.php');
  echo utf8_encode("<br/><br/><br/><br/><br/><br/><h2>Error al buscar el perfil!</h2><br/><br/><p>No se especificó el usuario a ser buscado. Por favor utilize los medios regulares para encontrar<br/> el perfil que desea:<br/><ul><li>Utilize el buscador en la parte superior</li><li>Utilice la <a href=\"/rspinf-usb/busqueda/busquedaAvanzada.php\">Búsqueda Avanzada</a></li></ul><br/><br/><br/><br/></p>");
}
?>
<?php require($_SESSION['dir'].'/formatoPagina/finContenido.php') ?>
