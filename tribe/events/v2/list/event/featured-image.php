<?php
/**
 * View: List View - Single Event Featured Image
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/featured-image.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.0.0
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 */

if ( ! $event->thumbnail->exists ) {
	return;
}
?>
<div class="tribe-events-calendar-list__event-featured-image-wrapper tribe-common-g-col">
	<a
    href="<?php echo esc_url( $event->permalink ); ?>"
    title="<?php echo esc_attr( $event->title ); ?>"
    rel="bookmark"
    class="tribe-events-calendar-list__event-featured-image-link"
    tabindex="-1"
  > 
    <span class="thumbnail" style="background-image:url('<?php echo esc_url( $event->thumbnail->full->url ); ?>')"></span>
    <img src="<?php echo IMAGES_URL ?>/rectangle-lg.png" alt="" class="helper">
  </a>
</div>
