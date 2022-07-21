<?php if ( isset($homeGallery) && $homeGallery ) { ?>
<div class="images grid grid-no-js" id="imagecol">

  <?php  
  $animatedText = get_field('gallery_animated_text');

  /* animated graphic 1 */
  $title1 = ( isset($animatedText['title1']) && $animatedText['title1'] ) ? $animatedText['title1'] : '';
  $title1_text = ( isset($title1['title']) && $title1['title'] ) ? $title1['title'] : '';
  $title1_img = ( isset($title1['assign_to_image']) && $title1['assign_to_image'] ) ? $title1['assign_to_image'] : '';

  /* animated graphic 2 */
  $title2 = ( isset($animatedText['title2']) && $animatedText['title2'] ) ? $animatedText['title2'] : '';
  $title2_text = ( isset($title2['title']) && $title2['title'] ) ? $title2['title'] : '';
  $title2_img = ( isset($title2['assign_to_image']) && $title2['assign_to_image'] ) ? $title2['assign_to_image'] : '';

  /* animated graphic 3 */
  $title3 = ( isset($animatedText['title3']) && $animatedText['title3'] ) ? $animatedText['title3'] : '';
  $title3_text = ( isset($title3['title']) && $title3['title'] ) ? $title3['title'] : '';
  $title3_img = ( isset($title3['assign_to_image']) && $title3['assign_to_image'] ) ? $title3['assign_to_image'] : '';

  $count = count($homeGallery);
  ?>

  <?php $ctr=1; foreach ($homeGallery as $img) { 
    $img_class = '';
    $graphic1 = '';
    $graphic2 = '';
    $graphic3 = '';
    $has_squiggy = '';
    $animated_text = '';
    if($title1_text && $title1_img) {
      /* SQUIGGY 1 */ 
      if($title1_img==$ctr) {
        $img_class .= ' has-text has-squiggy animation-1';
        ob_start();
        include( locate_template('squiggy/1/action.php') );
        //$graphic1 = ob_get_contents();
        $animated_text = ob_get_contents();
        ob_end_clean();
      }
    }

    if($title2_text && $title2_img) {
      /* SQUIGGY 2 */ 
      if($title2_img==$ctr) {
        $img_class .= ' has-text has-squiggy animation-2';
        ob_start();
        include( locate_template('squiggy/2/action.php') );
        //$graphic2 = ob_get_contents();
        $animated_text = ob_get_contents();
        ob_end_clean();
      }
    }

    if($title3_text && $title3_img) {
      /* SQUIGGY 3 */ 
      if($title3_img==$ctr) {
        $img_class .= ' has-text has-squiggy animation-3';
        ob_start();
        include( locate_template('squiggy/3/action.php') );
        //$graphic3 = ob_get_contents();
        $animated_text = ob_get_contents();
        ob_end_clean();
      }
    }

    $d = $ctr + 1;
    $duration = number_format($d/10,1);
    $img_class .= ( $ctr % 4 == 0 ) ? ' middle':'';
    //$img_class .= ($animated_text) ? '':' next';
    $img_class .= ( $ctr % 2 == 0 ) ? ' even':' odd';
    $img_class .= ($count==$ctr) ? ' last':'';
    if( ($count-1) ==  ($ctr) ) {
      $img_class .= ' before_last ';
    }
  ?>
  <div class="grid-item img<?php echo $ctr.$img_class?>">
    <!-- <figure class="fig1" data-scroll data-scroll-speed="3" data-scroll-repeat data-scroll-target="#imagecol"> -->

    <figure class="fig1" data-scroll>  
      <?php echo $animated_text; ?>
      <img src="<?php echo $img['url'] ?>" alt="<?php echo $img['title'] ?>" style="transition-delay: <?php echo $duration ?>s;">
    </figure>
  </div>
  <?php $ctr++; } ?>

</div>
<?php } ?>


