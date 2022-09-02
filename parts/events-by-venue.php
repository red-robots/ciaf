<?php
  $venue_id = ( isset($venue_id) && $venue_id ) ? $venue_id : '';
  $perpage = ( isset($perpage) && $perpage ) ? $perpage : 10;
  $paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1; 
  $args = array(
    'post_type'       =>'tribe_events',
    'post_status'     =>'publish',
    'posts_per_page'  => $perpage,
    'post_parent__in' => array( 0 ),
    'meta_key'        => '_EventStartDate',
    'paged'           => $paged, 
    'orderby'         => 'meta_value',
    'order'           => 'ASC',
    'eventDisplay'    => 'startDate',
    'start_date'      => 'now',
  );

  if($venue_id) {
    $args['meta_query'] = array(
                        array(
                          'key'   => '_EventVenueID',
                          'compare' => '=',
                          'value'   => $venue_id,
                        ),    
                      );
  }

  $entries = new WP_Query($args);

  if ($entries->have_posts()) { ?>
  <div id="eventsByVenue" class="tribe-events-wrapper">
    <div class="tribe-events-list">
    <?php while ($entries->have_posts()) : $entries->the_post(); 
      $event_id = get_the_ID();
      $startMonth = tribe_get_start_date($event_id,false,'M');
      $startDay = tribe_get_start_date($event_id,false,'d');
      $start = tribe_get_start_date($event_id,false,'F d');
      $end = tribe_get_end_date($event_id,false,'F d');
      $event_dates = $start;
      if($start!=$end) {
        $event_dates = ( array_filter(array($start,$end)) ) ? implode(' &ndash; ',array_filter(array($start,$end))) : '';
      }
      $thumb_id = get_post_thumbnail_id();
      $featImg = wp_get_attachment_image_src($thumb_id,'medium_large');
      $VenueLat = get_post_meta($venue_id,'_VenueLat',true);
      $VenueLon = get_post_meta($venue_id,'_VenueLng',true);
      $directions = ($VenueLat && $VenueLon) ? $VenueLat.'%2C'.$VenueLon  : '';
      $directionURL = ($directions) ? 'https://www.google.com/maps/search/?api=1&query=' . $directions : '';

      $venue_address = tribe_get_full_address($event_id);
      ?>
      <div data-id="<?php echo $event_id ?>" class="event-info animated fadeIn <?php echo ($featImg) ? 'has-image':'no-image' ?>">
        <div class="date fbox">
          <div class="month"><?php echo $startMonth ?></div>
          <div class="day"><?php echo $startDay ?></div>
        </div>
        <div class="text fbox">
          <div class="dates"><?php echo $event_dates ?></div>
          <div class="event"><?php the_title() ?></div>
          <?php if ($venue = tribe_get_venue($event_id)) { ?>
          <div class="venue"><span class="vname"><?php echo $venue ?></span> <?php if ($venue_address) { ?><span class="address"><?php echo strip_tags($venue_address) ?></span><?php } ?></div> 
          <?php } ?>
          <div class="links"><a href="<?php echo get_permalink() ?>">Event Details</a><?php if ($directionURL) { ?><a href="<?php echo $directionURL ?>" target="_blank">Get Directions</a><?php } ?></div>
        </div>
        <?php if ($featImg) { ?>
        <div class="image fbox">
          <figure>
            <span class="bg" style="background-image:url('<?php echo $featImg[0] ?>')"></span>
            <img src="<?php echo IMAGES_URL ?>/rectangle.png" alt="">
          </figure>
        </div> 
        <?php } ?>
      </div>
    <?php endwhile; wp_reset_postdata(); ?>
    </div>
    <?php
    $total_pages = $entries->max_num_pages;
      if ($total_pages > 1){ ?>
        <div id="tribe-events-pagination" class="pagination">
          <?php
          $pagination = array(
            'base' => @add_query_arg('pg','%#%'),
            'format' => '?paged=%#%',
            'current' => $paged,
            'total' => $total_pages,
            'prev_text' => __( '&laquo;', 'red_partners' ),
            'next_text' => __( '&raquo;', 'red_partners' ),
            'type' => 'plain'
          );
          echo paginate_links($pagination);
          ?>
        </div>
      <?php
      }
    ?>
  </div>  
  <?php } else { ?>

  <div id="eventsByVenue" class="tribe-events-wrapper norecord">
    <div class="event">No record found.</div>
  </div>

  <?php } ?>