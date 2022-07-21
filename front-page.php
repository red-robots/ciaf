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
    <div class="video-inner">
      <video id="video" autoplay muted loop>
        <?php if ( isset($heroVideo['mp4']) && ($heroVideo['mp4']) ) { ?>
          <source src="<?php echo $heroVideo['mp4'] ?>" type="video/mp4">
        <?php } ?>
        <?php if ( isset($heroVideo['ogg']) && ($heroVideo['ogg']) ) { ?>
          <source src="<?php echo $heroVideo['ogg'] ?>" type="video/ogg">
        <?php } ?>
        <p>Your browser doesn't support HTML5 video. <a href="<?php echo $video; ?>">Download</a> the video instead.</p>
      </video>
    </div>

    <?php if ($heroImage) { ?>
     <div class="hero-image-mobile" style="background-image:url('<?php echo $heroImage['url'] ?>')"></div> 
    <?php } ?>
  </div>
  <?php } ?>

  <section class="hero-verbiage">
    <div class="wrapper">
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
  </section>


  <section class="section section-wander">
    <div class="wrapper medium fadeInUp wow" data-wow-delay="0.5s">
      <h2 class="section-title">Come Wander.</h2>
      <p>Spanning the entirety of Uptown we'll feature spectacular live performances, conversations with thought leaders, immersive art installations, and an abundance of inspired creations.</p>
    </div>
  </section>


  <?php include( locate_template('parts/home-featured-events.php') ); ?>
  <?php include( locate_template('parts/home-upcoming-events.php') ); ?>
  
  <!-- <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script> -->
  <script type="text/javascript">
    jQuery(document).ready(function($){

      var swiper_vertical = new Swiper("#swiper-vertical", {
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
            $('#featured-events-posts .swiper-button-next, #featured-events-posts .swiper-button-prev').appendTo('#featured-events-posts .swiper-pagination');
          },
        }
      });


      swiper_vertical.on('slideChangeTransitionStart', function (e) {
        var eventType = $('#featured-events-posts .event').attr('data-event-type');
        var eventColor = $('#featured-events-posts .event').attr('data-color');
        $('#category-initial').css('background-color',eventColor);
        $('#category-initial span').text(eventType);
        $("#featured-events-posts .swiper-slide").each(function() {
          var slideItem = $(this);
          if( slideItem.hasClass('swiper-slide-active') ) {
            var imgURL = slideItem.find('.event').attr('data-image');
            if(imgURL) {
              $('#featured_event_imagecol').css('background-image','url('+imgURL+')');
            }
          }
        });
      });

      //INIT
      var show_at_most = $('#upcoming_events_carousel').attr('data-total');
      let loop_option = (show_at_most>3) ? true : false;

      var owl = $('#upcoming_events_carousel.owl-carousel').owlCarousel({
        center: true,
        items:2,
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
            center: true,
            items:2,
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
            center: true,
            items:2,
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
            center: true,
            items:2,
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
            center: true,
            items:2,
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


    });
  </script>
<?php
get_footer();
