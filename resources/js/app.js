import '../css/bootstrap.min.css';
import '../css/style.css';
import '../lib/animate/animate.min.css';
import '../lib/animate/animate.css';
import '../lib/owlcarousel/assets/owl.carousel.min.css';

// js

import './bootstrap';
import '../lib/waypoints/waypoints.min';
import '../lib/easing/easing.min.js';
import '../lib/owlcarousel/owl.carousel.js';
import '../lib/owlcarousel/owl.carousel.min.js';
import '../lib/waypoints/waypoints.min.js';



// window.addEventListener('load', () => {
//   document.getElementById('spinner').style.display = 'none';
// //   alert('Welcome to Property Selling Website!');
// let element = document.getElementById('spinner');
//   element.classList.remove('show');
// });

import.meta.glob([
  '../assets/img/**',
  // '../assets/json/**',
  '../assets/vendor/fonts/**'
]);

(function ($) {
    "use strict";

    // // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();

    
    
    // Initiate the wowjs
    new WOW().init(); 
    

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top');
        } else {
            $('.nav-bar').removeClass('sticky-top');
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav : true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            992:{
                items:2
            }
        }
    });
    
})(jQuery);

