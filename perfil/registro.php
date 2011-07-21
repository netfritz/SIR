<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-VE">
   <head>
   <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
   <meta HTTP-EQUIV="Pragma" CONTENT="no-cache"/>
   <meta name="keywords" content="" />
   <meta name="description" content="" />
   <title>PINF</title>
   <link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
   <meta HTTP-EQUIV="Pragma" CONTENT="no-cache">
   </head>
   <body>
   <div id="wrapper">
   <!-- inicio encabezado -->
   <div id="encab">
   <div id="logo">
   <h1><a href="#">PINF</a></h1>
   <p>por Roraima</p>
   </div>

   </div>
   <!-- fin encabezado -->

   <!-- inicio pagina -->
   <div id="pag">
   <div id="pag-bgarriba">
   <div id="pag-bgabajo">

   <!-- inicio menu -->
   <div id="menu">
   <ul>
   <li><a href="/rspinf-usb/">Inicio</a></li>
   <li class="current_page_item"><a href="/rspinf-usb/perfil/registro.php">Registro</a></li>
   </ul>
   </div>
   <!-- fin menu -->

   <!-- inicio contenido -->
   <div id="contenido">
   <div class="nombrePinf">

   </div>
   <div id="msg">
   <h2>
   Bienvenido a PINF!!!
   </h2><br/>
                    <h3>
   un lugar para ser computista en su máxima expresión!
   </h3><br/><br/>
   <p>
   Disfrutarás de comunicación paralela y concurrente con todos tus compañeros computistas, ahora más facil y rápido. Creado y mantenido por nosotros mismos, preguntanos: <a href="" class="links"> Cómo puedes colaborar?</a>
   </p>
   </div>
   <div style="clear: both;">&nbsp;</div>
   </div>
   <!-- fin contenido -->

   <!-- inicio barra lateral -->
   <div id="barlateral">
   <h3>Registrarse es facil, y gratis!!!</h3>
   <legend><h3>Adelante...</h3></legend>
   <?php
   //   if (!isset($_SESSION['dir']))
   //session_start();
   //echo (isset($_SESSION['dir']) ? "<p>".$_SESSION['dir']."</p>" : "<p>No esta seteado el directorio SESSION DIR!!! =/</p>");
   //echo (isset($_SERVER['DOCUMENT_ROOT']) ? "<p>".$_SERVER['DOCUMENT_ROOT']."</p>" : "<p>No esta seteado el directorio SERVER DOCUMENT_ROOT!!! =/</p>");
   $srcFolder = $_SERVER['DOCUMENT_ROOT']."/rspinf-usb/perfil/src/";
   //echo "<p> Source Folder:  ".$srcFolder."</p>";
   require_once($srcFolder."controladores/PerfilController.php");
   ?>
   </div>
   <!-- fin barra lateral -->

   <div style="clear: both;">&nbsp;</div>
   </div>
   </div>
   </div>
   </div>
   <!-- fin de pagina -->

   <!-- inicio pie de pagina -->
   <div id="pie-wrapper">
     <div id="pie">
     <p>
        <a href="http://localhost:8080/web/home.html">Inicio&nbsp;&nbsp;&nbsp;</a>
        <a href="http://www.usb.ve/">USB&nbsp;&nbsp;&nbsp;</a>
        <a href="http://www.dace.usb.ve/">DACE&nbsp;&nbsp;&nbsp;</a>
        <a href="http://www.generales.usb.ve/">Estudios Generales&nbsp;&nbsp;&nbsp;</a>
        <a href="http://asignaturas.usb.ve/">Aula Virtual</a>
        <a href="/web/enConstruccion.html">Salir</a><br/><br/>Diseñado por Pinf
     </p>
                                                                               </div>
                                                                               </div>
                                                                               <!-- fin pie de pagina -->
                                                                               </body>
                                                                               <script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
                                                                               <script type="text/javascript" src="js/inicio.js"></script>
                                                                               </html>