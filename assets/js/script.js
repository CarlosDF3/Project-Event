

//Aquí va la función de acordeón de los eventos de perfil.
function acordeonEventos(){

    var ListAcordeon = document.getElementsByClassName("acordeonPerfil");
    for (var i = 0; i < ListAcordeon.length; i++){
        ListAcordeon[i].addEventListener('click', function(){
            this.classList.toggle("active");
            var eventosPerfil = this.nextElementSibling;
            if (eventosPerfil.style.display == "block") {
                eventosPerfil.style.display = "none";
            }
            else{
                eventosPerfil.style.display = "block";
             }
      });
        }
        
}

//Aquí va la función de menu desplegable de categorías.
function menuCategoria(){

    var ListAcordeon = document.getElementsByClassName("btnCategoria");
    for (var i = 0; i < ListAcordeon.length; i++){
        ListAcordeon[i].addEventListener('click', function(){
            this.classList.toggle("active");
            var menuCategoria = this.nextElementSibling;
            if (menuCategoria.style.display == "block") {
                menuCategoria.style.display = "none";
            }
            else{
                menuCategoria.style.display = "block";
             }
      });
        }
        
} 

//Aquí estan los modales de registro y inicio de sesión.
function modales() {
    var popupButton = document.getElementById('popup');
    var popup2Button = document.getElementById('popup2')
    var closeButton = document.getElementById('cancel');
    var close2Button = document.getElementById('cancel2');
    var modal = document.getElementById('modal');
    var modal2 = document.getElementById('modal2');

    popupButton.addEventListener('click', function() {
    modal.showModal();
    });
    popup2Button.addEventListener('click', function() {
    modal2.showModal();
    });
    popup2Button.addEventListener('click', function() {
    modal.close();
    });
    closeButton.addEventListener('click', function() {
    modal.close();
    });
    close2Button.addEventListener('click', function() {
    modal2.close();
    });
}

//Aquí está el carrusel de eventos de la página perfil.
function CarruselPerfil(){

const grande = document.querySelector('.grande')
const btnEventos = document.querySelectorAll('.btnEventos')

btnEventos.forEach( (cadaBoton , i )=>{
    btnEventos[i].addEventListener('click', ()=>{
        let posicion = i;
        let operacion = posicion * -50;

        grande.style.transform = `translateX(${ operacion}%)`;

        btnEventos.forEach((cadaBoton, i) =>{
            btnEventos[i].classList.remove('activo')
        })
        btnEventos[i].classList.add('activo')
    })

} )
}

//Aquí esta el carrusel de la página principal de eventos destacados.
function CarruselDestacados(){
    document.getElementById('next').onclick = function(){
        const widthItem = document.querySelector('.eventos').offsetWidth;
        document.getElementById('carrusel').scrollLeft += widthItem;
    }
    document.getElementById('prev').onclick = function(){
        const widthItem = document.querySelector('.eventos').offsetWidth;
        document.getElementById('carrusel').scrollLeft -= widthItem;
    }

}

//Logica menu header

document.addEventListener("DOMContentLoaded", function () {

  const user = document.querySelector(".event-user");
  const trigger = document.querySelector(".event-user-trigger");

  if (!user || !trigger) return;

  trigger.addEventListener("click", function (e) {
    e.stopPropagation();
    user.classList.toggle("open");
  });

  document.addEventListener("click", function () {
    if (user) user.classList.remove("open");
  });

});