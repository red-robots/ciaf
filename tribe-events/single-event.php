<?php
/**
 * Single Event Template
 * A single event. This displays the event title, description, meta, and
 * optionally, the Google map for the event.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/single-event.php
 *
 * @package TribeEventsCalendar
 * @version 4.6.19
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$events_label_singular = tribe_get_event_label_singular();
$events_label_plural   = tribe_get_event_label_plural();

$event_id = get_the_ID();

/**
 * Allows filtering of the single event template title classes.
 *
 * @since 5.8.0
 *
 * @param array  $title_classes List of classes to create the class string from.
 * @param string $event_id The ID of the displayed event.
 */
$title_classes = apply_filters( 'tribe_events_single_event_title_classes', [ 'tribe-events-single-event-title' ], $event_id );
$title_classes = implode( ' ', tribe_get_classes( $title_classes ) );

/**
 * Allows filtering of the single event template title before HTML.
 *
 * @since 5.8.0
 *
 * @param string $before HTML string to display before the title text.
 * @param string $event_id The ID of the displayed event.
 */
$before = apply_filters( 'tribe_events_single_event_title_html_before', '<h1 class="' . $title_classes . '">', $event_id );

/**
 * Allows filtering of the single event template title after HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display after the title text.
 * @param string $event_id The ID of the displayed event.
 */
$after = apply_filters( 'tribe_events_single_event_title_html_after', '</h1>', $event_id );

/**
 * Allows filtering of the single event template title HTML.
 *
 * @since 5.8.0
 *
 * @param string $after HTML string to display. Return an empty string to not display the title.
 * @param string $event_id The ID of the displayed event.
 */
$title = apply_filters( 'tribe_events_single_event_title_html', the_title( $before, $after, false ), $event_id );

$start = tribe_get_start_date($event_id,null,'M d');
$end = tribe_get_end_date($event_id,null,'M d');
$start_time = tribe_get_start_date($event_id,null,'g:ia');
$end_time = tribe_get_end_date($event_id,null,'g:ia');

$start_time_i = tribe_get_start_time($event_id,false,'g:ia');
$end_time_i = tribe_get_end_time($event_id,false,'g:ia');
$event_dates = $start;
if($start!=$end) {
$event_dates = ( array_filter(array($start,$end)) ) ? implode(' &ndash; ',array_filter(array($start,$end))) : '';
}


if($start_time_i || $end_time_i) {
  $st = str_replace(':00','',$start_time);
  $et = str_replace(':00','',$end_time);
  $times = ( array_filter(array($st,$et)) ) ? implode(' &ndash; ',array_filter(array($st,$et))) : '';
  if($start_time==$end_time) {
    $times = $start_time;
  }
  if($event_dates) {
    $event_dates .= ' <span>|</span> ' . $times;
  } 
}

$event_start_format = tribe_get_start_date($event_id,null,'m.d.Y');
$terms = wp_get_post_terms( $event_id, Tribe__Events__Main::TAXONOMY );
$term = (isset($terms[0]) && $terms[0]) ? $terms[0] : '';
$term_id = (isset($term->term_id) && $term->term_id) ? $term->term_id : '';
$term_name = (isset($term->name) && $term->name) ? $term->name : '';
$term_slug = (isset($term->slug) && $term->slug) ? $term->slug : '';
$term_class = ($term_slug) ? ' term-'.$term_slug : '';
$term_link = ($term) ? get_term_link($term) : '';
$color = get_field('category_color', $term);
$catColor = ($color) ? $color:'#FFF';
$images = get_field("gallery");
$has_main_image = 'no-gallery';
if($images) {
  $has_main_image = 'has-gallery';
} else {
  if( has_post_thumbnail() ) {
    $has_main_image = 'has-gallery';
  }
}

?>

<header class="single-page-header">
  <div class="title-inner">
    <a class="view-all-btn theme-btn" href="<?php echo esc_url( tribe_get_events_link() ); ?>"><?php printf( '' . esc_html_x( 'All %s', '%s Events plural label', 'the-events-calendar' ), $events_label_plural ); ?></a>
    <div class="wrap">
      <h1><?php the_title() ?></h1>
      <div class="date">
        <?php echo $event_dates ?>
        <?php if ($event_dates && $term) { ?>
        <span>|</span> <a href="<?php echo $term_link ?>" style="color:<?php echo $catColor ?>"><?php echo $term_name ?></a>
        <?php } ?>
      </div>
    </div>
  </div>
</header>

<div class="single-main-wrap <?php echo $has_main_image; ?>">
  <div id="tribe-events-content" class="tribe-events-single">

  	<!-- Notices -->
  	<?php tribe_the_notices() ?>

    <div class="gallery-slider-content">
      <?php if ($images) { ?>
        <?php include( locate_template('parts/gallery-slider.php') ); ?>
      <?php } else { ?>
        <figure class="event-featured-image">
          <?php the_post_thumbnail(); ?>
        </figure>
      <?php } ?>
    </div>

  	<?php  //echo $title; ?>

  	<!-- Event header -->
  	<div id="tribe-events-header" <?php tribe_events_the_header_attributes() ?>>
  		<!-- Navigation -->
  		<nav class="tribe-events-nav-pagination" aria-label="<?php printf( esc_html__( '%s Navigation', 'the-events-calendar' ), $events_label_singular ); ?>">
  			<ul class="tribe-events-sub-nav">
  				<li class="tribe-events-nav-previous"><?php tribe_the_prev_event_link( '<span>&laquo;</span> %title%' ) ?></li>
  				<li class="tribe-events-nav-next"><?php tribe_the_next_event_link( '%title% <span>&raquo;</span>' ) ?></li>
  			</ul>
  			<!-- .tribe-events-sub-nav -->
  		</nav>
  	</div>
  	<!-- #tribe-events-header -->

  	<?php while ( have_posts() ) :  the_post(); ?>
  		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  			<!-- Event featured image, but exclude link -->
  			<?php // echo tribe_event_featured_image( $event_id, 'full', false ); ?>

  			<!-- Event content -->
  			<?php do_action( 'tribe_events_single_event_before_the_content' ) ?>
        <div class="tribe-events-single-event-description-wrap">
    			<div class="tribe-events-single-event-description tribe-events-content">
    				<?php the_content(); ?>
    			</div>
        </div>
  			<!-- .tribe-events-single-event-description -->
  			<?php do_action( 'tribe_events_single_event_after_the_content' ) ?>

  			<!-- Event meta -->

        <div class="tribe-meta-wrapper">
          <div class="tribe-meta-inner">
      			<?php do_action( 'tribe_events_single_event_before_the_meta' ) ?>
      			<?php tribe_get_template_part( 'modules/meta' ); ?>
  			     <?php do_action( 'tribe_events_single_event_after_the_meta' ) ?>
          </div>
        </div>

  		</div> <!-- #post-x -->
  		<?php if ( get_post_type() == Tribe__Events__Main::POSTTYPE && tribe_get_option( 'showComments', false ) ) comments_template() ?>
  	<?php endwhile; ?>

  	
  	<!-- #tribe-events-footer -->

  </div><!-- #tribe-events-content -->
</div>

<script>
jQuery(document).ready(function($){
  $('.tribe-events-meta-group-organizer a').each(function(){
    $(this).attr('target','_blank');
  });
});
</script>
