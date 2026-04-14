
<?php
class Evento{
    public $id;
    public $nomevent;
    public $categoria;
    public $fecha;
    public $localizacion;
    public $entrada;
    public $descripcion;
    public $imagen;
    public $usuario_id;
    public $max_asistentes;

function __construct($id, $nomevent, $categoria , $fecha, $localizacion, $entrada, $descripcion, $imagen, $usuario_id, $max_asistentes){
    $this -> id = $id;
    $this -> nomevent = $nomevent;
    $this -> categoria = $categoria;
    $this -> fecha = $fecha;
    $this -> localizacion = $localizacion;
    $this -> entrada = $entrada;
    $this -> descripcion = $descripcion;
    $this -> imagen = $imagen;
    $this -> usuario_id = $usuario_id;
    $this -> max_asistentes = $max_asistentes;   

}
}
?>