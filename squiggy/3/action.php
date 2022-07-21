<style type="text/css">
<?php for($i=1; $i<=37; $i++) { $num=($i/100) * 3; $duration = number_format((float)$num, 2, '.', ''); ?>
.squiggy.viewing .squiggy3 span.span<?php echo $i?> {transition-delay: <?php echo $duration?>s;visibility: visible;}
<?php } ?>
</style>
<div class="squiggy sq3">
  <div class="curvy squiggy3">
    <?php for($i=1; $i<=37; $i++) {
        echo '<span class="span'.$i.'" style="background-image:url('.get_template_directory_uri().'/squiggy/3/img/'.$i.'.png)"></span>';
      }
    ?>
  </div>
  <?php if ( isset($title3_text) && $title3_text ) { ?>
  <em><?php echo $title3_text ?></em>
  <?php } ?>
</div>