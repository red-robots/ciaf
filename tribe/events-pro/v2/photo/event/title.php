<?php
/**
 * View: Photo View - Single Event Title
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/photo/event/title.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */
?>
<?php  
//$ev = get_post();
$event_id = get_the_ID();
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
?>

<?php if ($term) { ?>
<span class="term-symbol" style="background-color:<?php echo $catColor2 ?>;"><b><?php echo $firstCharacter ?></b></span>
<?php } ?>
<h3 class="tribe-events-event-title tribe-common-h6">
  <a
    href="<?php echo esc_url( $event->permalink ); ?>"
    title="<?php echo esc_attr( $event->title ); ?>"
    rel="bookmark"
    class="tribe-events-pro-photo__event-title-link"
    >
    <?php echo wp_kses_post( get_the_title( $event->ID ) ); ?>
  </a>
</h3>
<?php if ($term) { ?>
  <div class="category"><a href="<?php echo $term_link ?>" style="color:<?php echo $catColor ?>"><?php echo $term_name ?></a></div>  
<?php } ?>

