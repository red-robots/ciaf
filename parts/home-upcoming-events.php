<?php /* UPCOMING EVENTS */ 
$show_count = ( get_field('upcoming_events_total_display') ) ? get_field('upcoming_events_total_display') : 10;
$events = tribe_get_events( [
  'posts_per_page' => $show_count,
  'start_date'     => 'now',
]);
$event_terms = array();
$eventDateList = array();
if($events) {
  foreach($events as $e) {
    $terms = wp_get_post_terms( $e->ID, Tribe__Events__Main::TAXONOMY );
    $start = tribe_get_start_date($e,null,'m.d.Y');
    if($start) {
      $eventDateList[$start] = $start;
    }
    if($terms) {
      foreach($terms as $term) {
        $color = get_field('category_color', $term);
        $catColor = ($color) ? $color:'#FFF';
        $term->textcolor = $catColor;
        $event_terms[$term->term_id] = $term;
      }
    }
  } 

  $section_title = get_field('upcoming_events_section_title');
  $viewBtn = get_field("upcoming_events_button");
  $btnTitle = (isset($viewBtn['title']) && $viewBtn['title']) ? $viewBtn['title'] : '';
  $btnLink = (isset($viewBtn['url']) && $viewBtn['url']) ? $viewBtn['url'] : '';
  $btnTarget = (isset($viewBtn['target']) && $viewBtn['target']) ? $viewBtn['target'] : '_self';
  $custom_slide_buttons = '';
  ?>
  <section id="upcoming-events" class="section upcoming-events-section blue-bg" data-scroll-section data-persistent>
    <div class="section-inner-content">
      <?php if ( $section_title ) { ?>
      <header id="upcoming-events-heading" class="section-header">
        <div class="wrapper">
          <div class="flexwrap">
            <div class="fcol left">
              <h2 class="section-title"><?php echo $section_title ?></h2>
            </div>
          </div>
        </div>
        <?php if ( $btnTitle && $btnLink ) { ?>
        <a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="view-all-btn theme-btn"><span><?php echo $btnTitle ?></span></a>
        <?php } ?>
      </header>
      <?php } ?>
      
      <div class="filter-action">
        <div class="filter-wrap">
          <?php if ($event_terms) { ?>
          <div class="filter-col fc-left">
            <label>Filter by type:</label>
            <div class="selections by-type owl-filter-bar">

              <div id="filter-cat-link">
                <a id="term-all" href="javascript:void(0)" data-term="all" data-owl-filter="*" class="item filter-All active"><span>All</span></a>
                <?php foreach ($event_terms as $term) { ?>
                <a href="javascript:void(0)" id="term-<?php echo $term->slug; ?>" data-term="<?php echo $term->slug; ?>" class="item cat_<?php echo $term->slug; ?>" data-owl-filter=".term-<?php echo $term->slug; ?>" style="color:<?php echo $term->textcolor; ?>"><span><?php echo $term->name; ?></span></a>
                <?php } ?>
              </div>

              <div id="filter-dropdown">
                <span class="selectwrap">
                  <select id="filterEventType" name="event_type">
                    <option value="*">EVENT TYPE</option>
                    <?php foreach ($event_terms as $term) { ?>
                    <option value="<?php echo $term->slug ?>"><?php echo $term->name; ?></option>
                    <?php } ?>
                  </select>
                </span>
              </div>

            </div>
          </div>
          <?php } ?>

          <?php if ($eventDateList) { ?>
          <div class="filter-col fc-right">
            <label>Filter by date:</label>
            <div class="selections by-date">
              <span class="selectwrap">
                <select id="filterByDate" name="date" class="nice-select">
                  <option data-display="SELECT DATE">---</option>
                  <?php foreach ($eventDateList as $date) { ?>
                  <option value="<?php echo $date ?>"><?php echo $date ?></option>
                  <?php } ?>
                </select>
              </span>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>

      <div class="upcoming-events-list">
        <!-- <div class="wrapper wrap-resizer">&nbsp;</div> -->
        <div class="inner-wrap">
          <div id="upcoming_events_carousel" data-total="<?php echo $show_count ?>" class="owl-carousel owl-theme">
            <?php $ctr=1; foreach($events as $ev) { 
              $event_id = $ev->ID;
              $thumb_id = get_post_thumbnail_id($event_id);
              $img = wp_get_attachment_image_src($thumb_id,'full');
              $style = ($img) ? ' style="background-image:url('.$img[0].')"':'';
              $pagelink = get_permalink($event_id);
              $terms = wp_get_post_terms( $event_id, Tribe__Events__Main::TAXONOMY );
              $term = (isset($terms[0]) && $terms[0]) ? $terms[0] : '';
              $term_id = (isset($term->term_id) && $term->term_id) ? $term->term_id : '';
              $term_slug = (isset($term->slug) && $term->slug) ? $term->slug : '';
              $term_class = ($term_slug) ? ' term-'.$term_slug : '';
              $firstCharacter = (isset($term->name) && $term->name) ? strtoupper(substr($term->name, 0, 1)) : '';

              $color = get_field('category_color', $term);
              $catColor = ($color) ? $color:'#FFF';

              $start = tribe_get_start_date($ev,null,'M d');
              $end = tribe_get_end_date($ev,null,'M d');
              $start_time = tribe_get_start_date($ev,null,'g:ia');
              $end_time = tribe_get_end_date($ev,null,'g:ia');

              // $start_time = tribe_get_start_time($ev,false,'g:ia');
              // $end_time = tribe_get_end_time($ev,false,'g:ia');

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
                  $event_dates .= ' <span>|</span> ' . $times;
                } 
              }
              $event_start_format = tribe_get_start_date($event_id,null,'m.d.Y');
              $venue = tribe_get_venue($event_id);
              
              ?>
              <div id="event-item-<?php echo $ctr; ?>" data-start="<?php echo $event_start_format ?>" data-termid="<?php echo $term_id ?>" data-term="<?php echo $term_slug ?>" class="item event project  upcoming-event-info<?php echo $term_class ?>">
                <div class="imagewrap">
                  <a href="<?php echo $pagelink ?>" class="image">
                    <figure class="img-bg" <?php echo $style ?>>
                      <img src="<?php echo IMAGES_URL ?>/rectangle-lg.png" alt="" aria-hidden="true" />
                    </figure>
                  </a>
                  <?php if ($firstCharacter) { ?>
                  <span class="term-symbol <?php echo ($color) ? 'text-white':'text-dark';?>" style="background:<?php echo $catColor ?>;"><b><?php echo $firstCharacter ?></b></span>
                  <?php } ?>
                </div>
                <h3><a href="<?php echo $pagelink ?>"><?php echo $ev->post_title ?></a></h3>
                <?php if ($term) { ?>
                <div class="term" style="color:<?php echo $catColor ?>"><?php echo $term->name ?></div>
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
              </div>
            <?php $ctr++; } ?>
          </div>
          <a href="javascript:void(0)" class="customNav" data-action=".owl-prev" id="customNavPrev"><span>Prev</span></a>
          <a href="javascript:void(0)" class="customNav" data-action=".owl-next" id="customNavNext"><span>Next</span></a>
        </div>
      </div>  

      <div class="slide-buttons-mobile">
        <?php if ( $btnTitle && $btnLink ) { ?>
        <a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="view-all-btn theme-btn"><span><?php echo $btnTitle ?></span></a>
        <?php } ?>
      </div>
    </div>

  </section>
<?php } ?>