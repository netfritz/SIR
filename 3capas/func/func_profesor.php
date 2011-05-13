<?php

require_once("/class/model/Profesor.php");
require_once("interfaz_profesor.php");

function profesorInput() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $obj = Profesor::getByKey($_POST["id"], $_POST["dep"]);
        return new interfazProfesorForm($obj, FALSE);
    } else {
        // Insertar nuevo
        return new interfazProfesorForm();
    }
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
        return new interfazProfesorAll(Profesor::all()
                , array("Ya existe un profesor con ese Documento de Identidad
            en ese Departamento"));
    } else {
        return new interfazProfesorAll(Profesor::all()
                , array("Se ha agregado un nuevo profesor"));
    }
}

function profesorAll() {
    return new interfazProfesorAll(Profesor::all());
}

function profesorEdit() {
    $obj = Profesor::getByKey($_POST["id"], $_POST["dep"]);
    $obj->setCarnet($_POST["carnet"]);
    $obj->setNombre($_POST["nombre"]);
    $obj->setApellido($_POST["apellido"]);
    $obj->setTitulo($_POST["titulo"]);
    $obj->save();
    return new interfazProfesorAll(Profesor::all()
            , array("Se ha modificado exitosamente un profesor"));
}

function profesorDelete() {
    $obj = Profesor::getByKey($_POST["id"], $_POST["dep"]);
    $obj->delete();
    return new interfazProfesorAll(Profesor::all()
            , array("El profesor " . $obj->getNombre() . " " . $obj->getApellido() .
        " ha sido eliminado"));
}

?>