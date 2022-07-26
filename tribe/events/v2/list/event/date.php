<?php
/**
 * View: List View - Single Event Date
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/list/event/date.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @since 4.9.9
 * @since 5.1.1 Move icons into separate templates.
 *
 * @var WP_Post $event The event post object with properties added by the `tribe_get_event` function.
 *
 * @see tribe_get_event() For the format of the event object.
 *
 * @version 5.1.1
 */
use Tribe__Date_Utils as Dates;

$event_date_attr = $event->dates->start->format( Dates::DBDATEFORMAT );

$start = tribe_get_start_date($event,false,'M d');
$end = tribe_get_end_date($event,false,'M d');
// $start_time = tribe_get_start_time($event,false,'g:ia');
// $end_time = tribe_get_end_time($event,false,'g:ia');
$start_time = tribe_get_start_date($event,null,'g:ia');
$end_time = tribe_get_end_date($event,null,'g:ia');
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
  if($event_dates) {
    $event_dates .= ' <span>|</span> ' . $times;
  } 
}


?>
<div class="tribe-events-calendar-list__event-datetime-wrapper tribe-common-b2">
	<?php // $this->template( 'list/event/date/featured' ); ?>
	<time class="tribe-events-calendar-list__event-datetime" datetime="<?php echo esc_attr( $event_date_attr ); ?>">
		<?php // echo $event->schedule_details->value(); ?>
	</time>
	<?php // $this->template( 'list/event/date/meta', [ 'event' => $event ] ); ?>
  <div class="tribe-event-date"><?php echo $event_dates ?></div>
</div>
