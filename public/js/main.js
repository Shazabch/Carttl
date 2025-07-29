  AOS.init();
const navbarMenu = document.getElementById("menu");
const burgerMenu = document.getElementById("burger");
const headerMenu = document.getElementById("header");

// Open Close Navbar Menu on Click Burger
if (burgerMenu && navbarMenu) {
  burgerMenu.addEventListener("click", () => {
    burgerMenu.classList.toggle("is-active");
    navbarMenu.classList.toggle("is-active");
  });
}

// Close Navbar Menu on Click Menu Links
document.querySelectorAll(".menu-link").forEach((link) => {
  link.addEventListener("click", () => {
    burgerMenu.classList.remove("is-active");
    navbarMenu.classList.remove("is-active");
  });
});

// Change Header Background on Scrolling
window.addEventListener("scroll", () => {
  if (this.scrollY >= 85) {
    headerMenu.classList.add("on-scroll");
  } else {
    headerMenu.classList.remove("on-scroll");
  }
});


$('.testimonail_slider').owlCarousel({
    center:true,
    loop:true,
    margin:20,
    nav:true,
    dots:false,
    smartSpeed: 600, // Controls the speed of the slide transition (in ms)
    animateOut: 'fadeOut', // Animation class for slide out
    animateIn: 'fadeIn',   // Animation class for slide in
    responsive:{
        0:{
            items:1.2
        },
        600:{
            items:2
        },
        1000:{
            items:4
        }
    }
})

$(".cars-card-slider").owlCarousel({
  loop: true,
  margin: 25,
  nav: true,
  dots: false,
  responsive: {
    0: {
      items: 1,
    },
    600: {
      items: 1,
    },
    768: {
      items: 2,
    },
    992: {
      items: 3,
    },
    1000: {
      items: 4,
    },
  },
});
$(".car-box-card_silder").owlCarousel({
  loop: true,
  margin: 10,
  nav: false,
  dots: true,
  autoplay: true,
  autoplayTimeout: 4000,
  autoplayHoverPause: true,
  autoplaySpeed: 2000,
  responsive: {
    0: {
      items: 1,
    },
    600: {
      items: 1,
    },
    1000: {
      items: 1,
    },
  },
});

$(document).ready(function () {
    $('.scrollTo').on('click', function (e) {
        e.preventDefault();
        const target = $($(this).data('target'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 800); // 800ms animation
        }
    });
});