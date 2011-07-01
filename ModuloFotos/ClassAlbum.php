<?php

/**
 * Description of ClassAlbum
 *
 * @author jennifer DOSREIS
 */
class ClassAlbum {
    private $nombre;
    private $lugar;
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
