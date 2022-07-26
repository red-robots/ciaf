<?php
$footer_copyright = get_field('footer_copyright','option');
$copyright = ($footer_copyright) ? $footer_copyright : get_bloginfo('name');
$footer_content = get_field('footer_content','option');
$count_widget = ($footer_content) ? count($footer_content) : 0;
$footer_logo = get_field('footer_logo','option');
$footer_partners = get_field('footer_partners','option');
$p_text = (isset($footer_partners['text']) && $footer_partners['text']) ? $footer_partners['text'] : '';
$p_logos = (isset($footer_partners['logos']) && $footer_partners['logos']) ? $footer_partners['logos'] : '';
?>

<footer id="colophon" class="section site-footer" role="contentinfo">
  <div class="wrapper">
    <div class="footer-flexwrap">

      <?php if ($footer_logo || $p_logos) { ?>
      <div class="footcol">
        <?php if ($footer_logo) { ?>
        <div class="foot-logo">
          <img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>">
        </div>
        <?php } ?>
        
        <?php if ($p_logos) { ?>
        <div class="presentedby">
          <?php if ($p_text) { ?>
          <div class="text"><?php echo $p_text ?></div>
          <?php } ?>
          <?php if ($p_logos) { ?>
          <div class="foot-images img">
            <?php foreach ($p_logos as $p) { ?>
            <img src="<?php echo $p['url'] ?>" alt="<?php echo $p['title'] ?>"> 
            <?php } ?>
          </div>
          <?php } ?>
        </div>
        <?php } ?>

        <div id="copyright-mobile"></div>  
      </div>
      <?php } ?>


      <?php if( have_rows('footer_content','option') ) { ?>
        <?php $i=1; while( have_rows('footer_content','option') ) : the_row(); ?>
          <?php  
          $ft_heading = get_sub_field('heading');
          $ft_content = get_sub_field('content');
          $lastcol = ($i==$count_widget) ? ' last':'';
          ?>
          <div class="footcol<?php echo $lastcol ?>">
            <?php if ($ft_heading) { ?>
            <h3 class="title"><?php echo $ft_heading; ?></h3>
            <?php } ?>
            
            <?php if ($ft_content) { ?>
            <div class="footcontent">
              <?php the_sub_field('content'); ?>
            </div>
            <?php } ?>
          </div>
        <?php $i++; endwhile; ?>
      <?php } ?>

      <div id="footer-copyright">
        &copy; <?php echo $copyright.' '.date('Y') ?>
      </div>
      
    </div>
  </div>
</footer><!-- #colophon -->

</div><!-- #site -->

<?php wp_footer(); ?>
</body>
</html>
