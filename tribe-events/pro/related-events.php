<?php
/**
 * Related Events Template
 * The template for displaying related events on the single event page.
 *
 * You can recreate an ENTIRELY new related events view by doing a template override, and placing
 * a related-events.php file in a tribe-events/pro/ directory within your theme directory, which
 * will override the /views/pro/related-events.php.
 *
 * You can use any or all filters included in this file or create your own filters in
 * your functions.php. In order to modify or extend a single filter, please see our
 * readme on templates hooks and filters
 *
 * @package TribeEventsCalendarPro
 * @version 4.4.28
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}
$max_related = 3;
$posts = tribe_get_related_posts();
if ( is_array( $posts ) && ! empty( $posts ) ) : ?>

<h2 class="tribe-events-related-events-title"><?php printf( __( 'Related %s', 'tribe-events-calendar-pro' ), tribe_get_event_label_plural() ); ?></h2>

<ul class="tribe-related-events tribe-clearfix">
	<?php $i=1; foreach ( $posts as $post ) : ?>
    <?php  
    $event_id = $post->ID;
    $terms = wp_get_post_terms( $event_id, Tribe__Events__Main::TAXONOMY );
    $term = (isset($terms[0]) && $terms[0]) ? $terms[0] : '';
    $term_id = (isset($term->term_id) && $term->term_id) ? $term->term_id : '';
    $term_name = (isset($term->name) && $term->name) ? $term->name : '';
    $term_slug = (isset($term->slug) && $term->slug) ? $term->slug : '';
    $term_class = ($term_slug) ? ' term-'.$term_slug : '';
    $term_link = ($term) ? get_term_link($term) : '';
    $color = get_field('category_color', $term);
    $catColor = ($color) ? $color:'#FFF';
    $catColor2 = ($color) ? $color:'#000';
    $firstCharacter = ($term_name) ? strtoupper(substr($term_name, 0, 1)) : '';
    $thumbid = get_post_thumbnail_id($post);
    $img = wp_get_attachment_image_src($thumbid,'large');
    $image_url = ($img) ? $img[0] : '';

    // $start = tribe_get_start_date($post,null,'M d');
    // $end = tribe_get_end_date($post,null,'M d');
    // $start_time = tribe_get_start_time($post,false,'g:ia');
    // $end_time = tribe_get_end_time($post,false,'g:ia');
    // $event_dates = $start;
    // if($start!=$end) {
    //   $event_dates = ( array_filter(array($start,$end)) ) ? implode(' &ndash; ',array_filter(array($start,$end))) : '';
    // }
    // if($start_time || $end_time) {
    //   $st = str_replace(':00','',$start_time);
    //   $et = str_replace(':00','',$end_time);
    //   $times = ( array_filter(array($st,$et)) ) ? implode(' &ndash; ',array_filter(array($st,$et))) : '';
    //   if($event_dates) {
    //     $event_dates .= ' <span>|</span> ' . $times;
    //   } 
    // }

    $event_dates = getEventDateRange($event_id);
    $venue = tribe_get_venue($event_id);
    if($i<=$max_related) { ?>
  	<li>
  		<?php $thumb = ( has_post_thumbnail( $post->ID ) ) ? get_the_post_thumbnail( $post->ID, 'large' ) : '<img src="' . esc_url( trailingslashit( Tribe__Events__Pro__Main::instance()->pluginUrl ) . 'src/resources/images/tribe-related-events-placeholder.png' ) . '" alt="' . esc_attr( get_the_title( $post->ID ) ) . '" />'; ?>
  		<div class="tribe-related-events-thumbnail <?php echo ($image_url) ? 'has-image':'no-image' ?>">
  			<a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>" class="url" rel="bookmark" tabindex="-1">
          <?php //echo $thumb ?>
          <?php if ($image_url) { ?>
            <span class="thumbnail" style="background-image:url('<?php echo esc_url( $image_url ); ?>')"></span>
          <?php } ?>
          <img src="<?php echo IMAGES_URL ?>/rectangle-lg.png" alt="" class="helper">
        </a>
        <?php if ($term) { ?>
        <span class="term-symbol" style="background-color:<?php echo $catColor2 ?>;"><b><?php echo $firstCharacter ?></b></span>
        <?php } ?>
  		</div>
  		<div class="tribe-related-event-info">
  			<h3 class="tribe-related-events-title"><a href="<?php echo tribe_get_event_link( $post ); ?>" class="tribe-event-url" rel="bookmark"><?php echo get_the_title( $post->ID ); ?></a></h3>

        <?php if ($term) { ?>
          <div class="category"><a href="<?php echo $term_link ?>" style="color:<?php echo $catColor ?>"><?php echo $term_name ?></a></div>  
        <?php } ?>

  			<?php
  				// if ( $post->post_type == Tribe__Events__Main::POSTTYPE ) {
  				// 	echo tribe_events_event_schedule_details( $post );
  				// }
  			?>
        <div class="tribe-event-dates"><?php echo $event_dates ?></div>
        <?php if ($venue) { ?>
        <div class="tribe-event-venue"><?php echo $venue ?></div> 
        <?php } ?>
  		</div>
  	</li>
    <?php } ?>
	<?php $i++; endforeach; ?>
</ul>
<?php
endif;
