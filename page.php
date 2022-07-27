<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */
get_header(); ?>
<div id="primary" class="content-area default-template">
	<?php while ( have_posts() ) : the_post(); ?>
  
    <?php include( locate_template('parts/hero-subpage.php') ); ?>

    <section class="entry-content">

      <div class="top-shapes">
        <div class="inner">
          <span class="shape1 wow rollIn" data-wow-delay="0.3s"></span>
          <span class="shape2 wow jackInTheBox" data-wow-delay="0.5s"></span>
        </div>
      </div>

      <div class="middle-container wow fadeIn" data-wow-delay="0.4s">
        <?php the_content(); ?>
      </div>

      <div class="bottom-shapes">
        <div class="inner"><span class="shape3 wow jackInTheBox" data-wow-delay="0.6s"></span></div>
      </div>
    </section>
	<?php endwhile; ?>	
</div>
<?php
get_footer();
