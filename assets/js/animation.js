jQuery(document).ready(function ($) {  

    var currentScreenHeight = $(window).height();

    /* Insert Main Navigation to Home Banner wrapper */
    if( $('#home_banner').length ) {
      $('#desktop-navigation').appendTo('#home_banner').removeClass('sticky');
    }

    /* circular text */
    if( $('#circular') ) {
      new CircleType(document.getElementById('circular'));
    }

    document.documentElement.classList.add('is-loaded');
    document.documentElement.classList.remove('is-loading');

    setTimeout(() => {
        document.documentElement.classList.add('is-ready');
    },300)



      let options = {
        el: document.querySelector('#js-scroll'),
        smooth: true,
        getSpeed: true,
        getDirection: true,
        repeat: true
      } 

      const scroll = new LocomotiveScroll(options);

      scroll.on('scroll', func => {

        var fixeElHeight = $('#imagecol').height() - 200;

        $('#fixed-elements').css('height', fixeElHeight + 'px' );

        $('.grid-item figure').each(function(){
          if ($(this).isInViewport()) {
            $(this).addClass('viewing');
          } else {
            $(this).removeClass('viewing');
          }
        });

        $('.section').each(function(){
          if ($(this).isInViewport()) {
            $(this).addClass('viewing');
          } else {
            $(this).removeClass('viewing');
          }
        });



        if ($('.section#events-section .circular-text').isInViewport()) {
          $('#homerow1').addClass('adjust-caption');
        } else {
          $('#homerow1').removeClass('adjust-caption');
        }

        /* Viewing Squiggy */
        $('.squiggy').each(function(){
          if ($(this).isInViewport()) {
            $(this).addClass('viewing');
          } else {
            $(this).removeClass('viewing');
          }
        });

        if( $('.featured-events').isInViewport() ) {
          $('.featured-events').addClass('viewing');
          //$('#events-title').addClass('sticky');
        } else {
          $('.featured-events').removeClass('viewing');
          //$('#events-title').removeClass('sticky');
        }

        if( $('.featured-events').isInViewport() || $('.upcoming-events-section').isInViewport() ) {
          $('#events-title').addClass('animated fadeIn sticky');
        } else {
          $('#events-title').removeClass('animated fadeIn sticky');
        }

        var halfscreen = '-' + Math.round( $(window).height() / 3 );
        var haflScreenHero = parseInt(halfscreen);
    

        if($('#home_banner').offset().top < haflScreenHero) {
          $('#home_banner #desktop-navigation').addClass('fadeOut');
          //$('#desktop-navigation-sticky').addClass('show animated fadeInDown');
        } else {
          $('#home_banner #desktop-navigation').removeClass('fadeOut');
        }

        if( $('#home_banner').length ) {
          if( $('#homerow1').isInViewport() || $('#plan-visit-section').isInViewport() || $('#upcoming-events').isInViewport() || $('.site-footer').isInViewport() ) {
            if($('#home_banner').offset().top < haflScreenHero) {
              $('#home_banner #desktop-navigation').addClass('animated fadeOut').removeClass('fadeIn');
              $('#desktop-navigation-sticky').addClass('show animated fadeInDown');
            } else {
              $('#home_banner #desktop-navigation').removeClass('fadeOut').addClass('fadeIn');
            }
          } else {
            $('#desktop-navigation-sticky').removeClass('show animated fadeInDown');
          }
        }


        /* Viewing Circular Text */
        if( $('.circular-text').isInViewport() ) {
          $('.circular-text').addClass('viewing');
          $('#events-title-mobile').addClass('move-down');
        } else {
          $('.circular-text').removeClass('viewing');
          $('#events-title-mobile').removeClass('move-down');
        }

        if( $('#plan-visit-section .inner').isInViewport() ) {
          if( $('#plan-visit-section').offset().top < currentScreenHeight ) {
            $('#events-title').addClass('move-up');
          } else {
            $('#events-title').removeClass('move-up');
          }
        } else {
          $('#events-title').removeClass('move-up');
        }

        if( $('.site-footer').isInViewport() ) {
          $('body').addClass('show-bottom-overlay');
        } else {
          $('body').removeClass('show-bottom-overlay');
        }

      });


    // $(window).on('orientationchange resize',function(){
    //   activate_locomotive();
    // });

    

    loop_squiggy2();
    function loop_squiggy2() {
      var count_squiggy2 = $('.squiggy2 span').length;
      var total = parseInt(count_squiggy2) + 1;
      var INTERVAL = 1;
      //var delay = INTERVAL * 50;
      var counter = parseInt( 1, 10 );
      setInterval( function() {
        var ctr = counter++;
        if(ctr==total) {
          counter = 1;
        }
        var i=1;
        $('.squiggy2 span').each(function(){
          if(i==ctr) {
            $(this).addClass('active');
          } else {
            $(this).removeClass('active');
          }
          i++;
        });
      }, 80 );

    }


    function homerow1_width() {
      var hrow1_width = $('#homerow1 .c-sections_infos_text').width();
      $('#homerow1 .c-sections_infos_text .text').css('width',hrow1_width+'px');
    }

    $.fn.isInViewport = function() {
      var elementTop = $(this).offset().top;
      var elementBottom = elementTop + $(this).outerHeight();
      var viewportTop = $(window).scrollTop();
      var viewportBottom = viewportTop + $(window).height();
      return elementBottom > viewportTop && elementTop < viewportBottom;
    };

    if( $('#homerow1 .has-squiggy').length ) {
      $('#homerow1 .has-squiggy').next().addClass('next');
    }


    /* Home Hero */
    animated_vline_counter();
    $(window).on('orientationchange resize',function(){
      animated_vline_counter();
    });
    function animated_vline_counter() {
      if( $('#countdown .timer').length ) {
        var home_banner_height = $(window).height();
        var counter_height = $('#countdown .timer').height();
        var vline = (home_banner_height - counter_height) - 80;
        $('#vline').height(vline+'px');
      }
    }
    

}); 





