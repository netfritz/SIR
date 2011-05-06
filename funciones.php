<?php

function __autoload($class_name) {
    include $class_name . '.php';
}

function carreraInsert() {

}

function carreraFinsert() {

}

function carreraAll() {
  $res = Carrera::all();
  foreach ($res as $ind) {
    echo "Carrera: " . $ind;
  }
}

function carreraEdit() {

}

function carreraFedit() {

}

function carreraDelete() {

}

?>