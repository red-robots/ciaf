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

$time_format = tribe_get_time_format();
$display_end_date = $event->dates->start_display->format( 'H:i' ) !== $event->dates->end_display->format( 'H:i' );

$start = tribe_get_start_date($event,false,'M d');
$end = tribe_get_end_date($event,false,'M d');
$start_time = tribe_get_start_date($event,null,'g:ia');
$end_time = tribe_get_end_date($event,null,'g:ia');

// $start_time = tribe_get_start_time($event,false,'g:ia');
// $end_time = tribe_get_end_time($event,false,'g:ia');

$start_time_i = tribe_get_start_time($event,false,'g:ia');
$end_time_i = tribe_get_end_time($event,false,'g:ia');

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

  if($start==$end) {
    if($event_dates) {
      $event_dates .= ' <span>|</span> ' . $times;
    } 
  }
}


?>
<div class="tribe-events-pro-photo__event-datetime tribe-common-b2">
	<div class="tribe-event-date"><?php echo $event_dates ?></div>
</div>
