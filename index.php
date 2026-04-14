<?php
require('dbEvent.php');
require('usuarios.php');
require('FuncionesEventos.php');


session_start();

// Variables de sesión
$id_user = $_SESSION['usuario']['usuario_id'] ?? null;
$usuario = $_SESSION['usuario']['nombre']     ?? null;

// --- Login ---
if (isset($_POST['Entrar'])) {
    $usuarioData = obtenerUsuario($_POST['correo'], $_POST['contraseña']);
    if ($usuarioData) {
        Entrar($usuarioData);
    } else {
        echo '<script>alert("El usuario o contraseña no son correctos"); window.location.href="index.php";</script>';
    }
}

// --- Registro ---
if (isset($_POST['CrearCuenta'])) {
    if (
        strlen($_POST['contraseña']) >= 1 &&
        strlen($_POST['correo'])     >= 1 &&
        strlen($_POST['nombre'])     >= 1
    ) {
        crearUsuarios($_POST['contraseña'], $_POST['correo'], $_POST['nombre']);
    }
}

comprobarUsuarios();

// Datos para la página
$list_Ultimos    = ListarUltimosEventos();
$list_Destacados = ListarEventosDestacados();

//BUSCAR EVENTOS
$texto = $_GET["q"] ?? "";



$eventos = listarEventos($texto);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="TemplateMo">
  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
  <link rel="icon" href="icon.png">
  <title>Proyecto DAW</title>

  <!-- Bootstrap -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos propios -->
  <link rel="stylesheet" href="assets/css/fontawesome.css">
  <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
  <link rel="stylesheet" href="assets/css/owl.css">
  <link rel="stylesheet" href="assets/css/lightbox.css">
  <link rel="stylesheet" href="assets/css/EstilosModales.css">
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


<!-- ===== BANNER ===== -->
<section class="section main-banner" id="top" data-section="section1">
  <video autoplay muted loop id="bg-video">
    <source src="assets/images/course-video.mp4" type="video/mp4">
  </video>
  <div class="video-overlay header-text">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="caption">
            <h2>Bienvenidos</h2>
            <p>"Encuentra la emoción en cada evento: ¡Descubre y vive experiencias inolvidables en nuestra web!"</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ===== FIN BANNER ===== -->


<!-- ===== SERVICIOS ===== -->
<section class="services">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="owl-service-item owl-carousel">

          <?php
          $servicios = [
              ['img' => 'service-icon-01.png', 'titulo' => 'Variedad de eventos',              'desc' => 'Ofrece una amplia gama de eventos para diferentes audiencias.'],
              ['img' => 'service-icon-02.png', 'titulo' => 'Experiencia de usuario intuitiva', 'desc' => 'Diseña una interfaz sencilla y fácil de navegar.'],
              ['img' => 'service-icon-03.png', 'titulo' => 'Información detallada y actualizada','desc' => 'Incluye información relevante y atractiva en las páginas de eventos.'],
              ['img' => 'service-icon-02.png', 'titulo' => 'Funciones de búsqueda y filtrado', 'desc' => 'Proporciona descripciones y detalles actualizados de los eventos.'],
              ['img' => 'service-icon-03.png', 'titulo' => 'Crea tu evento con nosotros',      'desc' => 'Implementa herramientas de búsqueda avanzada y filtros.'],
          ];
          foreach ($servicios as $s): ?>
            <div class="item">
              <div class="icon">
                <img src="assets/images/<?= $s['img'] ?>" alt="<?= $s['titulo'] ?>">
              </div>
              <div class="down-content">
                <h4><?= $s['titulo'] ?></h4>
                <p><?= $s['desc'] ?></p>
              </div>
            </div>
          <?php endforeach; ?>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- ===== FIN SERVICIOS ===== -->


