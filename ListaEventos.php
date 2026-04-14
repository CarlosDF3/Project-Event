<?php
require ('dbEvent.php');
require ('FuncionesEventos.php');
require ('usuarios.php');

session_start();
comprobarUsuarios();

$texto = $_GET["q"] ?? null;

if (!empty($texto)) {
    $listado_db = listarEventos($texto); // búsqueda
} else {
    $listado_db = listarEventos(); // normal
}

?>

<?php
$id_user = $_SESSION["usuario"]["usuario_id"] ?? null;
$usuario = $_SESSION["usuario"]["nombre"] ?? null;

if (isset($_POST["Entrar"])) {
    $usuarioLogin = obtenerUsuario($_POST["correo"], $_POST["contraseña"]);

    if ($usuarioLogin) {
        Entrar($usuarioLogin);
    } else {
        echo '<script>alert("Usuario o contraseña incorrectos");</script>';
    }
}

if (isset($_POST["CrearCuenta"])) {
    if (!empty($_POST["contraseña"]) && !empty($_POST["correo"]) && !empty($_POST["nombre"])) {
        crearUsuarios($_POST["contraseña"], $_POST["correo"], $_POST["nombre"]);
    }
}

function renderModal(string $id, string $titulo, array $campos, string $submitName, string $submitLabel, string $footer): void
{
    $self = htmlspecialchars($_SERVER['PHP_SELF']);
    echo <<<HTML
    <dialog id="{$id}">
      <button class="popup-close" onclick="closeModal('{$id}')">&times;</button>
      <h1 class="h1">{$titulo}</h1>
      <div class="contenedor">
        <form action="{$self}" method="post">
    HTML;

    foreach ($campos as $campo) {
        echo <<<HTML
          <div class="input-contenedor">
            <i class="{$campo['icon']} icon"></i>
            <input type="{$campo['type']}" name="{$campo['name']}" placeholder="{$campo['placeholder']}">
          </div>
        HTML;
    }

    echo <<<HTML
          <input type="submit" name="{$submitName}" value="{$submitLabel}" class="buttonModal">
        </form>
      </div>
      <br>
      {$footer}
    </dialog>
    HTML;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Proyecto DAW</title>

<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/fontawesome.css">
<link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
<link rel="stylesheet" href="assets/css/owl.css">
<link rel="stylesheet" href="assets/css/lightbox.css">
<link rel="stylesheet" href="assets/css/EstilosPaginaEventos.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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

<!-- ================= EVENTOS ================= -->
<section class="upcoming-meetings" id="meetings">
  <div class="container">
    <div class="row">

      <?php foreach ($listado_db as $evento): ?>

        <div class="col-lg-4 templatemo-item-col all <?php echo $evento->categoria; ?>">
          <div class="meeting-item">

            <div class="thumb">
              <div class="price">
                <span><?php echo $evento->entrada; ?></span>
              </div>

              <img src="<?php echo $evento->imagen; ?>" alt="">
            </div>

            <div class="down-content">

              <?php $fecha = new DateTime($evento->fecha); ?>

              <div class="meeting-content">

                <div class="date">
                  <h6><?php echo $fecha->format('M'); ?>
                    <span><?php echo $fecha->format('d'); ?></span>
                  </h6>
                </div>

                <div class="info">
                  <h4><?= htmlspecialchars($evento->nomevent) ?></h4>
                  <p><strong>Localización:</strong> <?= htmlspecialchars($evento->localizacion) ?></p>
                  <p><strong>Entrada:</strong> <?= htmlspecialchars($evento->entrada) ?></p>
                  <p><strong>Categoría:</strong> <?= htmlspecialchars($evento->categoria) ?></p>
                  <a href="meeting-details.php?id=<?= $evento->id ?>" class="btn-link-anim">Más Información</a>
                </div>

              </div>

              <div class="cajaEventoUnirse">

                <?php if (UsuarioUnido($evento->id, $id_user)): ?>
                  <button class="btnU abandonando" data-id="<?= $evento->id ?>">
                    Abandonar
                  </button>
                <?php else: ?>
                  <button class="btnU uniendose" data-id="<?= $evento->id ?>">
                    Unirse
                  </button>
                <?php endif; ?>

                <span class="unirse">
                  <i class="bi bi-person-fill"></i>
                  <?php echo obtenerUnion($evento->id); ?>
                </span>

              </div>

            </div>
          </div>
        </div>

      <?php endforeach; ?>

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
</section>

<!-- ================= SCRIPTS ================= -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="assets/js/script.js"></script>

<script>

  // UNIRSE AJAX
  document.querySelectorAll(".btnU").forEach(btn => {

    btn.addEventListener("click", function () {

      const id = this.dataset.id;

          fetch("unirseEvento.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          id_evento: id,
          action: "unirse"
        })
      })
      .then(res => res.text()) 
      .then(data => {
        console.log("RESPUESTA RAW:", data);
      })
      .catch(err => console.error(err));

    });

  });


document.querySelectorAll(".btnU").forEach(btn => {

  btn.addEventListener("click", function () {

    const id = this.dataset.id;
    const estaUnido = this.classList.contains("abandonando");

    const action = estaUnido ? "abandonar" : "unirse";

    fetch("unirseEvento.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: new URLSearchParams({
        id_evento: id,
        action: action
      })
    })
    .then(res => res.json())
    .then(data => {

      console.log(data);

      if (!data.success) {
        console.error(data.error);
        return;
      }

      // actualizar UI 
      if (action === "unirse") {
        this.textContent = "Abandonar";
        this.classList.remove("uniendose");
        this.classList.add("abandonando");
      } else {
        this.textContent = "Unirse";
        this.classList.remove("abandonando");
        this.classList.add("uniendose");
      }

      // actualizar contador si existe
      const contador = this.parentElement.querySelector(".unirse");
      if (contador && data.unidos !== undefined) {
        contador.innerHTML = '<i class="bi bi-person-fill"></i> ' + data.unidos;
      }

    })
    .catch(err => console.error("FETCH ERROR:", err));

  });

});
</script>

</body>
</html>
