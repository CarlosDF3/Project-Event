<?php
session_start();
require('dbEvent.php');

$id_user = $_SESSION["usuario"]["usuario_id"];

if(isset($_FILES["imagen"])){

    $nombre = $_FILES["imagen"]["name"];
    $tmp = $_FILES["imagen"]["tmp_name"];

    // ruta donde guardar
    $ruta = "imagenes_perfil/" . time() . "_" . $nombre;

    move_uploaded_file($tmp, $ruta);

    // guardar en BD
    $consulta = "UPDATE usuarios SET imagen='$ruta' WHERE usuario_id='$id_user'";
    mysqli_query($conexion, $consulta);

    header("Location: PaginaPerfil.php");
}
?>