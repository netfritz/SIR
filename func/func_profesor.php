<?php

require_once("/class/model/Profesor.php");

function profesorInput() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $obj = Profesor::getByKey($_POST["id"], $_POST["dep"]);
        echo "<form action=\"index.php?class=profesor&cmd=edit\" method=\"post\">
        <input type=\"hidden\" name=\"id\" value=\"{$_POST["id"]}\">
        <input type=\"hidden\" name=\"dep\" value=\"{$_POST["dep"]}\">
        </br>
        </br>
        Documento de Identidad: &#160 {$_POST["id"]}</br>
        Código de Departamento: &#160 {$_POST["dep"]}</br>";
        profesorFields($obj->getCarnet(), $obj->getNombre(), $obj->getApellido(), $obj->getTitulo());
    } else {
        // Insertar nuevo
        echo "<form action=\"index.php?class=profesor&cmd=insert\" method=\"post\">
        </br>
        </br>
        Documento de Identidad: <input type=\"text\" name=\"id\"/></br>
        Código de Departamento: <input type=\"text\" name=\"dep\"></br>";
        profesorFields("", "", "", "");
    }
    echo "<input type=\"submit\" value=\"Enviar\" />";
}

// Imprime por pantalla un formulario con un campo para cada atributo necesario
// de la clase. Permite que se le de un valor inicial a cada campo
function profesorFields($carnet, $nombre, $apellido, $titulo) {
    echo "   
        Carnet: <input type=\"text\" name=\"carnet\" value=\"" . $carnet . "\" /></br>
        Nombre: <input type=\"text\" name=\"nombre\" value=\"" . $nombre . "\" /></br>
        Apellido: <input type=\"text\" name=\"apellido\" value=\"" . $apellido . "\" /></br>
        Titulo: <input type=\"text\" name=\"titulo\" value=\"" . $titulo . "\" /></br>";
}

function profesorInsert() {
    $obj = new Profesor($_POST["id"],
                    $_POST["dep"],
                    $_POST["carnet"],
                    $_POST["nombre"],
                    $_POST["apellido"],
                    $_POST["titulo"]);
    $ret = $obj->save();
    if ($ret) {
        echo " </br> </br> Ya existe un profesor con ese Documento de Identidad
            en ese Departamento";
    } else {
        echo "Se ha agregado un nuevo profesor </br>";
    }
    profesorAll();
}

function profesorAll() {
    echo "</br><a href=\"index.php?class=profesor&cmd=input\">Insertar nuevo profesor</a></br>";
    $res = Profesor::all();
    if (empty($res)) {
        echo "No existen profesores registrados actualmente.";
    } else {

        echo "<table>
              <tr>
              <th> Documento de Identidad </th>
              <th> Departamento </th>
              <th> Carnet </th>
              <th> Nombre </th>
              <th> Apellido </th>
              <th> Titulo </th>
              </tr>";
        foreach ($res as $ind) {
            $id = $ind->getDocumento_id();
            $dpto = $ind->getDpto();
            echo "<tr>
                  <td>" . $id . "</td>
                  <td>" . $dpto . "</td>
                  <td>" . $ind->getCarnet() . "</td>
                  <td>" . $ind->getNombre() . "</td>
                  <td>" . $ind->getApellido() . "</td>
                  <td>" . $ind->getTitulo() . "</td>
                  <td>
                  <form action=\"index.php?class=profesor&cmd=input\" method=\"post\">
                  <input type=\"hidden\" name=\"id\" value=\"" . $id . "\" />
                  <input type=\"hidden\" name=\"dep\" value=\"" . $dpto . "\" />
                  <input type=\"submit\" value=\"Editar\" />
                  </form>
                  </td>
                  <td>
                  <form action=\"index.php?class=profesor&cmd=delete\" method=\"post\">
                  <input type=\"hidden\" name=\"id\" value=\"" . $id . "\" />
                  <input type=\"hidden\" name=\"dep\" value=\"" . $dpto . "\" />
                  <input type=\"submit\" value=\"Eliminar\" />
                  </td>
                  </tr>";
        }
        echo "</table>";
    }
}

function profesorEdit() {
    $obj = Profesor::getByKey($_POST["id"], $_POST["dep"]);
    $obj->setCarnet($_POST["carnet"]);
    $obj->setNombre($_POST["nombre"]);
    $obj->setApellido($_POST["apellido"]);
    $obj->setTitulo($_POST["titulo"]);
    $obj->save();
    echo "Se ha modificado exitosamente un profesor </br>";
    profesorAll();
}

function profesorDelete() {
    $obj = Profesor::getByKey($_POST["id"], $_POST["dep"]);
    $obj->delete();
    echo "</br></br>El profesor " . $obj->getNombre() . " " . $obj->getApellido() .
    " ha sido eliminado </br>";
    profesorAll();
}

?>