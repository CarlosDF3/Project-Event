<?php
require('dbEvent.php');
require('usuarios.php');

session_start();

$error = "";

if (isset($_POST['Entrar'])) {

    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    $usuarioData = obtenerUsuario($correo, $contraseña);

    if ($usuarioData) {
        Entrar($usuarioData);
        header("Location: index.php");
        exit;
    } else {
        $error = "El usuario o contraseña no son correctos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Login</title>

<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/EstiloLogin-R.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

<div class="login-bg"></div>

<div class="login-box">

    <h1>Bienvenido a Project Event</h1>
    <p class="welcome">Inicia sesión para continuar</p>

    <?php if (!empty($error)): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">

        <div class="input-contenedor">
            <i class="fas fa-user"></i>
            <input type="text" name="correo" placeholder="Correo">
        </div>

        <div class="input-contenedor">
            <i class="fas fa-key"></i>
            <input type="password" name="contraseña" placeholder="Contraseña">
        </div>

        <input type="submit" name="Entrar" value="Iniciar Sesión" class="button">

    </form>
    <p class="register">
        ¿No estás registrado?
        <a href="Register.php">Crear cuenta</a>
    </p>

</div>

</body>
</html>