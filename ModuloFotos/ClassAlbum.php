<?php

/**
 * Clase abstracta que describe un album, este podra ser instanciado 
 * dependiendo de su relación con un ente en particular que podria ser
 * un perfil, un muro, un evento o un grupo.
 * @author jennifer DOSREIS
 */
abstract class ClassAlbum {
    private $nombre; // Nombre del album
    private $lugar; // Lugar especificado para describir el album
    private $fotos; // Arreglo de fotos
    
    public function __construct($nombre,$lugar){
        $this->nombre= $nombre;
        $this->lugar= $lugar;
        $this->fotos= array();
    }    
    public function __construct($nombre){
        $this->nombre= $nombre;
        $this->lugar= NULL;
        $this->fotos= array();
    }
    public function saveAlbum(){
        si ya existe un album en perfil con ese nombre entonces actualizar
        si no existe guardar 
    }
    
}

?>
