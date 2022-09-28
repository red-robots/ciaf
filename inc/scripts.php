<?php
/**
 * Enqueue scripts and styles.
 */
function bellaworks_scripts() {
	wp_enqueue_style( 'bellaworks-style', get_stylesheet_uri(), array(), '1.1' );

	wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://code.jquery.com/jquery-3.3.1.min.js', false, '3.5.1', false);
		wp_enqueue_script('jquery');

	  wp_enqueue_script( 
			'jquery-migrate','https://code.jquery.com/jquery-migrate-1.4.1.min.js', 
			array(), '20200713', 
			false 
		);

    

    wp_enqueue_script( 
     'bellaworks-blocks', 
     get_template_directory_uri() . '/assets/js/vendor.min.js', 
     array(), '10092021', 
     true 
    );

	wp_enqueue_script( 
			'vimeo-player', 
			'https://player.vimeo.com/api/player.js', 
			array(), '2.12.2', 
			true 
		);

  wp_enqueue_script( 
    'masonry', 
    get_template_directory_uri() . '/assets/js/vendor/imagesloaded.pkgd.min.js?v=5.0.0', 
    array(), '20220606', 
    true 
  );

  // if( is_home() || is_front_page() ) {
  //   wp_enqueue_script( 
  //     'circletype', 
  //     get_template_directory_uri() . '/assets/js/vendor/circletype.min.js', 
  //     array(), '20220601', 
  //     true 
  //   );
  //   wp_enqueue_script( 
  //     'gsap', 
  //     'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.2.4/gsap.min.js', 
  //     array(), '20220601', 
  //     true 
  //   );
  //   wp_enqueue_script( 
  //     'ScrollTrigger', 
  //     'https://cdnjs.cloudflare.com/ajax/libs/ScrollTrigger/1.0.5/ScrollTrigger.min.js', 
  //     array(), '20220601', 
  //     true 
  //   );
  // }

  wp_enqueue_script( 
    'nice-select', 
    get_template_directory_uri() . '/assets/js/vendor/jquery.nice-select.min.js', 
    array(), '20220710', 
    true 
  );

  wp_enqueue_script( 
    'wow', 
    get_template_directory_uri() . '/assets/js/vendor/wow.min.js', 
    array(), '06272022', 
    true 
  );

  wp_enqueue_script( 
		'bellaworks-custom', 
		get_template_directory_uri() . '/assets/js/custom.js', 
		array(), '20220629', 
		true 
	);

	wp_localize_script( 'bellaworks-custom', 'frontajax', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));

	wp_enqueue_script( 
		'font-awesome', 
		'https://use.fontawesome.com/8f931eabc1.js', 
		array(), '20180424', 
		true 
	);



	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bellaworks_scripts' );


function dr_admin_footer_scripts() { ?>
<script type="text/javascript">
jQuery(document).ready(function($){
  $('[data-name="frame_type"][data-type="radio"] .acf-radio-list li').each(function(){
    var optionVal = $(this).find('input[type="radio"]').val();
    $(this).addClass(optionVal);
  });
});
</script>
<?php }
add_action( 'admin_footer', 'dr_admin_footer_scripts' ); 

function dr_admin_head_scripts() { ?>
<style type="text/css">
[data-name="frame_type"][data-type="radio"] ul.acf-radio-list {
  margin-bottom: 0;
}
[data-name="frame_type"][data-type="radio"] ul.acf-radio-list li {
  width: 60px;
  height: 60px;
  margin-right: 15px!important;
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
}
[data-name="frame_type"][data-type="radio"] li label {
  color: transparent;
  position: relative;
  z-index: 15;
}
[data-name="frame_type"][data-type="radio"] li label input {
  position: absolute;
  top: -6px;
  left: -4px;
  margin: 0 0;
}
/*[data-name="frame_type"][data-type="radio"] li:before {
  content: "";
  display: block;
  width: 60px;
  height: 60px;
  background-size: contain;
  background-position: center;
  background-repeat: no-repeat;
  position:  absolute;
  top: 0;
  left: 0;
}*/

/*.acf-field.acf-field-image.acf-field-6177a5520e7e2 .acf-label {
  display: none!important;
}*/
<?php for($i=1;$i<=5;$i++) { ?>
[data-name="frame_type"][data-type="radio"] li.frame<?php echo $i ?> {
  background-image: url('<?php echo get_images_dir('frames/frame'.$i.'.png') ?>');
}
<?php } ?>
</style>
<?php }
add_action( 'admin_head', 'dr_admin_head_scripts' ); 


