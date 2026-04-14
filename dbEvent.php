<?php

$conexion = @mysqli_connect("localhost", "root", null, "event");

if (!$conexion)
{
    die ("Error de conexión");
}
?>