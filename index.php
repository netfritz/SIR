<!-- El header va aqui -->

<html>
<head>
<title>SUGU -  Sistema Universal de Gestion Universitaria</title>
<body>

<h3>SUGU -  Sistema Universal de Gestion Universitaria</h3>

<ul>
<li><a href="index.php?class=universidad">Universidad</a></li>
<li><a href="index.php?class=carrera">Carrera</a></li>
<li><a href="index.php?class=profesor">Profesor</a></li>
<li><a href="index.php?class=estudiante">Estudiante</a></li>
<li><a href="index.php?class=materia">Materia</a></li>
<li><a href="index.php?class=departamento">Departamento</a></li>
<li><a href="index.php?class=agrupacion">Agrupaciones</a></li>
</ul>

<?php

   //require_once("func_carrera.php");

$reg = "(universidad|agrupacion|carrera|departamento|profesor|estudiante|materia)";

if (!preg_match($reg,$_GET["class"])) {
  echo "Http 404";
  exit();
} else {
  require_once("func/func_". $_GET["class"] . ".php");
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

$func = $_GET["class"].$cmd;
$func();

?>

<!-- El footer va aqui -->
