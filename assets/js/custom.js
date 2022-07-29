/**
 *	Custom jQuery Scripts
 *	Date Modified: 06.01.2022
 *	Developed by: Lisa DeBona
 */
jQuery(document).ready(function ($) {  

  new WOW().init();
  
  // let sticky = $('#site-header'),
  // stickyTop = sticky.offset().top,
  // scrolled = false,
  // $window = $(window);

  // /* Bind the scroll Event */
  // $window.on('scroll', function(e) {
  //   scrolled = true;
  //   var navHeight = $( window ).height() - 85;
  //   if ($(window).scrollTop() > navHeight) {
  //     sticky.addClass('sticky');
  //   } else {
  //     sticky.removeClass('sticky');
  //   }
  // });


  window.onscroll = function() {scrollFunction()};
  function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
      document.getElementById("site-header").classList.add('sticky');
    } else {
      document.getElementById("site-header").classList.remove('sticky');
    }
  }


  $('select.nice-select').niceSelect();

  var swiper = new Swiper(".generic-slider", {
    slidesPerView: 1,
    direction: "horizontal",
    loop: true,
    autoplay: {
      delay: 8000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    }
  });

  // $('.grid').masonry({
  //   itemSelector: '.grid-item',
  //   columnWidth: '.grid-sizer',
  //   percentPosition: true
  // });


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

  if( $('#countdown').length ) {
    $('.count').each(function () {
      $(this).css('opacity','0');
    });
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
            $(this).text(Math.ceil(now).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")).css('opacity',1);
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
  
  /* Mobile Menu */
  $('#mobile-menu').on('click',function(e){
    e.preventDefault();
    $(this).toggleClass('open');
    $('body').toggleClass('mobile-menu-open');
  });

  $('#primary-menu > li').each(function(k){
    var i = parseFloat((k + 3).toFixed(1));
    var duration = (i/10).toFixed(1);
    $(this).css('transition-delay', duration+'s');
  });


  /* Typewriter Effect */
  var TxtType = function(el, toRotate, period) {
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 2000;
    this.txt = '';
    this.tick();
    this.isDeleting = false;
  };

  TxtType.prototype.tick = function() {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    if (this.isDeleting) {
    this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
    this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

    var that = this;
    var delta = 200 - Math.random() * 100;

    if (this.isDeleting) { delta /= 2; }

    if (!this.isDeleting && this.txt === fullTxt) {
    delta = this.period;
    this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
    this.isDeleting = false;
    this.loopNum++;
    delta = 500;
    }

    setTimeout(function() {
    that.tick();
    }, delta);
  };

  window.onload = function() {
    var elements = document.getElementsByClassName('typewrite');
    for (var i=0; i<elements.length; i++) {
        var toRotate = elements[i].getAttribute('data-type');
        var period = elements[i].getAttribute('data-period');
        if (toRotate) {
          new TxtType(elements[i], JSON.parse(toRotate), period);
        }
    }
    // INJECT CSS
    // var css = document.createElement("style");
    // css.type = "text/css";
    // css.innerHTML = ".typewrite > .wrap { border-right: 0.06em solid #666}";
    // document.body.appendChild(css);
  };

  

  /* Main EVENTS page => Other view mode shows all recurring events except Photo view */
  if( $('body.post-type-archive-tribe_events.view-mode-photo').length ) {
    var photoMode = siteURL + '/events/photo/?hide_subsequent_recurrences=1';
    if(baseName=='events' || baseName=='photo') {
      $('.tribe-events-pro-photo').load(photoMode+' .tribe-common-g-row--gutters',function(){
        $('body').addClass('content-loaded-via-js');
        $('.tribe-events-pro-photo-nav').load(photoMode+' .tribe-events-c-nav__list',function(){
        });
      });
    }
    $(document).on('click','button.tribe-events-c-view-selector__button',function(e){
      e.preventDefault();
      if( $('body.archive.view-mode-photo').length ) {
        $('ul.tribe-events-c-view-selector__list a').each(function(){
          var target = $(this);
          var str = target.text().trim();
          var newLink = target.attr('href').replace('?hide_subsequent_recurrences=1','');
          if(str=='Photo') {
            newLink = siteURL + '/events/photo/?hide_subsequent_recurrences=1';
          }
          target.attr('href',newLink);
        });
      }
    });
  }




}); 