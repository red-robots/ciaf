/**
 *	Custom jQuery Scripts
 *	Date Modified: 06.01.2022
 *	Developed by: Lisa DeBona
 */
jQuery(document).ready(function ($) {  

  new WOW().init();
  
  let sticky = $('#site-header'),
  stickyTop = sticky.offset().top,
  scrolled = false,
  $window = $(window);

  /* Bind the scroll Event */
  $window.on('scroll', function(e) {
    scrolled = true;
    // if ($window.scrollTop() >= stickyTop) {
    //   sticky.addClass('fixed');
    // }
    // else {
    //   sticky.removeClass('fixed');
    // }
    var navHeight = $( window ).height() - sticky.height();
    if ($(window).scrollTop() > navHeight) {
      sticky.addClass('sticky');
    } else {
      sticky.removeClass('sticky');
    }
  });

  // let timeout = setInterval(function() {
  //     /* If the page was scrolled, handle the scroll */
  //     if (scrolled) {
  //       scrolled = false;
  //       if ($window.scrollTop() >= stickyTop) {
  //           sticky.addClass('fixed');
  //           console.log("sticky");
  //       }
  //       else {
  //         sticky.removeClass('fixed');
  //       }
  //     }
  // }, 200);

  $('select.nice-select').niceSelect();

  // var swiper = new Swiper(".generic-slider", {
  //   slidesPerView: 1,
  //   direction: "horizontal",
  //   loop: true,
  //   autoplay: {
  //     delay: 8000,
  //     disableOnInteraction: false,
  //   },
  //   pagination: {
  //     el: ".swiper-pagination",
  //     clickable: true,
  //   },
  //   navigation: {
  //     nextEl: ".swiper-button-next",
  //     prevEl: ".swiper-button-prev",
  //   }
  // });

  // $('.grid').masonry({
  //   itemSelector: '.grid-item',
  //   columnWidth: '.grid-sizer',
  //   percentPosition: true
  // });

  $('#mobile-menu').on('click',function(e){
    e.preventDefault();
    $(this).toggleClass('open');
    $('#site-navigation').toggleClass('open');
  });

  move_footer_copyright();
  $(window).on('orientationchange resize',function(){
    move_footer_copyright();
  });
  
  function move_footer_copyright() {
    if( $(window).width() > 1024 ) {
      if( $('.footcol').length && $('#footer-copyright').length ) {
        var last_footer_col = $('.footcol .social-media');
        $('#footer-copyright').appendTo(last_footer_col);
      }
    } else {
      $('#footer-copyright').appendTo('#copyright-mobile');
    }
  }


  setTimeout(function(){
    startCountDown(3000);
  },1000);

  //startCountDown(3000);
  function startCountDown(duration) {
    $('.count').each(function () {
      $(this).prop('Counter',0).animate({
          Counter: $(this).text()
      }, {
          duration: duration,
          easing: 'swing',
          step: function (now) {
              $(this).text(Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
          }
      });
    });
  }

  
  if( $('h3.tribe-events-calendar-list__event-title .list-mode-term-symbol').length ) {
    $('h3.tribe-events-calendar-list__event-title .list-mode-term-symbol').each(function(){
      var target = $(this);
      var parent = $(this).parents('.tribe-events-calendar-list__event-row');
      if( parent.find('a.tribe-events-calendar-list__event-featured-image-link').length ) {
        var featuredImage = parent.find('a.tribe-events-calendar-list__event-featured-image-link');
        target.appendTo(featuredImage);
      }
    });
  }

  $('.contact-form-section .ginput_container input, .ginput_container textarea').on('focus',function(){
    var parent = $(this).parents('.gfield');
    var str = $(this).val().trim().replace('/\s+/g','');
    parent.find('.gfield_label').addClass('active');
  });

  $('.contact-form-section .ginput_container input, .ginput_container textarea').on('focusout blur',function(){
    var parent = $(this).parents('.gfield');
    var str = $(this).val().trim().replace('/\s+/g','');
    parent.find('.gfield_label').addClass('active');
    if(str) {
      parent.find('.gfield_label').addClass('active');
    } else {
      parent.find('.gfield_label').removeClass('active');
    }
  });

  adjustNavCarousel();
  $(window).on('orientationchange resize',function(){
    adjustNavCarousel();
  });
  function adjustNavCarousel() {
    if( $('#upcoming_events_carousel').length ) {
      var imgHeight = $('#upcoming_events_carousel .imagewrap a').eq(0).height();
      $('.customNav').css('height',imgHeight+'px');
    }
  }
  

}); 