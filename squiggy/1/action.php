<style type="text/css">
<?php for($i=1; $i<=23; $i++) { $num=($i/100) * 10; $duration = number_format((float)$num, 2, '.', ''); ?>
.squiggy.viewing .squiggy1 span.span<?php echo $i?> {transition-delay: <?php echo $duration?>s;visibility: visible;}
<?php } ?>
</style>
<div class="squiggy sq1">
  <div class="curvy squiggy1">
    <?php for($i=1; $i<=23; $i++) {
        echo '<span class="span'.$i.'" style="background-image:url('.get_template_directory_uri().'/squiggy/1/img/'.$i.'.gif)"></span>';
      }
    ?>
  </div>
  <?php if ( isset($title1_text) && $title1_text ) { ?>
  <em><?php echo $title1_text ?></em>
  <?php } ?>
</div>