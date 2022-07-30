<?php
/**
 * View: Photo View - Single Event Date Time
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events-pro/v2/photo/event/date-time.php
 *
 * See more documentation about our views templating system.
 *
 * @link https://evnt.is/1aiy
 *
 * @since 5.0.0
 * @since 5.1.1 Moved icons out to separate templates.
 * @since 5.9.1
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 * @var obj     $date_formats Object containing the date formats.
 *
 * @see tribe_get_event() For the format of the event object.
 *
 * @version 5.9.1
 */
$event_id = $event->ID;
$event_dates = getEventDateRange($event->ID);
?>
<div class="tribe-events-pro-photo__event-datetime tribe-common-b2">
	<div class="tribe-event-date"><?php echo $event_dates ?></div>
</div>
