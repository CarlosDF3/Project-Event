<?php
class Perfil{
    public $correo;
    public $nombre;
    public $fecha;
    public $imagen;
function __construct($correo, $nombre , $fecha, $imagen){
    $this -> correo = $correo;
    $this -> nombre = $nombre;
    $this -> fecha = $fecha;
    $this -> imagen = $imagen;
}
}


?>