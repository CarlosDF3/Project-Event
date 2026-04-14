<?php
require ('usuarios.php');
require ('FuncionesEventos.php');
require ('dbEvent.php');

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



$id = $_GET["id"] ?? null;

comprobarUsuarios();
obtenerDetallesEvento($id);

?>


<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Template Mo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>Detalle del evento</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
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



<section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <?php

    $id = $_GET['id'];

    $detalleEvento = obtenerDetallesEvento($id);

    if ($detalleEvento) {

        $entrada = $detalleEvento['entrada'];
        $fecha = $detalleEvento['fecha'];
        $nombreEvento = $detalleEvento['nomevent'];
        $descripcion = $detalleEvento['descripcion'];
        $categoria = $detalleEvento['categoria'];
        $localizacion = $detalleEvento['localizacion'];
        $usuario = $detalleEvento['creador'];
        $imagen = $detalleEvento['imagen'];
        $direccion = $detalleEvento['direccion'];
        $max_asistentes = $detalleEvento['max_asistentes'];
        $mes = date('F', strtotime($fecha));
        $dia = date('d', strtotime($fecha));
        ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="meeting-single-item">
                <div class="thumb">
                  <div class="price">
                    <span><?php echo $entrada; ?></span>
                  </div>
                  <div class="date">
                    <h6><?php echo $mes; ?> <span><?php echo $dia; ?></span></h6>
                  </div>
                  <a><img src="<?php echo $imagen; ?>" alt=""></a>
                </div>
                <div class="down-content">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">
                      <?php echo $nombreEvento; ?>
                    </h4>
                    <div class="cajaEventoUnirse">

                      <?php if (UsuarioUnido($detalleEvento ['id'], $id_user)): ?>
                        <button class="btnU abandonando" data-id="<?= $detalleEvento ['id'] ?>">
                          Abandonar
                        </button>
                      <?php else: ?>
                        <button class="btnU uniendose" data-id="<?= $detalleEvento ['id'] ?>">
                          Unirse
                        </button>
                      <?php endif; ?>

                      <span class="unirse">
                        <i class="bi bi-person-fill"></i>
                        <?php echo obtenerUnion($detalleEvento ['id']); ?>
                      </span>

                    </div>

                  </div>
                  <p class="description">
                    <?php echo $descripcion; ?>
                  </p>
                  <div class="row">
                    <div class="col-lg-2">
                      <div class="hours">
                        <h5>Categoría</h5>
                        <p><?php echo $categoria; ?></p>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="location">
                        <h5>Dirección</h5>
                        <p><?php echo $localizacion; ?></p>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="location">
                        <h5>Entrada</h5>
                        <p><?php echo $entrada; ?></p>
                      </div>
                    </div>
                    <div class="col-lg-2">
                      <div class="book now">
                        <h5>Creado por:</h5>
                        <p><?php echo $usuario; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="main-button-red">
                <a href="ListaEventos.php">Regresar a la lista de eventos</a>
              </div>
            </div>
          </div>
        <?php
        } else {
          echo "El evento no existe.";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="footer">
    <p>Copyright @ 2023 Project Event.
        <br>Siguenos en: 
        <a href="https://twitter.com/" target="_parent" title="free css templates"><i class="fa fa-twitter"></i></a>
        <a href="https://fb.com/" target="_parent" title="free css templates"><i class="fa fa-facebook"></i></a>
        <a href="https://instagram.com/" target="_parent" title="free css templates"><i class="fa fa-instagram"></i></a>
    </p>
  </div>
</section>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
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

        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }

        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
          e.preventDefault();
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });
    </script>

<script>
  function showModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.showModal();
    
    if (modalId === 'modal2') {
      var modal1 = document.getElementById('modal');
      modal1.close();
    }
  }

  function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.close();

    if (modalId === 'modal2') {
      var modal1 = document.getElementById('modal');
      modal1.close();
    }
  }


  // UNIRSE AJAX

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
