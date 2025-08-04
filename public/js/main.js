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

$(document).ready(function () {
  $('#openSearchBtn').on('click', function (e) {
    e.preventDefault();
    e.stopPropagation(); // prevent triggering the document click
    $('.modern-car-search').addClass('active');
  });

  // Prevent click inside search box from closing it
  $('.modern-car-search').on('click', function (e) {
    e.stopPropagation();
  });

  // Click anywhere else removes the class
  $(document).on('click', function () {
    $('.modern-car-search').removeClass('active');
  });
});

$(function () {
  $("#slider-range").slider({
    range: true,
    min: 0,
    max: 10000,
    values: [1000, 9000],
    slide: function (event, ui) {
      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);
    }
  });

  $("#min_price").val($("#slider-range").slider("values", 0));
  $("#max_price").val($("#slider-range").slider("values", 1));

  $("#price-range-submit").click(function () {
    const minPrice = $("#min_price").val();
    const maxPrice = $("#max_price").val();
    $("#searchResults").html(`<p>Showing results from <strong>$${minPrice}</strong> to <strong>$${maxPrice}</strong></p>`);
  });
});
