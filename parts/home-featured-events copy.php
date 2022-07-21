<?php /* FEATURED EVENTS */ 
$event_column_left_image = get_field('event_column_left_image');
$event_bg_img = ($event_column_left_image) ? ' style="background-image:url('.$event_column_left_image['url'].')"' : '';
$event_circular_text = get_field('event_circular_text');
// $featuredEvents = tribe_get_events( [
//   'start_date'     => 'now',
//   'posts_per_page' => 10,
//   'featured'       => true,
//   'meta_key' => '_EventRecurrence',
//   'meta_value' => '',
//   'meta_compare' => '=='
// ] );

$featuredEvents = tribe_get_events( array(
  'posts_per_page'    => 10,
  'start_date'        => 'now',
  'featured'          => true,
  'post_parent__in'   => array( 0 )
) );

$default_color = '';
$default_firstChar = '';
if ($featuredEvents) {
  $first_item = $featuredEvents[0];
  $f_event_id = $first_item->ID;
  $f_terms = wp_get_post_terms( $f_event_id, Tribe__Events__Main::TAXONOMY );
  $f_term = (isset($f_terms[0]) && $f_terms[0]) ? $f_terms[0] : '';
  if($f_terms) {
    $default_firstChar = ($f_term->name) ? strtoupper(substr($f_term->name, 0, 1)) : '';
    $f_color = get_field('category_color', $f_term);
    if($f_color) {
      $default_color = $f_color;
    }
  }
}
?>
<section id="events-section" class="section c-section -fixed featured-events-section events-section">
  <div class="section-content">
    <div class="flex-wrap">
      <div id="featured_event_imagecol" class="flexcol fleft"<?php echo $event_bg_img ?>></div>
      <div class="flexcol fright">

        <div class="featured-events">
          
          <?php if ($featuredEvents) { ?>
          <div class="swiper swiper-events">
            <div class="swiper-wrapper">
              
              <?php $ctr=1; foreach ($featuredEvents as $ev) { 
                $event_id = $ev->ID;
                $pagelink = get_permalink($event_id);
                $excerpt = ($ev->post_content) ? shortenText(strip_tags($ev->post_content),200,' ',"...") : ''; 
                $terms = wp_get_post_terms( $event_id, Tribe__Events__Main::TAXONOMY );
                $term = (isset($terms[0]) && $terms[0]) ? $terms[0] : '';
                $categoryName = (isset($term->name) && $term->name) ? $term->name : '';
                $firstCharacter = ($categoryName) ? strtoupper(substr($categoryName, 0, 1)) : '';
                $color = get_field('category_color', $term);
                $catColor = ($color) ? $color:'#CCC';
                $start = tribe_get_start_date($ev,null,'M d');
                $end = tribe_get_end_date($ev,null,'M d');
                // $start_time = tribe_get_start_date($ev,null,'g:ia');
                // $end_time = tribe_get_end_date($ev,null,'g:ia');

                $start_time = tribe_get_start_time($ev,false,'g:ia');
                $end_time = tribe_get_end_time($ev,false,'g:ia');
                $event_dates = $start;
                if($start!=$end) {
                  $event_dates = ( array_filter(array($start,$end)) ) ? implode(' &ndash; ',array_filter(array($start,$end))) : '';
                }
                if($start_time || $end_time) {
                  $st = str_replace(':00','',$start_time);
                  $et = str_replace(':00','',$end_time);
                  $times = ( array_filter(array($st,$et)) ) ? implode(' &ndash; ',array_filter(array($st,$et))) : '';
                  if($event_dates) {
                    $event_dates .= ' | ' . $times;
                  } 
                }
                $venue = tribe_get_venue($event_id);
                $thumbnail_id = get_post_thumbnail_id($event_id);
                $img = wp_get_attachment_image_src($thumbnail_id,'full');
                $img_src = ($img) ? $img[0]:'';
                $first_slide = ($ctr==1) ? ' first':'';
                ?>
                <div class="swiper-slide">
                  <div class="event <?php echo $first_slide ?>" data-image="<?php echo $img_src ?>" data-event-type="<?php echo $firstCharacter ?>" data-color="<?php echo ($categoryName) ? $catColor : 'transparent' ?>">
                    <h2 class="title"><?php echo $ev->post_title ?></h2>
                    <?php if ( $categoryName ) { ?>
                      <div class="tag"><span style="color:<?php echo $catColor ?>"><?php echo $categoryName ?></span></div>
                    <?php } ?>

                    <?php if ($event_dates || $venue) { ?>
                    <div class="info">
                      <?php if ($event_dates) { ?>
                      <div class="date"><?php echo $event_dates ?></div>
                      <?php } ?>
                      <?php if ($venue) { ?>
                      <div class="loc"><?php echo $venue ?></div>
                      <?php } ?>
                    </div>
                    <?php } ?>

                    <div class="summary"> 
                      <p><?php echo $excerpt ?></p>
                    </div>

                    <div class="cta-button">
                      <a href="<?php echo $pagelink ?>" class="button"><span>More Info</span></a>
                    </div>
                  </div>
                </div>
              <?php $ctr++; } ?>
              

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
          </div>
          <?php } ?>

        </div>
      </div>
    </div>
  </div>
</section>