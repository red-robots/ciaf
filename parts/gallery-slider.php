<?php  if( isset($images) && $images ) { 
  $count = count($images); 
  $slideClass = ($count==1) ? 'static-slide':'slideshow generic-slider';
  ?>
  <div class="gallery-slide-wrap">
    <div id="gallery-slider" class="slider <?php echo $slideClass ?>">
        <div class="swiper-wrapper">
          <?php foreach ($images as $img) { ?>
            <div class="swiper-slide">
              <div class="slide-image" style="background-image:url('<?php echo $img['url'] ?>')">
                <img src="<?php echo IMAGES_URL ?>/rectangle-lg.png" alt="" class="helper">
              </div>
            </div>
          <?php } ?>
        </div>
    </div>
    <?php if ($count>1) { ?>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>
    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <?php } ?>
  </div>
<?php } ?>


<script>

</script>