<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Basado en un diseño de Free CSS Templates
==============================
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : EarthlingTwo  
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20090918
==============================

Modificado por:
SIR - Solucioness Integrales Roraima Caracas - Venezuela Copyright©2011
-->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>SUGU - Sistema Universal de Gestión Universitaria</title>
        <link href="resources/css/style.css" rel="stylesheet" type="text/css" media="screen" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <div id="logo">
                    <a href="/home/"<img src="" alt="" /></a>
                </div>
            </div>
            <!-- end #header -->
            <div id="menu">
                <ul>
                    <li class="current_page_item"><a href="index.php">Home</a></li>
                    <li><a href="index.php?class=universidad">Universidades</a></li>
                    <li><a href="index.php?class=carrera">Carreras</a></li>
                    <li><a href="index.php?class=profesor">Profesores</a></li>
                    <li><a href="index.php?class=departamento">Departamentos</a></li>
                    <li><a href="index.php?class=materia">Materias</a></li>
                    <li><a href="index.php?class=agrupacion">Agrupaciones</a></li>
                    <li><a href="index.php?class=estudiante">Estudiantes</a></li>
                </ul>
            </div>
            <!-- end #menu -->
            <?php
            $reg = "(universidad|agrupacion|carrera|departamento|profesor|estudiante|materia)";

            if (!isset($_GET['class'])) {
                echo "<div id='page'>
                <div id='content'>
                <div class='post'>
                <h2 class='title'>¡Bienvenido!</h2>
                <div class='entry'>
                 <p> Para comenzar, haz click en cualquiera de las secciones
                      de arriba </br></br></br></br></br></br>.
                </p>                          
                </div>
                </div>
	        <div style='clear: both;'>&nbsp;</div>
	        </div>
	        <div style='clear: both;'>&nbsp;</div>
                </div>";
            } elseif (!preg_match($reg, $_GET["class"])) {
                
            } else {
                require_once("func/func_" . $_GET["class"] . ".php");
            }

            $cmd = "All";

            if (isset($_GET["cmd"])) {
                switch ($_GET["cmd"]) {
                    case "insert":
                        $cmd = "Insert";
                        break;
                    case "all":
                        $cmd = "All";
                        break;
                    case "edit":
                        $cmd = "Edit";
                        break;
                    case "delete":
                        $cmd = "Delete";
                        break;
                    case "input":
                        $cmd = "Input";
                        break;
                    default:
                        echo "Http 404";
                        exit();
                }
            }
            if (isset($_GET['class'])) {
                $func = $_GET["class"] . $cmd;
                $func()->printv();
            }
            ?>

            <div id="footer">
                <p> © 2011 www.sugu.com. Basado en el diseño de <a href="http://www.nodethirtythree.com">nodethirtythree</a> y <a href="http://www.freecsstemplates.org">Free CSS Templates</a>. Modificado por SIR <img id="logoFooter" src="../resources/images/logo-SIR.png" alt="" /> Sistemas Integrales Roraima.</p>
            </div>
            <!-- end #footer -->
    </body>
</html>
