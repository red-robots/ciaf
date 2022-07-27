<?php  
  $header_image = get_field('header_image');
  $header_bg = ($header_image) ? ' style="background-image:url('.$header_image['url'].')"' : '';
?>
<header class="page-header"<?php echo $header_bg ?>>
  <div class="middle-container">
    <h1 class="page-title animated fadeInRight"><?php the_title(); ?></h1>
  </div>
</header>