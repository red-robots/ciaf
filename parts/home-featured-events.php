<?php
$featuredEvents = tribe_get_events( array(
  'posts_per_page'    => 10,
  'start_date'        => 'now',
  'featured'          => true,
  'post_parent__in'   => array( 0 )
) );

$default_color = '';
$default_firstChar = '';
$default_image = '';
if ($featuredEvents) {
  $first_item = $featuredEvents[0];
  $f_event_id = $first_item->ID;
  $f_terms = wp_get_post_terms( $f_event_id, Tribe__Events__Main::TAXONOMY );
  $f_term = (isset($f_terms[0]) && $f_terms[0]) ? $f_terms[0] : '';

  $f_thumb_id = get_post_thumbnail_id($f_event_id);
  $f_img = wp_get_attachment_image_src($f_thumb_id,'full');
  $default_image = ($f_img) ? $f_img[0] : '';

  $home_image = get_field('event_home_image',$f_event_id);
  if($home_image) {
    $default_image = $home_image['url'];
  }

  if($f_terms) {
    $default_firstChar = ($f_term->name) ? strtoupper(substr($f_term->name, 0, 1)) : '';
    $f_color = get_field('category_color', $f_term);
    if($f_color) {
      $default_color = $f_color;
    }
  }
}

$default_color_style = ($default_color) ? ' style="background-color:'.$default_color.'"':'';
$default_image_bg = ($default_image) ? ' style="background-image:url('.$default_image.')"':'';
if($featuredEvents) { ?>
<section class="section featured-events">
  <div class="flexwrap">
    <div class="col col1">
      <div id="featured_event_imagecol"<?php echo $default_image_bg ?>>
        <img src="<?php echo IMAGES_URL ?>/home-image-resizer.png" alt="" class="resizer">
      </div>
    </div>

    <div class="col col2">
      <div id="category-initial"<?php echo $default_color_style ?>><span><?php echo $default_firstChar ?></span></div>
      <div id="featured-events-posts">
        <div id="swiper-vertical" class="swiper-container fadeIn wow" data-wow-duration="1s" data-wow-delay="0.5s">
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
                $start_time = tribe_get_start_date($ev,null,'g:ia');
                $end_time = tribe_get_end_date($ev,null,'g:ia');

                //$start_time = tribe_get_start_time($ev,false,'g:ia');
                //$end_time = tribe_get_end_time($ev,false,'g:ia');

                $start_time_i = tribe_get_start_time($event_id,false,'g:ia');
                $end_time_i = tribe_get_end_time($event_id,false,'g:ia');

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
                    $event_dates .= ' | ' . $times;
                  } 
                }
                $venue = tribe_get_venue($event_id);
                $thumbnail_id = get_post_thumbnail_id($event_id);
                $img = wp_get_attachment_image_src($thumbnail_id,'full');
                $img_src = ($img) ? $img[0]:'';
                $first_slide = ($ctr==1) ? ' first':'';

                $custom_image = get_field('event_home_image',$event_id);
                if($custom_image) {
                  $img_src = $custom_image['url'];
                }

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
          <?php if ( count($featuredEvents) > 1 ) { ?>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>