<?php  
  $cta = get_field('pyv_cta');
  $ctaLink = (isset($cta['url']) && $cta['url']) ? $cta['url'] : 'javascript:void(0)';
  $ctaText = (isset($cta['title']) && $cta['title']) ? $cta['title'] : '';
  $ctaTarget = (isset($cta['target']) && $cta['target']) ? $cta['target'] : '_self';
  $columns = get_field('pyv_columns');
  $columnTypes = array('leftcol','rightcol');

  $left_text = ( isset($columns['leftcol_large_text']) && $columns['leftcol_large_text'] ) ? $columns['leftcol_large_text'] : '';
  $right_text = ( isset($columns['rightcol_large_text']) && $columns['rightcol_large_text'] ) ? $columns['rightcol_large_text'] : '';
?>

<?php if ( (isset($columns['leftcol_image']) && $columns['leftcol_image']) && (isset($columns['rightcol_image']) && 
      $columns['rightcol_image']) &&  $left_text && $right_text ) { ?>
<section id="plan-visit-section" class="section plan-visit-section" data-scroll-section data-persistent>
  <?php if ($ctaText && $ctaLink) { ?>
  <header class="section-title-center green">
    <div class="inner"><h2><a href="<?php echo $ctaLink ?>" target="<?php echo $ctaTarget ?>"><?php echo $ctaText ?></a></h2></div>
  </header>
  <?php } ?>

  <?php if ( (isset($columns['leftcol_image']) && $columns['leftcol_image']) && (isset($columns['rightcol_image']) && $columns['rightcol_image']) ) { ?>
  <div class="section-content">
    <div class="flexwrap">
      <?php $i=1; foreach ($columnTypes as $col) { 
        $image = ( isset($columns[$col.'_image']) && $columns[$col.'_image'] ) ? $columns[$col.'_image'] : '';
        $large_text = ( isset($columns[$col.'_large_text']) && $columns[$col.'_large_text'] ) ? $columns[$col.'_large_text'] : '';
        $title = ( isset($columns[$col.'_title']) && $columns[$col.'_title'] ) ? $columns[$col.'_title'] : '';
        $description = ( isset($columns[$col.'_description']) && $columns[$col.'_description'] ) ? $columns[$col.'_description'] : '';
        $button = ( isset($columns[$col.'_button']) && $columns[$col.'_button'] ) ? $columns[$col.'_button'] : '';
        $buttonLink = (isset($button['url']) && $button['url']) ? $button['url'] : '';
        $buttonText = (isset($button['title']) && $button['title']) ? $button['title'] : '';
        $buttonTarget = (isset($button['target']) && $button['target']) ? $button['target'] : '_self';

        $class = ($i==1) ? 'f-left':'f-right';
        if($image) { ?>
          <div class="fcol <?php echo $class ?>">
            <div class="large-photo-block" data-scroll>
              <figure class="img-bg" style="background-image:url('<?php echo $image['url'] ?>')">
                <span class="caption">
                  <?php if ($title) { ?>
                  <span class="title"><?php echo $title ?></span>
                  <?php } ?>
                </span>
                <img src="<?php echo IMAGES_URL ?>/square.png" alt="" aria-hidden="true" />
              </figure>
              <?php if ($large_text) { ?>
              <span class="rotated-large-title"><span><?php echo $large_text ?></span></span>  
              <?php } ?>

              <?php if ($description || $button) { ?>
              <span class="image-caption">
                <span class="inner">
                  <?php if ($title) { ?>
                  <span class="title"><?php echo $title ?></span>
                  <?php } ?>

                  <?php if ($description) { ?>
                  <span class="description"><?php echo $description ?></span>
                  <?php } ?>

                  <?php if ($buttonText && $buttonLink) { ?>
                  <a href="<?php echo $buttonLink ?>" target="<?php echo $buttonTarget ?>" class="theme-btn"><span><?php echo $buttonText ?></span></a>
                  <?php } ?>
                </span>
              </span>
              <?php } ?>
            </div>
          </div>
        <?php $i++; } ?>
      <?php } ?>
    </div>
  </div>
  <?php } ?>

  
</section>
<?php } ?>