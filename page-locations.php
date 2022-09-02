<?php
/**
 * Template Name: Locations
 *
 */
get_header(); 

$tribe_option = get_option('tribe_events_calendar_options');
$map_api = (isset($tribe_option['google_maps_js_api_key']) && $tribe_option['google_maps_js_api_key']) ? $tribe_option['google_maps_js_api_key'] : '';
$map_api = false;
?>
<div id="primary" class="content-area default-template">
	<?php while ( have_posts() ) : the_post(); ?>
    <?php include( locate_template('parts/hero-subpage.php') ); ?>

    <section class="entry-content">

      <div class="top-shapes">
        <div class="inner">
          <span class="shape1 wow rollIn" data-wow-delay="0.3s"></span>
          <span class="shape2 wow jackInTheBox" data-wow-delay="0.5s"></span>
        </div>
      </div>

      <div class="middle-container wow fadeIn" data-wow-delay="0.4s">
        <?php the_content(); ?>
      </div>

      <div class="bottom-shapes">
        <div class="inner"><span class="shape3 wow jackInTheBox" data-wow-delay="0.6s"></span></div>
      </div>

	<?php endwhile; ?>	

</div>
<?php
get_footer();
