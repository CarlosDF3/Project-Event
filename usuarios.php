<?php
include ('dbEvent.php');
include ('Perfil.php');

//Esta función comprueba si hay un usuario conectado. Y si lo hay, guarda sus datos en una COOKIE.
function comprobarUsuarios(){
   if (!isset ($_SESSION["usuario"]) && isset ($_COOKIE["cookie_usuario"])){
        $_SESSION["usuario"] = obtenerUsuarioPorId($_COOKIE["cookie_usuario"]);
   }
}
//Aquí obtenemos los datos de usuario por su ID.
function obtenerUsuarioPorId($id){
    global $conexion;
    $consulta = "SELECT usuario_id, nombre, correo FROM usuarios WHERE id = ?";
    $stmt = $conexion -> prepare ($consulta);
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $resultado = $stmt -> get_result();
    
    if ($resultado)
    {
        $usuario_db = mysqli_fetch_assoc($resultado);
        return $usuario_db;
    }
}

function obtenerUsuario($correo, $contraseña) {

    global $conexion;

    $correo = trim($correo);

    $consulta = "SELECT usuario_id, nombre, correo, contraseña 
                 FROM usuarios 
                 WHERE LOWER(correo) = LOWER(?)";

    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param('s', $correo);
    $stmt->execute();

    $resultado = $stmt->get_result();

    $usuario_db = $resultado->fetch_assoc();

    if (!$usuario_db) {
        return false;
    }

    if (password_verify($contraseña, $usuario_db['contraseña'])) {
        unset($usuario_db['contraseña']);
        return $usuario_db;
    }

    return false;
}

//Esta función es usada para comprobar si el ID de usuario es igual al de la base de datos y poder entrar al perfil.
function Entrar($usuario){
      $id_usuario = $usuario["usuario_id"];
      $_SESSION ["usuario"] = $usuario;
      setcookie ('cookie_usuario', $id_usuario, time() - 3600, '/');
      header("Location: index.php"); //Cuidado con la ruta si se mueven los archivos de carpeta.
      exit();
}

//Aquí realizamos la query que usamos para registrar usuarios nuevos.
function crearUsuarios ($contraseña, $correo, $nombre){

    global $conexion;
    global $error;

    $error = "";

    // VALIDACIONES
    if (empty($correo) || empty($contraseña) || empty($nombre)) {
        $error = "Todos los campos son obligatorios";
        return false;
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error = "Correo inválido";
        return false;
    }

    if (strlen($contraseña) < 6) {
        $error = "La contraseña debe tener al menos 6 caracteres";
        return false;
    }

    // COMPROBAR SI EL USUARIO YA EXISTE
    $stmt = $conexion->prepare("SELECT usuario_id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error = "Este correo ya está registrado";
        return false;
    }

    // ENCRIPTAR CONTRASEÑA 
    $passwordHash = password_hash($contraseña, PASSWORD_DEFAULT);

    // FECHA
    date_default_timezone_set('Europe/Madrid');
    $fecha_actual = date("Y-m-d");

    // INSERT SEGURO
    $stmt = $conexion->prepare("
        INSERT INTO usuarios (contraseña, correo, nombre, fecha)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("ssss", $passwordHash, $correo, $nombre, $fecha_actual);

    if ($stmt->execute()) {
        return true;
    } else {
        $error = "Error al crear usuario";
        return false;
    }
}

//Esta función es empleada para imprimir los datos de usuario en su perfil.
function obtenerDatosPerfil(){
    
    global $conexion;

    $user = $_SESSION["usuario"]["usuario_id"]; //He cambiado el nombre por la id.

    $consulta = "SELECT correo, nombre, fecha, imagen FROM usuarios WHERE usuario_id = '".$user."'";
    
    $resultado = mysqli_query($conexion, $consulta);

    $perfil = array();

    if ($resultado){
        
        while ($fila = mysqli_fetch_assoc($resultado))
        {
           $nuevoPerfil = new Perfil ($fila ["correo"], $fila ["nombre"], $fila ["fecha"], $fila ["imagen"]);
           array_push ($perfil, $nuevoPerfil);
        }
        return $perfil;
    }

    else
    {
        echo $conexion -> error;
    }
   
}
?>