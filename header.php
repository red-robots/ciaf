<?php  
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; 
$eventsPageRedirectURL = '';
$archive_class = '';
if( is_post_type_archive('tribe_events') ) {
  $baseName = basename($link);
  $tribe = get_option('tribe_events_calendar_options','option_value');
  if($tribe) {
    $view_desktop = $tribe['viewOption'];
    $view_mobile = $tribe['mobile_default_view'];  
    $eventsPageRedirectURL = get_site_url() . '/events/photo/?hide_subsequent_recurrences=1';
    if( wp_is_mobile() ) {
      if($view_mobile=='photo') {
        $archive_class = 'view-mode-photo';
        // if($baseName=='events') {
        //   header("Location: ".$eventsPageRedirectURL);
        //   die();
        // }
      }
    } else {
      if($view_desktop=='photo') {
        $archive_class = 'view-mode-photo';
        // if($baseName=='events') {
        //   header("Location: ".$eventsPageRedirectURL);
        //   die();
        // }
      }
    }
  }
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans+Condensed&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://unpkg.com/swiper@8.3.1/swiper-bundle.min.css" />
<?php if ( is_singular(array('post')) ) { 
global $post;
$post_id = $post->ID;
$thumbId = get_post_thumbnail_id($post_id); 
$featImg = wp_get_attachment_image_src($thumbId,'full'); ?>
<!-- SOCIAL MEDIA META TAGS -->
<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
<meta property="og:url"		content="<?php echo get_permalink(); ?>" />
<meta property="og:type"	content="article" />
<meta property="og:title"	content="<?php echo get_the_title(); ?>" />
<meta property="og:description"	content="<?php echo (get_the_excerpt()) ? strip_tags(get_the_excerpt()):''; ?>" />
<?php if ($featImg) { ?>
<meta property="og:image"	content="<?php echo $featImg[0] ?>" />
<?php } ?>
<!-- end of SOCIAL MEDIA META TAGS -->
<?php } ?>
<script>
var siteURL = '<?php echo get_site_url();?>';
var currentURL = '<?php echo $link;?>';
var baseName = '<?php echo (!is_home() && !is_front_page()) ? basename($link) : ''; ?>';
var params={};location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(s,k,v){params[k]=v});
</script>
<?php wp_head(); ?>
<?php if( $customScripts = get_field('header_custom_scripts','option') ) { ?>
<?php echo $customScripts; ?>
<?php } ?>
<?php // Header notification
      $notifOn = get_field('turn_on', 'option');
      $notifMess = get_field('notification', 'option'); 
      if( $notifOn == 'yes' && $notifMess != '' &&  is_front_page() ) {
?>
<style type="text/css">
  .site-header {
    position: relative;
  }
</style>

  <script>
  jQuery(document).ready(function ($) { 
    var stickyTop = $('.site-header').offset().top;

  $(window).on( 'scroll', function(){
          if ($(window).scrollTop() >= stickyTop) {
              $('.site-header').css({position: "fixed", top: "0px"});
          } else {
              $('.site-header').css({position: "relative", top: "0px"});
          }
      });
  }); 
  </script>
<?php } else { ?>
  <style type="text/css">
  .site-header {
    position: fixed;
  }
</style>
<?php } ?>
</head>

<body <?php body_class($archive_class);?>>
  <a class="skip-link sr" href="#content"><?php esc_html_e( 'Skip to content', 'bellaworks' ); ?></a>
<?php 
      // Header notification
      

      if( $notifOn == 'yes' && $notifMess != '' &&  is_front_page() ) {
        echo '<div class="header-notification">'.$notifMess.'</div>';
      }
   ?>
  <div id="site">
  
  <div id="site-header" class="site-header">

    <div class="wrapper">
      <span id="mobile-menu" class="mobile-menu"><span class="bar"></span></span>
      <div class="inner">
        <div id="site-logo">
          <?php if( get_custom_logo() ) { ?>
            <?php the_custom_logo(); ?>
          <?php } else { ?>
            <h1 class="logo"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
          <?php } ?>
        </div>
        <?php  if ( has_nav_menu( 'primary' ) ) { 
        $items_wrap = '<ul id="%1$s" class="%2$s">%3$s';
        if( $cta = get_field('header_cta','option') ) { 
          $ctaLink = ( isset($cta['url']) && $cta['url'] ) ? $cta['url'] : '';
          $ctaTitle = ( isset($cta['title']) && $cta['title'] ) ? $cta['title'] : '';
          $ctaTarget = ( isset($cta['target']) && $cta['target'] ) ? $cta['target'] : '_self';
          if($ctaTitle && $ctaLink) {
            $cta_button = '<a class="header-cta" href="'.$ctaLink.'" target="'.$ctaTarget.'"><span>'.$ctaTitle.'</span></a>';
            $items_wrap .= sprintf( '<li id="head-cta-btn">%1$s</li></ul>', $cta_button );
          }
        } ?>
        <nav id="navigation" class="main-navigation" role="navigation">
          <?php wp_nav_menu( array( 'theme_location' => 'primary', 'container'=>false, 'menu_id' => 'primary-menu', 'items_wrap' => $items_wrap) ); ?>
        </nav>
        <?php } ?>
      </div>
    </div>
  </div>