<?php get_header(); ?>

<?php  
  $heroText = get_field('home_hero_text');
  $heroVideo = get_field('hero_video');
  $heroDate = get_field('hero_event_date');
  $hd = ($heroDate) ? date_intervals_info($heroDate) : '';
  $ctr_Month = (isset($hd['months']) && $hd['months']) ? $hd['months'] : '0';
  $ctr_Days = (isset($hd['days']) && $hd['days']) ? $hd['days'] : '0';
  $ctr_Hours = (isset($hd['hours']) && $hd['hours']) ? $hd['hours'] : '0';

  $homeGallery = get_field('home_gallery'); 
  $gallery_text = get_field('gallery_text'); 
  $heroImage = get_field('hero_image_mobile'); 
?>
  
  <?php if ( isset($heroVideo['mp4']) || isset($heroVideo['ogg']) || $heroImage ) { ?>
  <div class="parallax-video-container">
    <video id="video" autoplay muted loop>
      <?php if ( isset($heroVideo['mp4']) && ($heroVideo['mp4']) ) { ?>
        <source src="<?php echo $heroVideo['mp4'] ?>" type="video/mp4">
      <?php } ?>
      <?php if ( isset($heroVideo['ogg']) && ($heroVideo['ogg']) ) { ?>
        <source src="<?php echo $heroVideo['ogg'] ?>" type="video/ogg">
      <?php } ?>
      <p>Your browser doesn't support HTML5 video. <a href="<?php echo $video; ?>">Download</a> the video instead.</p>
    </video>

    <?php if ($heroImage) { ?>
     <div class="hero-image-mobile" style="background-image:url('<?php echo $heroImage['url'] ?>')"></div> 
    <?php } ?>
  </div>
  <?php } ?>

  <?php if ( has_nav_menu( 'primary' ) ) { ?>
  <nav id="desktop-navigation-sticky" class="desktop-navigation-sticky" role="navigation">
    <?php if( get_custom_logo() ) { ?>
      <div class="branding"><?php the_custom_logo(); ?></div>
    <?php } ?>
    <div class="navbar">
      <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container'=>false, 'menu_id' => 'desktop-menu-sticky') ); ?>
    </div>
  </nav>
  <?php } ?>

  <div class="o-scroll" id="js-scroll" data-scroll-container>
    <div id="home_banner" class="home_banner_wrap" data-scroll-section>
      <header id="masthead" class="site-header" role="banner">
        <div class="wrapper wide">
          <?php if( get_custom_logo() ) { ?>
            <span id="site-logo" class="animated fadeInDown">
              <?php the_custom_logo(); ?>
            </span>
          <?php } else { ?>
            <a href="<?php echo get_site_url() ?>" id="site-logo" class="animated fadeInDown">
             <img src="<?php echo IMAGES_URL ?>/logo.png" alt="<?php echo get_bloginfo('name') ?>">
           </a>
          <?php } ?>
        </div>  
      </header>

      <?php if ( isset($heroText['top']) || isset($heroText['middle']) ||  isset($heroText['bottom']) ) { ?>
      <div class="home-banner">
        <div class="animated-hero-text">
          <div class="inner">
            <?php if ( (isset($heroText['top'])) && $heroText['top']) { ?>
            <div class="t1"><?php echo $heroText['top'] ?></div>
            <?php } ?>
            <?php if ( (isset($heroText['middle'])) && $heroText['middle']) { ?>
            <div class="t2"><?php echo $heroText['middle'] ?></div>
            <?php } ?>
            <?php if ( (isset($heroText['bottom'])) && $heroText['bottom']) { ?>
            <div class="t3" style="animation-delay:.6s"><?php echo $heroText['bottom'] ?></div>
            <?php } ?>
          </div>
        </div>
      </div>
      <?php } ?>


      <?php if ($heroDate) { ?>
      <div id="countdown" class="animated fadeIn" style="animation-delay:1s">
        <div id="vline"><div><span></span></div></div>
        <div class="timer">
          <div class="counttype month">
            <div class="text">MONTHS</div>
            <div class="count"><?php echo $ctr_Month ?></div>
          </div>

          <div class="counttype days">
            <div class="text">DAYS</div>
            <div class="count"><?php echo $ctr_Days ?></div>
          </div>

          <div class="counttype hours">
            <div class="text">HOURS</div>
            <div class="count"><?php echo $ctr_Hours ?></div>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>  


    
  
    <section id="homerow1" class="section c-section -fixed" data-scroll-section data-persistent>
        
        <div class="full-width blue-section" id="fixed-elements">
          <div class="wrapper wide">
            <div class="flexcol">
                <?php if ($gallery_text) { ?>
                <div class="col-left">
                    <div class="c-section_infos" data-scroll data-scroll-sticky data-scroll-target="#fixed-elements">
                        <div class="c-section_infos_inner" data-scroll data-scroll-offset="200">
                            <div class="c-sections_infos_text">
                              <div class="text"> 
                                <?php echo $gallery_text ?>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <?php if ($homeGallery) { ?>
                <div class="col-right">
                  <?php include( locate_template('parts/home-gallery.php') ); ?>
                </div>
                <?php } ?>
            </div>
          </div>
        </div>
    </section>


    <?php /* EVENTS */ 
    $event_title = get_field('event_column_left_title');
    ?>
    <?php if ($event_title) { ?>
      <h2 id="events-title" class="rotated-title"><span><?php echo $event_title ?></span></h2>
    <?php } ?>
    <div class="section-outer-wrap section-same-title">
      <?php include( locate_template('parts/home-featured-events.php') ); ?>
      <?php include( locate_template('parts/home-upcoming-events.php') ); ?>
    </div>
      
    <?php 
      include( locate_template('parts/home-plan-visit.php') );
      include( locate_template('parts/footer_content.php') );
    ?> 
  </div>

  <script>
    jQuery(document).ready(function($){

      var swiper = new Swiper(".swiper-events", {
        slidesPerView: 1,
        spaceBetween: 30,
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
        },
        breakpoints: { 
          320: {        
            direction: "horizontal",
          },  
          640: {        
            direction: "horizontal",
          },
          1025: {        
            direction: "vertical",
          }   
        },
        on: {
          init: function () {
            $('.events-section .swiper-button-next, .events-section .swiper-button-prev').appendTo('.events-section .swiper-pagination');
          },
        }
      });

     var firsImgURL = $(".featured-events .swiper-slide .event.first").attr('data-image');
     var firsSlideTerm = $(".featured-events .swiper-slide .event.first").attr('data-event-type');
     $('#featured_event_imagecol').css('background-image','url('+firsImgURL+')');
     if(firsSlideTerm) {
      $('#circular-middle #eventType').attr('data-type',firsSlideTerm);
      $('#circular-middle #eventType').text(firsSlideTerm);
     }
    
    swiper.on('slideChangeTransitionStart', function (e) {
      var eventType = $('.swiper-slide-active .event').attr('data-event-type');
      var eventColor = $('.swiper-slide-active .event').attr('data-color');
      if(eventType) {
        $('#circular-middle').show();
        $('#eventType').text(eventType);
        $('#eventType').attr('data-type',eventType);
        $('#circular-middle .bgcolor path').attr('style','fill:'+eventColor);
      } else {
        $('#circular-middle').hide();
      }

      $(".featured-events .swiper-slide").each(function() {
        var slideItem = $(this);
        if( slideItem.hasClass('swiper-slide-active') ) {
          var imgURL = slideItem.find('.event').attr('data-image');
          if(imgURL) {
            $('#featured_event_imagecol').css('background-image','url('+imgURL+')');
          }
        }
      });

      // setTimeout(function(){
      //   $('#featured_event_imagecol').removeClass('fadeIn');
      // },300);
    });




        carousel_wrap_resizer();
        $(window).on('orientationchange resize',function(){
          carousel_wrap_resizer();
        });
        function carousel_wrap_resizer() {
          if( $('.wrap-resizer').length ) {
            var screenWidth = $(window).width();
            var resizerWidth = $('.wrap-resizer').width();
            var leftWidth = (screenWidth - resizerWidth) / 2;
            //$('#upcoming_events_carousel').css('transform','translateX('+leftWidth+'px)');
            $('#upcoming_events_carousel').css('left',leftWidth+'px');
          }
        }

      //INIT
      var show_at_most = $('#upcoming_events_carousel').attr('data-total');
      let loop_option = (show_at_most>3) ? true : false;

      // var owl = $('#upcoming_events_carousel.owl-carousel').owlCarousel({
      //           center:false,
      //           loop:loop_option,
      //           margin:10,
      //           nav:true,
      //           responsive:{
      //               0:{
      //                   items:1
      //               },
      //               600:{
      //                   items:3
      //               },
      //               1000:{
      //                   items:4
      //               }
      //           }
      //         });


        var owl = $('#upcoming_events_carousel.owl-carousel').owlCarousel({
          center:false,
          loop:loop_option,
          margin:30,
          nav:true,
          responsive:{
            0:{
              items:1
            },
            600:{
              items:3
            },
            1000:{
              items:4
            }
          }
        });

      $( '.owl-filter-bar' ).on( 'click', '.item', function() {
        $('#upcoming_events_carousel').addClass('filtered');
        var $item = $(this);  
        var filter = $item.data( 'owl-filter' );
        owl.owlcarousel2_filter( filter );
        owl.owlCarousel('destroy');
        var count = $(filter).length;
        let loopStat = (count>2) ? true : false;
        //let numItems = (count>4) ? 5 : 4;

        if(filter=="*") {
          owl.owlCarousel({
            loop:true,
            margin:20,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:3
                },
                1000:{
                    items:4
                }
            }
          });
        } else {
          owl.owlCarousel({
            loop:loopStat,
            margin:20,
            nav:true,
            responsive:{
              0:{
                  items:1
              },
              600:{
                  items:2
              },
              1000:{
                  items:4
              }
            }
          });
        }
        
      });


      $('select#filterEventType').on('change',function(){
        $('#filterByDate').val('*');
        $('#upcoming_events_carousel').addClass('filtered');
        var selectedType = $(this).val();
        if(selectedType=='*') {
          $('#term-all').trigger('click');
        } else {
          var filterByType = '.term-'+selectedType;
          owl.owlcarousel2_filter( filterByType );
          owl.owlCarousel('destroy');
          var count = $(filterByType).length;
          let loopStat = (count>3) ? true : false;
          owl.owlCarousel({
            loop:loopStat,
            margin:20,
            nav:true,
            responsive:{
              0:{
                  items:1
              },
              600:{
                  items:2
              },
              1000:{
                  items:4
              }
            }
          });
        }
      });
        

      $('select#filterByDate').on('change',function(){
        $('#upcoming_events_carousel').addClass('filtered');
        var selectedDate = $(this).val();
        $('#filterEventType').val('*');
        if(selectedDate=='*') {
          $('#term-all').trigger('click');
        } else {
          var filterByDate = '.event[data-start="'+selectedDate+'"]';
          owl.owlcarousel2_filter( filterByDate );
          owl.owlCarousel('destroy');
          var count = $(filterByDate).length;
          let loopStat = (count>3) ? true : false;
          owl.owlCarousel({
            loop:loopStat,
            margin:20,
            nav:true,
            responsive:{
              0:{
                  items:1
              },
              600:{
                  items:2
              },
              1000:{
                  items:4
              }
            }
          });
        }
      });

      $(document).on('click','.customCaroNav',function(e){
        e.preventDefault();
        var carouselNav = $(this).attr('data-rel');
        $(carouselNav).trigger('click');
      });
      
    });
  </script>
<?php
get_footer();
