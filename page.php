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
  <?php  
    $header_image = get_field('header_image');
    $header_bg = ($header_image) ? ' style="background-image:url('.$header_image['url'].')"' : '';
  ?>

    

    <header class="page-header"<?php echo $header_bg ?>>
      <h1 class="page-title"><span class="animated"><span class="rotated"><?php the_title(); ?></span></span></h1>
    </header>


    <section class="entry-content">
      <div class="middle-container">
        <?php the_content(); ?>
      </div>
    </section>
	<?php endwhile; ?>	
</div>
<?php
get_footer();
