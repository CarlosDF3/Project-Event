<?php
require ('usuarios.php');
session_start();

if (!isset ($_SESSION["usuario"])){
    echo '<script language="javascript">alert("Debes iniciar sesión para crear eventos.");window.location.href="index.php"</script>';
    exit();

}
else{
    header("Location: formEvento.php");
}
   
?> 