<!-- ===== PRÓXIMOS EVENTOS ===== -->
<section class="upcoming-meetings" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading">
          <h2>Próximos Eventos</h2>
        </div>
      </div>

      <!-- Categorías -->
      <div class="col-lg-4">
        <div class="categories">
          <h4>Categorías</h4>
          <ul>
            <?php
            $categorias = ['deportes','conciertos','viajes','competiciones','motor','cultura','otros'];
            foreach ($categorias as $cat): ?>
              <li><a href="ListaEventos.php?category=<?= $cat ?>"><?= ucfirst($cat) ?></a></li><br>
            <?php endforeach; ?>
            <li><a href="ListaEventos.php">Ver más</a></li>
          </ul>
        </div>
      </div>

      <!-- Cards de eventos -->
      <div class="col-lg-8">
        <div class="row">
          <?php foreach ($list_Ultimos as $evento):
            $fecha = new DateTime($evento->fecha);
          ?>
            <div class="col-lg-6 card-evento">
              <div class="meeting-item">
                <div class="thumb">
                  <img src="<?= $evento->imagen ?>" alt="Event Image">
                </div>
                <div class="down-content">
                  <div class="meeting-content">
                    <div class="date">
                      <h6><?= $fecha->format('M') ?> <span><?= $fecha->format('d') ?></span></h6>
                    </div>
                    <div class="info">
                      <h4><?= htmlspecialchars($evento->nomevent) ?></h4>
                      <p><strong>Localización:</strong> <?= htmlspecialchars($evento->localizacion) ?></p>
                      <p><strong>Entrada:</strong> <?= htmlspecialchars($evento->entrada) ?></p>
                      <p><strong>Categoría:</strong> <?= htmlspecialchars($evento->categoria) ?></p>
                      <a href="meeting-details.php?id=<?= $evento->id ?>" class="btn-link-anim">Más Información</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </div>
</section>
<!-- ===== FIN PRÓXIMOS EVENTOS ===== -->


<!-- ===== EVENTOS DESTACADOS ===== -->
<section class="our-courses" id="courses">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading">
          <h2>Eventos más destacados</h2>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="owl-courses-item owl-carousel">
          <?php foreach ($list_Destacados as $evento): ?>
            <div class="item">
              <img src="<?= $evento->imagen ?>" alt="Event Image">
              <div class="down-content">
                <h4><?= htmlspecialchars($evento->nomevent) ?></h4>
                <div class="info">
                  <div class="row">
                    <div class="col-8">
                      <!-- 5 estrellas generadas en un solo bucle -->
                      <ul>
                        <?php for ($i = 0; $i < 5; $i++): ?>
                          <li><i class="fa fa-star"></i></li>
                        <?php endfor; ?>
                      </ul>
                    </div>
                    <div class="col-4">
                      <span><?= htmlspecialchars($evento->entrada) ?></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- ===== FIN EVENTOS DESTACADOS ===== -->


<!-- ===== CONTACTO ===== -->
  <section class="contact-us" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>Contacta con nosotros</h2>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                      <input name="name" type="text" id="name" placeholder="Nombre..." required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                    <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Correo..." required="">
                  </fieldset>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                      <input name="subject" type="text" id="subject" placeholder="Asunto..." required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" type="text" class="form-control" id="message" placeholder="Mensaje..." required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="button">Enviar mensaje</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="right-info">
            <ul>
              <li>
                <h6>Número de telefono</h6>
                <span>673-020-0340</span>
              </li>
              <li>
                <h6>Correo de contacto</h6>
                <span>PEvent@ionos.com</span>
              </li>
              <li>
                <h6>Dirección</h6>
                <span>Prta del Sol, s/n, 28013 Madrid, España</span>
              </li>
            </ul>
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
  </section>
<!-- ===== FIN CONTACTO ===== -->


<!-- Scripts -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/lightbox.js"></script>
<script src="assets/js/tabs.js"></script>
<script src="assets/js/video.js"></script>
<script src="assets/js/slick-slider.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/script.js"></script>

<script>
  // Scroll a sección
  $('.nav li:first').addClass('active');

  var showSection = function(section, animate) {
    var pos = $('.section').filter('[data-section="' + section.replace(/#/, '') + '"]').offset().top;
    if (animate) {
      $('body, html').animate({ scrollTop: pos }, 800);
    } else {
      $('body, html').scrollTop(pos);
    }
  };

  var checkSection = function() {
    $('.section').each(function() {
      var top   = $(this).offset().top - 80;
      var bot   = top + $(this).height();
      var scroll= $(window).scrollTop();
      if (top < scroll && bot > scroll) {
        $('a[href*=\\#' + $(this).data('section') + ']')
          .closest('li').addClass('active').siblings().removeClass('active');
      }
    });
  };

  $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function(e) {
    e.preventDefault();
    showSection($(this).attr('href'), true);
  });

  $(window).scroll(checkSection);
</script>
</body>
</html>