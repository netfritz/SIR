<!-- El header va aqui -->

<html>
<body>
<ul>
<li>Universidad</li>
<li><a href="index.php?class=carrera">Carrera</a></li>
<li>Bla</li>
</ul>

<?php

require_once("funciones.php");

$reg = "(universidad|agrupacion|carrera|departamento|profesor|estudiante|materia)";

if (!preg_match($reg,$_GET["class"])) {
  echo "Http 404";
  exit();
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