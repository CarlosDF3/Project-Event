<?php

session_start();
session_destroy();

unset($_COOKIE['cookie_usuario']);
setcookie ('cookie_usuario', $nombre_usuario, time() - 3600, '/');


header("Location: index.php"); //Cuidado con la url si se mueven los archivos de carpeta.
exit();
?>