<?php
/**
 * Single Event Meta (Details) Template
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe-events/modules/meta/details.php
 *
 * @link http://evnt.is/1aiy
 *
 * @package TribeEventsCalendar
 *
 * @version 4.6.19
 */


$event_id             = Tribe__Main::post_id_helper();
$current_post_id      = $event_id;
$time_format          = get_option( 'time_format', Tribe__Date_Utils::TIMEFORMAT );
$time_range_separator = tribe_get_option( 'timeRangeSeparator', ' - ' );
$show_time_zone       = tribe_get_option( 'tribe_events_timezones_show_zone', false );
$local_start_time     = tribe_get_start_date( $event_id, true, Tribe__Date_Utils::DBDATETIMEFORMAT );
$time_zone_label      = Tribe__Events__Timezones::is_mode( 'site' ) ? Tribe__Events__Timezones::wp_timezone_abbr( $local_start_time ) : Tribe__Events__Timezones::get_event_timezone_abbr( $event_id );

$start_datetime = tribe_get_start_date();
$start_date = tribe_get_start_date( null, false );
$start_time = tribe_get_start_date( null, false, $time_format );
$start_ts = tribe_get_start_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$end_datetime = tribe_get_end_date();
$end_date = tribe_get_display_end_date( null, false );
$end_time = tribe_get_end_date( null, false, $time_format );
$end_ts = tribe_get_end_date( null, false, Tribe__Date_Utils::DBDATEFORMAT );

$time_formatted = null;
if ( $start_time == $end_time ) {
	$time_formatted = esc_html( $start_time );
} else {
	$time_formatted = esc_html( $start_time . $time_range_separator . $end_time );
}

/**
 * Returns a formatted time for a single event
 *
 * @var string Formatted time string
 * @var int Event post id
 */
$time_formatted = apply_filters( 'tribe_events_single_event_time_formatted', $time_formatted, $event_id );

/**
 * Returns the title of the "Time" section of event details
 *
 * @var string Time title
 * @var int Event post id
 */
$time_title = apply_filters( 'tribe_events_single_event_time_title', __( 'Time:', 'the-events-calendar' ), $event_id );

$cost    = tribe_get_formatted_cost();
$website = tribe_get_event_website_link( $event_id );
//$website_title = tribe_events_get_event_website_title();
$website_title = '';
$websiteLink = '';
if($website) {
  $website_str = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $website, $matchstr);
  $website = str_replace('View Event Website','Get Tickets',$website);
  $website = str_replace('&rarr;','',$website);
  if( isset($matchstr[0]) && $matchstr[0] ) {
    $websiteLink = $matchstr[0][0];
  }
}
?>

