
  <?php if (!is_home() && !is_front_page()) { ?>
  <?php include( locate_template('parts/footer_content.php') ); ?> 
  <?php } ?>
	
<?php wp_footer(); ?>

<!-- <script src="http://remysharp.com/downloads/jquery.inview.js"></script> -->
<script nomodule src="https://cdnjs.cloudflare.com/ajax/libs/babel-polyfill/7.6.0/polyfill.min.js" crossorigin="anonymous"></script>
<script nomodule src="https://polyfill.io/v3/polyfill.min.js?features=Object.assign%2CElement.prototype.append%2CNodeList.prototype.forEach%2CCustomEvent%2Csmoothscroll" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@4.1.4/dist/locomotive-scroll.min.js"></script>
<?php if ( is_home() || is_front_page() ) { ?>
<script src="<?php echo get_template_directory_uri() . '/assets/js/animation.js?v=1.0' ?>"></script> 
<?php } ?>
</body>
</html>
