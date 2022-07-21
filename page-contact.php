<?php
/**
 * Template Name: Contact Us
 * 
 */
get_header(); ?>
<div id="primary" class="content-area default-template">
	<?php while ( have_posts() ) : the_post(); ?>
  <?php  
    $header_image = get_field('header_image');
    $header_bg = ($header_image) ? ' style="background-image:url('.$header_image['url'].')"' : '';
  ?>
    <header class="page-header"<?php echo $header_bg ?>>
      <h1 class="page-title"><span class="animated"><span class="rotated"><?php the_title(); ?></span></span></h1>
    </header>

    <section class="entry-content">
      <?php if ( get_the_content() ) { ?>
      <div class="middle-container">
        <?php the_content(); ?>
      </div>
      <?php } ?>


      <?php
        $google_map = get_field('google_map');
        $contact = get_field('contact');
        $contact_form_shortcode = get_field('contact_form_shortcode');
        $heading = ( isset($contact['heading']) && $contact['heading'] ) ? $contact['heading'] : '';
        $contact_details = ( isset($contact['contact_details']) && $contact['contact_details'] ) ? $contact['contact_details'] : '';
        $column_class = ($google_map && $contact_details) ? 'half' : 'full';
      ?>
        <?php if ( $google_map || $contact_details ) { ?>
        <div class="contact-information">
          <div class="flexwrap <?php echo $column_class ?>">
            <?php if ($contact_details) { ?>
            <div class="fcol left contact_details">
              <div class="inner">
                <?php if ($heading) { ?>
                <h3 class="contact-heading"><?php echo $heading ?></h3> 
                <?php } ?>
                <div class="contact-infos">
                <?php foreach ($contact_details as $d) { 
                  $icon = $d['icon'];
                  $text = $d['text'];
                  if($text) { ?>
                  <div class="info">
                    <?php if ($icon) { ?>
                    <span class="icon" style="background-image:url('<?php echo $icon['url'] ?>')"></span>  
                    <?php } ?>
                    <div class="text"><?php echo $text ?></div>
                  </div>
                  <?php } ?>
                <?php } ?>
                </div>
              </div>
            </div> 
            <?php } ?>

            <?php if ($google_map) { ?>
            <div class="fcol right googlemap">
              <?php echo $google_map ?>
              <img src="<?php echo IMAGES_URL ?>/square.png" alt="" class="helper">
            </div> 
            <?php } ?>
          </div>
        </div>  
        <?php } ?>


        <?php if ( $contact_form_shortcode && do_shortcode($contact_form_shortcode) ) { 
          $contact_form_heading = get_field('contact_form_heading');
          ?>
          <div class="contact-form-section">
            <div class="wrapper">
              <?php if ($contact_form_heading) { ?>
               <h3><?php echo $contact_form_heading ?></h3> 
              <?php } ?>
              <?php echo do_shortcode($contact_form_shortcode); ?>
            </div>
          </div>    
        <?php } ?>
    </section>
	<?php endwhile; ?>	
</div>
<?php
get_footer();