<div class="tribe-events-meta-group tribe-events-meta-group-details">
	<h2 class="tribe-events-single-section-title"> <?php esc_html_e( 'Details', 'the-events-calendar' ); ?> </h2>
	<dl>

		<?php
		do_action( 'tribe_events_single_meta_details_section_start' );

		// All day (multiday) events
		if ( tribe_event_is_all_day() && tribe_event_is_multiday() ) :
			?>

			<dt class="tribe-events-start-date-label"> <?php esc_html_e( 'Start:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
			</dd>

			<dt class="tribe-events-end-date-label"> <?php esc_html_e( 'End:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-end-date dtend" title="<?php echo esc_attr( $end_ts ); ?>"> <?php echo esc_html( $end_date ); ?> </abbr>
			</dd>

		<?php
		// All day (single day) events
		elseif ( tribe_event_is_all_day() ):
			?>

			<dt class="tribe-events-start-date-label"> <?php esc_html_e( 'Date:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
			</dd>

		<?php
		// Multiday events
		elseif ( tribe_event_is_multiday() ) :
			?>

			<dt class="tribe-events-start-datetime-label"> <?php esc_html_e( 'Start:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-start-datetime updated published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_datetime ); ?> </abbr>
				<?php if ( $show_time_zone ) : ?>
					<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
				<?php endif; ?>
			</dd>

			<dt class="tribe-events-end-datetime-label"> <?php esc_html_e( 'End:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-end-datetime dtend" title="<?php echo esc_attr( $end_ts ); ?>"> <?php echo esc_html( $end_datetime ); ?> </abbr>
				<?php if ( $show_time_zone ) : ?>
					<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
				<?php endif; ?>
			</dd>

		<?php
		// Single day events
		else :
			?>

			<dt class="tribe-events-start-date-label"> <?php esc_html_e( 'Date:', 'the-events-calendar' ); ?> </dt>
			<dd>
				<abbr class="tribe-events-abbr tribe-events-start-date published dtstart" title="<?php echo esc_attr( $start_ts ); ?>"> <?php echo esc_html( $start_date ); ?> </abbr>
			</dd>

			<dt class="tribe-events-start-time-label"> <?php echo esc_html( $time_title ); ?> </dt>
			<dd>
				<div class="tribe-events-abbr tribe-events-start-time published dtstart" title="<?php echo esc_attr( $end_ts ); ?>">
					<?php echo $time_formatted; ?>
					<?php if ( $show_time_zone ) : ?>
						<span class="tribe-events-abbr tribe-events-time-zone published "><?php echo esc_html( $time_zone_label ); ?></span>
					<?php endif; ?>
				</div>
			</dd>

		<?php endif ?>

		<?php
		// Event Cost
		if ( ! empty( $cost ) ) : ?>

			<dt class="tribe-events-event-cost-label"> <?php esc_html_e( 'Cost:', 'the-events-calendar' ); ?> </dt>
			<dd class="tribe-events-event-cost"> <?php echo esc_html( $cost ); ?> </dd>
		<?php endif ?>

		<?php
		echo tribe_get_event_categories(
			get_the_id(),
			[
				'before'       => '',
				'sep'          => ', ',
				'after'        => '',
				'label'        => null, // An appropriate plural/singular label will be provided
				'label_before' => '<dt class="tribe-events-event-categories-label">',
				'label_after'  => '</dt>',
				'wrap_before'  => '<dd class="tribe-events-event-categories">',
				'wrap_after'   => '</dd>',
			]
		);
		?>

		<?php
    /* TAGS */
		// tribe_meta_event_archive_tags(
		// 	/* Translators: %s: Event (singular) */
		// 	sprintf(
		// 		esc_html__( '%s Tags:', 'the-events-calendar' ),
		// 		tribe_get_event_label_singular()
		// 	),
		// 	', ',
		// 	true
		// );
		?>

    <?php 
    /* RECURRING EVENT */
    $children_events = list_children_events($event_id);
    $childrenList = array();

    // $a_month = tribe_get_start_date($event_id,false,'M');
    // $a_day = tribe_get_start_date($event_id,false,'d');
    // $a_start_time_i = tribe_get_start_date($event_id,null,'g:ia');
    // $a_end_time_i = tribe_get_end_date($event_id,null,'g:ia');

    // $a_start_time_d = tribe_get_start_time($event_id,null,'g:ia');
    // $a_end_time_d = tribe_get_end_time($event_id,null,'g:ia');
    // $times = array();
    // $a_index = $a_day;
    // if($a_start_time_d) {
    //   $times['post_id'] = $event_id;
    //   $times['hours'] = array(
    //     'start_time'=>$a_start_time_i,
    //     'end_time'=>$a_end_time_i
    //   );
    //   $childrenList[$a_month][$a_index][] = $times;
    // } else {
    //   $childrenList[$a_month][$a_index] = array();
    // }

    if ($children_events) {
      foreach ($children_events as $id) { 
        $month = tribe_get_start_date($id,false,'M');
        $day = tribe_get_start_date($id,false,'d');
        $start_time = tribe_get_start_date($id,null,'g:ia');
        $end_time = tribe_get_end_date($id,null,'g:ia');

        $start_time_i = tribe_get_start_time($id,false,'g:ia');
        $end_time_i = tribe_get_end_time($id,false,'g:ia');
        $xtimes['post_id'] = $id;
        $index = $day;
        if($start_time_i) {
          $xtimes['hours'] = array(
            'start_time'=>$start_time,
            'end_time'=>$end_time
          );
        } else {
          $xtimes['hours'] = '';
        }     
        $childrenList[$month][$index][] = $xtimes;                 
          
      }
    }

    // echo "<pre>";
    // print_r($childrenList);
    // echo "</pre>";

    

    if ( tribe_is_recurring_event($event_id) ) { 
      $recurring_link = get_permalink($event_id) . '/all/'; 
      $info = tribe_events_event_schedule_details( $event_id, '', '' );
      if($info) {
        $string = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $info, $match);
        $recurring_link = (isset($match[0]) && $match[0]) ? $match[0][0] : '';
        if($childrenList) { ?>
        <dt class="tribe-event-recurring-label">Recurring Event:</dt>
        <dd class="tribe-event-recurring">
          <!-- <a href="<?php //echo $recurring_link ?>" rel="tag">See All</a> -->
          <ul class="recurring-dates">
            <?php foreach ($childrenList as $month=>$dateList) { ?>
            <li class="month-info" data-month="<?php echo $month ?>">
              <?php if ($dateList) {  ksort($dateList); ?>
               <?php foreach ($dateList as $day=>$atts) {  
                    $hasHours = [];
                    foreach ($atts as $hr) { 
                      if(isset($hr['hours']) && $hr['hours']) {
                        $hrx = $hr['hours'];
                        $stx = (isset($hrx['start_time']) && $hrx['start_time']) ? $hrx['start_time'] : '';
                        $etx = (isset($hrx['end_time']) && $hrx['end_time']) ? $hrx['end_time'] : '';
                        
                        if($stx) {
                          $hasHours[] = $hr;
                        } 

                      } 
                    }
                  ?>
                  <?php if ($atts) {  ?>
                    <div class="info">
                      <?php if ($hasHours) { ?>
                        <div class="date"><strong><?php echo $month.' '.$day ?></strong></div>
                        <ul class="hours">
                        <?php foreach ($atts as $hr) { 
                          $postid = $hr['post_id'];
                          $h = $hr['hours'];
                          $st = (isset($h['start_time']) && $h['start_time']) ? $h['start_time'] : '';
                          $et = (isset($h['end_time']) && $h['end_time']) ? $h['end_time'] : '';
                          $hours_range_arr = array($st,$et);
                          $hours_range = '';
                          if( $hours_range_arr && array_filter($hours_range_arr) ) {
                            $hours_range = implode(' – ',$hours_range_arr);
                          }
                          $pagelink = get_permalink($postid);
                          if($hours_range) { ?>
                          <li>
                            <?php if ($current_post_id==$postid) { ?>
                              <span class="time-link"><?php echo $hours_range ?></span>
                            <?php } else { ?>
                              <a href="<?php echo $pagelink ?>" class="time-link"><?php echo $hours_range ?></a>
                            <?php } ?>
                          </li>
                          <?php } ?>
                        <?php } ?>
                        </ul>
                      <?php } else { ?>
                        <?php  
                        $postid = (isset($atts[0]['post_id']) && $atts[0]['post_id']) ? $atts[0]['post_id'] : '';
                        $pagelink = get_permalink($postid);
                        ?>
                        <div class="date no-time-info">
                          <?php if ($current_post_id==$postid) { ?>
                            <span class="date-link"><?php echo $month.' '.$day ?></span>
                          <?php } else { ?>
                            <a href="<?php echo $pagelink ?>" class="date-link"><?php echo $month.' '.$day ?></a>
                          <?php } ?>
                        </div>
                      <?php } ?>
                    </div>
                    <?php } ?>
               <?php } ?> 
              <?php } ?>
            </li> 
            <?php } ?>
          </ul>
        </dd>
        <?php } ?>
      <?php } ?>
    <?php } ?>


    <?php /* GET TICKETS LINK */ ?>
    <?php if ($websiteLink) { ?>
      <dd class="tribe-events-event-url get-tickets-link"><a href="<?php echo $websiteLink ?>" target="_blank" rel="external">Get Tickets</a></dd>  
    <?php } ?>
		

		<?php do_action( 'tribe_events_single_meta_details_section_end' ); ?>
	</dl>

  <?php tribe_get_template_part( 'modules/meta/organizer' ); ?>
</div>
