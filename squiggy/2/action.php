<style type="text/css">
.squiggy .squiggy2 span. {
  opacity: 0;
}
.squiggy .squiggy2 span.active {
  opacity: 1;
  visibility: visible;
}
</style>
<div class="squiggy sq2">
  <div class="curvy squiggy2">
    <?php for($i=1; $i<=8; $i++) {
        echo '<span class="span'.$i.'" style="background-image:url('.get_template_directory_uri().'/squiggy/2/img/'.$i.'.png)"></span>';
      }
    ?>
  </div>
  <?php if ( isset($title2_text) && $title2_text ) { ?>
  <em><?php echo $title2_text ?></em>
  <?php } ?>
</div>