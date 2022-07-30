<?php
/**
 * View: Top Bar - Date Picker
 *
 * Override this template in your own theme by creating a file at:
 * [your-theme]/tribe/events/v2/day/top-bar/datepicker.php
 *
 * See more documentation about our views templating system.
 *
 * @link http://evnt.is/1aiy
 *
 * @version 5.3.0
 *
 * @var string $now                    The current date and time in the `Y-m-d H:i:s` format.
 * @var object $date_formats           Object containing the date formats.
 */
use Tribe__Date_Utils as Dates;

$default_date        = $now;
$selected_date_value = $this->get( [ 'bar', 'date' ], $default_date );
if ( empty( $selected_date_value ) ) {
	$selected_date_value = $default_date;
}

$selected_datetime = strtotime( $selected_date_value );
$selected_date_label = date_i18n( tribe_get_date_format( true ), $selected_datetime );

$datepicker_date = Dates::build_date_object( $selected_date_value )->format( $date_formats->compact );


$events = tribe_get_events([
  'posts_per_page' => 1,
  'start_date'     => 'now',
]);

$init_date = esc_attr( $datepicker_date );
$custom_selected_datetime = esc_attr( date( 'Y-m-d', $selected_datetime ) );
$custom_selected_date_label = esc_html( $selected_date_label );
if($events) {
  $first_event_id = $events[0]->ID;
  $init_date = tribe_get_start_date($first_event_id,null,'m/d/Y');
  $custom_selected_datetime = date('Y-m-d',strtotime($init_date));
  $custom_selected_date_label = date('F j, Y',strtotime($init_date));
}


?>
<div class="tribe-events-c-top-bar__datepicker">
	<button
		class="tribe-common-h3 tribe-common-h--alt tribe-events-c-top-bar__datepicker-button"
		data-js="tribe-events-top-bar-datepicker-button"
		type="button"
		aria-label="<?php esc_attr_e( 'Click to toggle datepicker', 'the-events-calendar' ); ?>"
		title="<?php esc_attr_e( 'Click to toggle datepicker', 'the-events-calendar' ); ?>"
	>
		<time
			datetime="<?php echo $custom_selected_datetime; ?>"
			class="tribe-events-c-top-bar__datepicker-time"
		>
			<span class="tribe-events-c-top-bar__datepicker-mobile">
				<?php echo $init_date; ?>
			</span>
			<span class="tribe-events-c-top-bar__datepicker-desktop tribe-common-a11y-hidden">
				<?php echo $custom_selected_date_label; ?>
			</span>
		</time>
		<?php $this->template( 'components/icons/caret-down', [ 'classes' => [ 'tribe-events-c-top-bar__datepicker-button-icon-svg' ] ] ); ?>
	</button>
	<label
		class="tribe-events-c-top-bar__datepicker-label tribe-common-a11y-visual-hide"
		for="tribe-events-top-bar-date"
	>
		<?php esc_html_e( 'Select date.', 'the-events-calendar' ); ?>
	</label>
	<input
		type="text"
		class="tribe-events-c-top-bar__datepicker-input tribe-common-a11y-visual-hide"
		data-js="tribe-events-top-bar-date"
		id="tribe-events-top-bar-date"
		name="tribe-events-views[tribe-bar-date]"
		value="<?php echo $init_date; ?>"
		tabindex="-1"
		autocomplete="off"
		readonly="readonly"
	/>
	<div class="tribe-events-c-top-bar__datepicker-container" data-js="tribe-events-top-bar-datepicker-container"></div>
	<template class="tribe-events-c-top-bar__datepicker-template-prev-icon">
		<?php $this->template( 'components/icons/caret-left', [ 'classes' => [ 'tribe-events-c-top-bar__datepicker-nav-icon-svg' ] ] ); ?>
	</template>
	<template class="tribe-events-c-top-bar__datepicker-template-next-icon">
		<?php $this->template( 'components/icons/caret-right', [ 'classes' => [ 'tribe-events-c-top-bar__datepicker-nav-icon-svg' ] ] ); ?>
	</template>
</div>
