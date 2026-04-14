<?php
require ('dbEvent.php');
require ('FuncionesEventos.php');

session_start();

$id_user = $_SESSION["usuario"]["usuario_id"] ?? null;
$usuario = $_SESSION["usuario"]["nombre"] ?? null;

// MODO EDICIÓN
$modoEdicion = false;
$evento = null;

if (isset($_GET['id'])) {
    $modoEdicion = true;
    $evento = obtenerEventoPorId($_GET['id']);

    // Seguridad
    if ($evento->usuario_id != $id_user) {
        die("No tienes permiso para editar este evento");
    }
}

// ================= PROCESAR FORM =================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ================= ENTRADA =================
    $entrada = $_POST["entrada"] ?? "Gratis";

    $precio = null;

    if ($entrada === "Pago") {

        $precio = $_POST["precio"] ?? null;

        if ($precio === null || $precio <= 0) {
            die("El precio debe ser mayor que 0");
        }
    }

    // ================= IMAGEN =================
    $rutaImagen = null;

    if (!empty($_FILES['imagen']['name'])) {

        $rutaCarpeta = "Imagenes/";

        if (!is_dir($rutaCarpeta)) {
            mkdir($rutaCarpeta, 0777, true);
        }

        $nombreImagen = time() . "_" . $_FILES['imagen']['name'];
        $rutaImagen = $rutaCarpeta . $nombreImagen;

        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen);
    }

    // ================= OBJETO =================
    $eventoObj = new Evento(
        $_POST["id"] ?? null,
        $_POST["nomevent"] ?? null,
        $_POST["categoria"] ?? null,
        $_POST["fecha"] ?? null,
        $_POST["localizacion"] ?? null,
        $entrada,
        $_POST["descripcion"] ?? null,
        $rutaImagen,
        $id_user,
        $_POST["max_asistentes"] ?? null
    );

    // ================= EJECUCIÓN =================
    if (isset($_POST["crearEvento"])) {
        crearEvento($eventoObj);
    }

    if (isset($_POST["actualizarEvento"])) {
        actualizarEvento($eventoObj);
    }

    header("Location: PaginaPerfil.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= $modoEdicion ? "Editar evento" : "Crear evento" ?></title>

<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
<link rel="stylesheet" href="assets/css/owl.css">
<link rel="stylesheet" href="assets/css/lightbox.css">
<link rel="stylesheet" href="assets/css/EstilosPaginaEventos.css">
<link rel="stylesheet" href="assets/css/EstilosformEvento.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

<!-- HEADER -->
<header class="header-area header-sticky">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">

          <a href="index.php" class="logo">Project Event</a>

          <ul class="event-nav">
            <li class="event-user">
              <?php if (!$usuario): ?>
                <a href="Login.php">Iniciar sesión</a>
              <?php else: ?>
                <span><?= htmlspecialchars($usuario) ?></span>
              <?php endif; ?>
            </li>

            <li>
              <a href="PaginaPerfil.php">Perfil</a>
            </li>
          </ul>

        </nav>
      </div>
    </div>
  </div>
</header>

<!-- FORM -->
<section class="upcoming-meetings">

  <div id="cajaGlobal">
    <div class="divEvento">

    <h1 class="titulo">
    <?= $modoEdicion ? "Editar evento" : "Crea un evento nuevo" ?>
    </h1>

    <form method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?= $modoEdicion ? $evento->id : '' ?>">

    <input class="datos2" type="text" name="nomevent" required
    value="<?= $modoEdicion ? htmlspecialchars($evento->nomevent) : '' ?>"
    placeholder="Nombre del evento">

    <select class="datos2" name="categoria" required>
      <option value="">Seleccione la categoría</option>
        <?php
        $categorias = ["deportes","conciertos","viajes","competiciones","motor","cultura","otros"];
        foreach ($categorias as $cat):
        ?>
      <option value="<?= $cat ?>" 
        <?= ($modoEdicion && $evento->categoria == $cat) ? "selected" : "" ?>>
        <?= ucfirst($cat) ?>
      </option>
      <?php endforeach; ?>
    </select>

    <input class="datos2" type="date" name="fecha" required
      value="<?= $modoEdicion ? $evento->fecha : '' ?>">

    <input class="datos2" type="text" name="localizacion" required
      value="<?= $modoEdicion ? htmlspecialchars($evento->localizacion) : '' ?>"
      placeholder="Localización">

    <input class="datos2" type="number" name="max_asistentes"
      value="<?= $modoEdicion ? $evento->max_asistentes : '' ?>"
      placeholder="Máx asistentes">

    <!-- Entrada -->
    <div>
      <input id="gratis" type="radio" name="entrada" value="Gratis"
        <?= ($modoEdicion && $evento->entrada == null) ? "checked" : "" ?> required>
      <label for="gratis">Gratis</label>

      <input id="pago" type="radio" name="entrada" value="Pago"
        <?= ($modoEdicion && $evento->entrada != null) ? "checked" : "" ?> required>
      <label for="pago">Pago</label>
    </div>

    <input class="datos2" type="number" step="0.01" name="precio"
      id="precio"
      value="<?= $modoEdicion ? $evento->entrada : '' ?>"
      placeholder="Precio (€)">

    <textarea class="datos4" name="descripcion" required
      placeholder="Descripción"><?= 
      $modoEdicion ? htmlspecialchars($evento->descripcion) : '' ?></textarea>

    <!-- Imagen -->
    <?php if ($modoEdicion && $evento->imagen): ?>
        <p>Imagen actual:</p>
        <img src="<?= $evento->imagen ?>" width="150">
    <?php endif; ?>

    <input class="datos2" type="file" name="imagen">

    <input class="boton" type="submit"
    name="<?= $modoEdicion ? 'actualizarEvento' : 'crearEvento' ?>"
    value="<?= $modoEdicion ? 'Actualizar Evento' : 'Crear Evento' ?>">

    </form>

    </div>
  </div>

</section>

<!-- SCRIPTS -->
<script>
// Mostrar precio solo si es pago
const gratis = document.getElementById("gratis");
const pago = document.getElementById("pago");
const precio = document.getElementById("precio");

function togglePrecio() {
    if (pago.checked) {
        precio.style.display = "block";
    } else {
        precio.style.display = "none";
        precio.value = "";
    }
}

gratis.addEventListener("change", togglePrecio);
pago.addEventListener("change", togglePrecio);

// Ejecutar al cargar
window.onload = togglePrecio;
</script>

</body>
</html>