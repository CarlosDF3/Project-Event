<?php
require('dbEvent.php');
require('usuarios.php');
require('FuncionesEventos.php');

session_start();

if (isset($_GET['eliminar_id'])) {
    eliminarEventosPerfil($_GET['eliminar_id']);
}

$id_user = $_SESSION["usuario"]["usuario_id"] ?? null;
$usuario  = $_SESSION["usuario"]["nombre"] ?? null;



comprobarUsuarios();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$tuPerfil   = obtenerDatosPerfil();
$EventosJoin = listarEventosUnidos();

$user = $usuario;
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Perfil de Usuario</title>

<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
<link rel="stylesheet" href="assets/css/owl.css">
<link rel="stylesheet" href="assets/css/lightbox.css">
<link rel="stylesheet" href="assets/css/EstilosPerfil.css">
</head>

<body>

<!-- ===== HEADER ===== -->
<header class="header-area header-sticky">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <nav class="main-nav">

          <a href="index.php" class="logo">Project Event</a>

          <!-- Buscador -->
          <div class="search-container">
            <form action="ListaEventos.php" method="GET" class="search-form">
              <input type="text" name="q" placeholder="Buscar eventos..." class="search-input">
              <button type="submit" class="search-button">
                <i class="fa fa-search"></i>
              </button>
            </form>
          </div>

          <!-- NAV NUEVO -->
          <ul class="event-nav">

            <li class="event-user">
              <?php if (!$usuario): ?>
                <a href="Login.php" class="event-login-btn">Iniciar sesión</a>
              <?php else: ?>
                <button type="button" class="event-user-trigger">
                  <?= htmlspecialchars($usuario) ?>
                </button>

                <ul class="event-dropdown">
                  <li><a href="PaginaPerfil.php">Perfil</a></li>
                  <li><a href="Logout.php">Cerrar sesión</a></li>
                </ul>
              <?php endif; ?>
            </li>

            <li>
              <a href="verificarSesion.php">Crear Evento</a>
            </li>

          </ul>

        </nav>
      </div>
    </div>
  </div>
</header>
<!-- ===== FIN HEADER ===== -->

<section class="heading-page header-text" id="top"></section>

