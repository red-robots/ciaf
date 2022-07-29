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

//$time_format = tribe_get_time_format();
//$display_end_date = $event->dates->start_display->format( 'H:i' ) !== $event->dates->end_display->format( 'H:i' );
// $start_time = tribe_get_start_time($event,false,'g:ia');
// $end_time = tribe_get_end_time($event,false,'g:ia');

// $start = tribe_get_start_date($event,false,'M d');
// $end = tribe_get_end_date($event,false,'M d');
// $start_time = tribe_get_start_date($event,null,'g:ia');
// $end_time = tribe_get_end_date($event,null,'g:ia');

// $start_time_i = tribe_get_start_time($event,false,'g:ia');
// $end_time_i = tribe_get_end_time($event,false,'g:ia');

// $event_dates = $start;
// if($start!=$end) {
//   $event_dates = ( array_filter(array($start,$end)) ) ? implode(' &ndash; ',array_filter(array($start,$end))) : '';
// }
// if($start_time_i || $end_time_i) {
//   $st = str_replace(':00','',$start_time);
//   $et = str_replace(':00','',$end_time);
//   $times = ( array_filter(array($st,$et)) ) ? implode(' &ndash; ',array_filter(array($st,$et))) : '';
//   if($start_time==$end_time) {
//     $times = $start_time;
//   }

//   if($start==$end) {
//     if($event_dates) {
//       $event_dates .= ' <span>|</span> ' . $times;
//     } 
//   }
// }

// $post_id = $event->ID;
// $children = list_children_events($post_id);
// $the_dates = array();
// if($children) {
//   foreach($children as $id) {
//     $month = tribe_get_start_date($id,false,'M');
//     $day = tribe_get_start_date($id,false,'d');
//     $the_dates[$month][$day] = $day;
//   }
// }

// $recurring_dates = [];
// if($the_dates) {
//   foreach($the_dates as $month=>$dates) {
//     sort($dates);
//     $the_dates[$month] = $dates;
//     $max = count($dates);
//     $first = $dates[0];
//     $last = end($dates);
//     $n = $max - 1;
//     $compare = $first + ($max - 1);
//     $ranges = array_to_group_range($dates);
//     $recurring_dates[$month] = $ranges;
//   }
// }

// $final_dates = '';
// if($recurring_dates) {
//   $c=1;
//   foreach( $recurring_dates as $month => $days ) {
//     $separator = ($c>1) ? ', ':'';
//     $range_days = '';
//     $month_info = '';
//     foreach($days as $x=>$numdays) {
//       $comma = ($x>0) ? ', ':'';
//       if($numdays && is_array($numdays)) {
//         $days_info = '';
//         foreach($numdays as $k=>$v) {
//           $sep = ($k>0) ? ' - ':'';
//           $days_info .= $sep . $v;
//         }
//         $range_days .= $comma . $month . ' ' . $days_info;
//       } else {
//         $range_days .= $comma . $month . ' ' . $numdays;
//       }
//     }
//     $final_dates .= $separator . $range_days;
//     $c++;
//   }
// }

// if($final_dates) {
//   $event_dates =  $final_dates;
// }

$event_dates = getEventDateRange($event->ID);
?>
<div class="tribe-events-pro-photo__event-datetime tribe-common-b2">
	<div class="tribe-event-date"><?php echo $event_dates ?></div>
</div>
