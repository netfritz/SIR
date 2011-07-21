<?php
if (!isset($_SESSION))
  session_start();
/*
$_GET["mode"] = "request";
$_SESSION['dir'] = "/home/victor/projects/ingSoftware/rspinf-usb";
$_SESSION['k_username'] = 'victor';
$_SERVER['DOCUMENT_ROOT'] = "/home/victor/projects/ingSoftware";*/
?>
<?php include($_SESSION['dir'].'/formatoPagina/encabezado.php'); ?>
<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src="js/editarPerfil.js"></script>
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
<?php include($_SESSION['dir'].'/formatoPagina/menu.php');
include($_SESSION['dir'].'/formatoPagina/inicioBL.php');
include($_SESSION['dir'].'/formatoPagina/finBL.php');
include($_SESSION['dir'].'/formatoPagina/inicioContenido.php');
$_GET["Action"] = "edit";
$srcFolder = $_SERVER['DOCUMENT_ROOT']."/rspinf-usb/perfil/src/";
require_once($srcFolder."controladores/PerfilController.php");
require($_SESSION['dir'].'/formatoPagina/finContenido.php');
?>
