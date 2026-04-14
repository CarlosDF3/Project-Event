<?php
require('dbEvent.php');
require('usuarios.php');

session_start();

$error = "";

// ------------ REGISTRO -------------
if (isset($_POST['CrearCuenta'])) {

    $resultado = crearUsuarios(
        $_POST['contraseña'] ?? '',
        $_POST['correo'] ?? '',
        $_POST['nombre'] ?? ''
    );

    if ($resultado) {
        header("Location: Login.php?registro=ok");
        exit;
    }

    global $error;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<title>Registro</title>

<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/EstiloLogin-R.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

<div class="login-bg"></div>

<div class="login-box">

    <h1>Regístrate</h1>

    <p class="welcome">Bienvenido a Project Event</p>

    <?php if (!empty($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <div class="input-contenedor">
            <i class="fas fa-user"></i>
            <input type="text" name="nombre" placeholder="Nombre Completo" required>
        </div>

        <div class="input-contenedor">
            <i class="fas fa-envelope"></i>
            <input type="email" name="correo" placeholder="Correo Electrónico" required>
        </div>

        <div class="input-contenedor">
            <i class="fas fa-key"></i>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
        </div>

        <button type="submit" name="CrearCuenta" class="button">
            Regístrate
        </button>

    </form>

    <div class="register">
        ¿Ya tienes una cuenta?
        <a href="Login.php">Inicia sesión</a>
    </div>

</div>

</body>
</html>