<!-- PERFIL -->
<div class="profile-container">

  <div class="profile-card">

    <?php foreach ($tuPerfil as $perfil): ?>

    <div class="profile-avatar">
        <label for="inputImagen">
            <img src="<?= $perfil->imagen ? $perfil->imagen : 'imagenes_proyecto/IconoUsuario3.png' ?>">
        </label>

        <form id="formImagen" action="subirImagen.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="imagen" id="inputImagen" style="display:none;" accept="image/*">
        </form>
    </div>

    <div class="profile-info">       
        <h2><?= htmlspecialchars($perfil->nombre) ?></h2>
        <p><strong>Correo:</strong> <?= htmlspecialchars($perfil->correo) ?></p>
        <p><strong>Miembro desde:</strong> <?= htmlspecialchars($perfil->fecha) ?></p>
    </div>

    <?php endforeach; ?>

  </div>

  <!-- TABS -->
  <div class="profile-tabs">
    <button class="tab-btn active" onclick="showTab(0)">Eventos creados</button>
    <button class="tab-btn" onclick="showTab(1)">Eventos unidos</button>
  </div>

  <div class="profile-content">

    <!-- ================= CREADOS ================= -->
    <div class="tab-panel active">
      <div class="events-grid">

        <?php
        $eventos = listarEventosPerfil();

        foreach ($eventos as $fila):
        ?>

        <div class="event-card">
          <img src="<?= $fila->imagen ?>">

          <div class="event-body">
            <h3><?= htmlspecialchars($fila->nomevent) ?></h3>
            <p><?= htmlspecialchars($fila->fecha) ?></p>
            <p><?= htmlspecialchars($fila->descripcion) ?></p>

            <div class="event-meta">
              <span><strong>Categoría:</strong> <?= htmlspecialchars($fila->categoria) ?></span>
              <span><strong>Localización:</strong> <?= htmlspecialchars($fila->localizacion) ?></span>
              <span><strong>Entrada:</strong> <?= htmlspecialchars($fila->entrada) ?></span>
            </div>

            <!-- EDITAR SOLO EN CREADOS -->
            <a class="btn-edit" href="formEvento.php?id=<?= $fila->id ?>">
                Editar
            </a>

            <a class="btn-delete" href="#" data-id="<?= $fila->id ?>">
              Borrar
            </a>
          </div>
        </div>

        <?php endforeach; ?>

      </div>
    </div>

    <!------------------ UNIDOS ------------------>
    <div class="tab-panel">
      <div class="events-grid">

        <?php foreach ($EventosJoin as $eventojoin): ?>

        <div class="event-card">
          <img src="<?= $eventojoin->imagen ?>">

          <div class="event-body">
            <h3><?= htmlspecialchars($eventojoin->nomevent) ?></h3>
            <p><?= htmlspecialchars($eventojoin->fecha) ?></p>
            <p><?= htmlspecialchars($eventojoin->descripcion) ?></p>

            <div class="event-meta">
              <span><strong>Categoría:</strong> <?= htmlspecialchars($eventojoin->categoria) ?></span>
              <span><strong>Localización:</strong> <?= htmlspecialchars($eventojoin->localizacion) ?></span>
              <span><strong>Entrada:</strong> <?= htmlspecialchars($eventojoin->entrada) ?></span>
            </div>

            <a href="#" class="btn-leave" data-id="<?= $eventojoin->id ?>">
                Abandonar
            </a>
          </div>
        </div>

        <?php endforeach; ?>

      </div>
    </div>

  </div>
</div>

<div class="footer">
      <p>Copyright @ 2023 Project Event.
          <br>Siguenos en: 
          <a href="https://twitter.com" target="_parent" title="free css templates"><i class="fa fa-twitter"></i></a>
          <a href="https://fb.com" target="_parent" title="free css templates"><i class="fa fa-facebook"></i></a>
          <a href="https://instagram.com" target="_parent" title="free css templates"><i class="fa fa-instagram"></i></a>
      </p>
  </div>

<script src="assets/js/script.js"></script>
<script>
function showTab(index){
  document.querySelectorAll(".tab-panel").forEach((tab,i)=>{
    tab.classList.toggle("active", i===index);
  });

  document.querySelectorAll(".tab-btn").forEach((btn,i)=>{
    btn.classList.toggle("active", i===index);
  });
}

document.getElementById("inputImagen").addEventListener("change", function() {
    const file = this.files[0];

    if (file) {
        // preview instantáneo
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById("previewImg").src = e.target.result;
        }
        reader.readAsDataURL(file);

        // enviar automáticamente
        document.getElementById("formImagen").submit();
    }
});
</script>

<script>

document.querySelectorAll(".btn-leave").forEach(btn => {
    btn.addEventListener("click", function(e){
        e.preventDefault();

        const id = this.dataset.id;
        const card = this.closest(".event-card");

        fetch("unirseEvento.php", { 
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                id_evento: id,
                action: "abandonar"
            })
        })
        .then(res => res.json())
        .then(data => {

            console.log(data);

            if (data.success) {
                card.remove(); // quitar de la vista
            } else {
                console.error(data.error);
            }

        })
        .catch(err => console.error(err));
    });
});

//Confirmar borrar evento
document.querySelectorAll(".btn-delete").forEach(btn => {
  btn.addEventListener("click", function (e) {
    e.preventDefault();

    const id = this.dataset.id;

    if (confirm("¿Deseas borrar este evento?")) {
      window.location.href = "PaginaPerfil.php?eliminar_id=" + id;
    }
  });
});
</script>

</body>
</html>