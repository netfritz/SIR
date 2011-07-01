<?php
require_once("ClassAlbum.php");
/*
 * Fachada logica para el modulo Gestion de Fotos
 * Version 1.0
 */
// Hay que hacer que esto sea una clase singleton
function crearAlbum($nombre,$lugar,$propietario){
    $album=new  Album($nombre,$lugar);
    if ($album.existe()== true )
        return FALSE;
    $album.saveAlbum();
} 
function crearAlbum($nombre){
    $album=new  Album($nombre);
    $album.saveAlbum();
} 

?>
