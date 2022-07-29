<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');
define('ASSETS_URL',get_template_directory_uri() . '/assets');
define('IMAGES_URL',get_template_directory_uri() . '/assets/images');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

function shortenText2($text, $max = 50, $append = '…') {
  if (strlen($text) <= $max) return $text;
  $return = substr($text, 0, $max);
  if (strpos($text, ' ') === false) return $return . $append;
  return preg_replace('/\w+$/', '', $return) . $append;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function get_social_media() {
    $options = get_field("social_media","option");
    $icons = social_icons();
    $list = array();
    if($options) {
        foreach($options as $i=>$opt) {
            if( isset($opt['link']) && $opt['link'] ) {
                $url = $opt['link'];
                $parts = parse_url($url);
                $host = ( isset($parts['host']) && $parts['host'] ) ? $parts['host'] : '';
                if($host) {
                    foreach($icons as $type=>$icon) {
                        if (strpos($host, $type) !== false) {
                            $list[$i] = array('url'=>$url,'icon'=>$icon,'type'=>$type);
                        }
                    }
                }
            }
        }
    }

    return ($list) ? $list : '';
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fa fa-facebook',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fa fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'     => 'fab fa-vimeo',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


/* ACF CUSTOM OPTIONS TABS */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }
/* Options page under custom post type */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_sub_page(array(
//         'page_title'    => 'People Options',
//         'menu_title'    => 'People Options',
//         'parent_slug'   => 'edit.php?post_type=people'
//     ));
// }
// function be_acf_options_page() {
//     if ( ! function_exists( 'acf_add_options_page' ) ) return;
    
//     $acf_option_tabs = array(
//         array( 
//             'title'      => 'Today Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Menu Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Global Options',
//             'capability' => 'manage_options',
//         )
//     );

//     foreach($acf_option_tabs as $options) {
//         acf_add_options_page($options);
//     }
// }
// add_action( 'acf/init', 'be_acf_options_page' );


function get_images_dir($fileName=null) {
    return get_bloginfo('template_url') . '/images/' . $fileName;
}


/* ACF CUSTOM VALUES */
$gravityFormsSelections = array('gravityForm','global_the_form');
function acf_load_gravity_form_choices( $field ) {
    // reset choices
    $field['choices'] = array();
    $choices = getGravityFormList();
    if( $choices && is_array($choices) ) {       
        foreach( $choices as $choice ) {
            $post_id = $choice->id;
            $post_title = $choice->title;
            $field['choices'][ $post_id ] = $post_title;
        }
    }
    return $field;
}
foreach($gravityFormsSelections as $fieldname) {
  add_filter('acf/load_field/name='.$fieldname, 'acf_load_gravity_form_choices');
}

function getGravityFormList() {
  global $wpdb;
  $query = "SELECT id, title FROM ".$wpdb->prefix."gf_form WHERE is_active=1 AND is_trash=0 ORDER BY title ASC";
  $result = $wpdb->get_results($query);
  return ($result) ? $result : '';
}


function custom_excerpt_more( $excerpt ) {
    return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

//change the number for the length you want
function custom_excerpt_length( $length ) {
    return 150;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function get_excerpt($text,$limit=100) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]>', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

    /* This gets rid of all empty p tags, even if they contain spaces or &nbps; inside. */
    $text = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $text); 

    /* Get rid of <img> tag */
    $text = preg_replace("/<img[^>]+\>/i", "", $text); 
    $text = strip_tags($text,"<p><a>");
    $excerpt_length = $limit;
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words)> $excerpt_length) {
            array_pop($words);
            array_push($words, '...');
            $text = implode(' ', $words);
            $text = force_balance_tags( $text );
    }
 
    return $text;
}   


add_shortcode( 'team_list', 'team_list_shortcode_func' );
function team_list_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'numcol'=>3
  ), $atts );
  $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  //include( locate_template('parts/team_feeds.php') );
  get_template_part('parts/team_feeds',null,$a);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'contact_info', 'contact_info_shortcode_func' );
function contact_info_shortcode_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'numcol'=>3
  // ), $atts );

  $info['address'] = array('icon'=>'fa fa-map-marker','val'=>get_field('address','option'));
  $info['phone'] = array('icon'=>'fa fa-phone','val'=>get_field('phone','option'));
  $info['email'] = array('icon'=>'fa fa-envelope','val'=>get_field('email','option'));
  $output = '';
  $items = '';
  foreach($info as $k=>$i) {
    if( $i['val'] ) {
      $icon = ($i['icon']) ? '<i class="'.$i['icon'].'" aria-hidden="true"></i> ':'';
      if($k=='email') {
        $items .= '<li>'.$icon.'<a href="mailto:'.antispambot($i['val'],1).'">'.antispambot($i['val']).'</a></li>';
      } 
      else if($k=='phone') {
        $items .= '<li>'.$icon.'<a href="tel:'.format_phone_number($i['val']).'">'.$i['val'].'</a></li>';
      } 
      else {
        $items .= '<li>'.$icon.$i['val'].'</li>';
      }

      
      
    }
  }
  if($items) {
    $output = '<ul class="contact-data">'.$items.'</ul>';
  }
  return $output;
}


/* Disabling Gutenberg on certain templates */

function ea_disable_editor( $id = false ) {

  $excluded_templates = array(
    'template-flexible-content.php',
    'page-clientlogin.php',
    'page-contact.php'
  );

  $excluded_ids = array(
    get_option( 'page_on_front' ) /* Home page */
  );

  if( empty( $id ) )
    return false;

  $id = intval( $id );
  $template = get_page_template_slug( $id );

  return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * Disable Gutenberg by template
 *
 */
function ea_disable_gutenberg( $can_edit, $post_type ) {

  if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
    return $can_edit;

  if( ea_disable_editor( $_GET['post'] ) )
    $can_edit = false;

  if( get_post_type($_GET['post'])=='team' )
    $can_edit = false;

  return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );

/**
 * Disable Classic Editor by template
 *
 */
// function ea_disable_classic_editor() {

//   $screen = get_current_screen();
//   if( 'page' !== $screen->id || ! isset( $_GET['post']) )
//     return;

//   if( ea_disable_editor( $_GET['post'] ) ) {
//     remove_post_type_support( 'page', 'editor' );
//   }

// }
// add_action( 'admin_head', 'ea_disable_classic_editor' );


function date_intervals_info($compare_date) {
  $now = date('Y-m-d H:i:s');
  // $d1 = new DateTime($now);
  // $d2 = new DateTime($compare_date);
  $info = array();

  //$interval = $d1->diff($d2);
  // $diffInSeconds = $interval->s; //45
  // $diffInMinutes = $interval->i; //23
  // $diffInHours   = $interval->h; //8
  // $diffInDays    = $interval->d; //21
  // $diffInMonths  = $interval->m; //4
  // $diffInYears   = $interval->y; //1
  

  //or get Date difference as total difference
  $d1 = strtotime($now);
  $d2 = strtotime($compare_date);
  $totalSecondsDiff = abs($d1-$d2); //42600225
  $totalMinutesDiff = $totalSecondsDiff/60; //710003.75
  $totalHoursDiff   = $totalSecondsDiff/60/60;//11833.39
  $totalDaysDiff    = $totalSecondsDiff/60/60/24; //493.05
  $totalMonthsDiff  = $totalSecondsDiff/60/60/24/30; //16.43
  $totalYearsDiff   = $totalSecondsDiff/60/60/24/365; //1.35

  $info['months'] = round($totalMonthsDiff);
  $info['days'] = round($totalDaysDiff);
  $info['hours'] = round($totalHoursDiff);
  return $info;
}


function do_increment($number){
  // get amount of decimals
  $decimal = strlen(strrchr($number, '.')) -1;

  $factor = pow(10,$decimal);

  $incremented = (($factor * $number) + 1) / $factor;

  return $incremented;
}


add_shortcode( 'footer_navigation', 'footer_navigation_func' );
function footer_navigation_func( $atts ) {
  // $a = shortcode_atts( array(
  //   'numcol'=>3
  // ), $atts );
  // $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  if ( has_nav_menu( 'footer' ) ) {
    wp_nav_menu( array( 'theme_location' => 'footer', 'container'=>false, 'menu_id' => 'footer-menu') );
  }
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}

add_shortcode( 'social_media', 'social_media_func' );
function social_media_func( $atts ) {
  $social_media = get_social_media();
  $output = '';
  ob_start();
  if ($social_media) { ?>
  <div class="social-media">
    <div class="inner">
    <?php foreach ($social_media as $m) { ?>
      <a href="<?php echo $m['url'] ?>" target="_blank" aria-label="<?php echo $m['type'] ?>"><i class="<?php echo $m['icon'] ?>"></i></a>
    <?php } ?>
    </div>
  </div> 
  <?php }
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


/* MENU ITEMS WITH CUSTOM FIELD */
// add_filter('wp_nav_menu_objects', 'my_wp_nav_menu_objects', 10, 2);
// function my_wp_nav_menu_objects( $items, $args ) {
//   foreach( $items as &$item ) {
//     $bgcolor = get_field('menu_bgcolor', $item);
//     $menu_name = $item->title;
//     if( $bgcolor ) {
//       $item->title = '<span style="background-color:'.$bgcolor.'">'.$menu_name.'</span>';
//     } else {
//       $item->title = '<span>'.$menu_name.'</span>';
//     }
//   }
//   return $items;
// }


if( function_exists('acf_add_options_page') ) {    
  acf_add_options_sub_page(array(
    'page_title'     => 'Events Page Options',
    'menu_title'    => 'Events Page Options',
    'parent_slug'    => 'edit.php?post_type=tribe_events',
  ));
}


function tribe_get_event_website_link_label_default( $label ) {
  $url = tribe_get_event_website_url();
  if ( $label === $url ) {
    $label = 'View Event Website &raquo;';
  }
  return $label;
}
add_filter( 'tribe_get_event_website_link_label', 'tribe_get_event_website_link_label_default' );


function list_children_events($post_id) {
  global $wpdb;
  $query = "SELECT p.post_parent FROM " . $wpdb->prefix . "posts p WHERE p.ID=".$post_id . " AND p.post_type='tribe_events' AND p.post_status='publish'";
  $item = $wpdb->get_row($query);
  $parent_id = ($item) ? $item->post_parent : '';
  $children = array();
  if( !$parent_id ) {
    $query2 = "SELECT p.ID FROM " . $wpdb->prefix . "posts p WHERE p.post_parent=".$post_id. " AND p.post_type='tribe_events' AND p.post_status='publish'";
    $results = $wpdb->get_results($query2);
    if($results) {
      foreach($results as $row) {
        $children[] = $row->ID;
      }
    }
  } 
  return $children;
}


function array_to_group_range($src) {
  $res = [];
  $start = null;

  //Rather than make a counter use a for loop
  for($i=0; $i < count($src); $i++){
      //Make sure i+1 is not bigger than array
      //If current index value + 1
      //Equals the next index value we have a range
      if($i+1 < count($src) && $src[$i]+1 == $src[$i+1]){
          if($start === null){
              $start = $i;
          }
          //Once the range is over we can use the current index as end
      } elseif($start !== null){
          $res[] = array($src[$start], $src[$i]);
          $start = null;
          $end = null;
          //There was never a range.
      } else {
          $res[] = $src[$i];
      }
  }

  return $res;
}


function getMonthList($n=null) {
  $monthList = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  if($n!==null) {
    return (isset($monthList[$n]) && $monthList[$n]) ? $monthList[$n] : '';
  } else {
    return $monthList;
  }
}

function getMonthNumber($month) {
  $num = '';
  foreach( getMonthList() as $k=>$m ) {
    $i = $k+1;
    if($month==$m) {
      $num = $i;
      break;
    }
  }
  return $num;
}



function getCurrentCalendar($year=null) {
  $current_calendar = [];
  //$monthList = getMonthList();
  $year_input = ($year) ? $year : date('Y');
  for($i=1; $i<=12; $i++) {
    $d=cal_days_in_month(CAL_GREGORIAN,$i, $year_input);
    $x = $i-1;
    $m = getMonthList($i-1);
    $current_calendar[$m] = $d;
  }
  return $current_calendar;
}


function getEventDateRange($event_id) {
  $start = tribe_get_start_date($event_id,false,'M d');
  $end = tribe_get_end_date($event_id,false,'M d');
  $start_time = tribe_get_start_date($event_id,null,'g:ia');
  $end_time = tribe_get_end_date($event_id,null,'g:ia');

  $start_time_i = tribe_get_start_time($event_id,false,'g:ia');
  $end_time_i = tribe_get_end_time($event_id,false,'g:ia');

  $event_dates = $start;
  if($start!=$end) {
    $event_dates = ( array_filter(array($start,$end)) ) ? implode(' &ndash; ',array_filter(array($start,$end))) : '';
  }
  if($start_time_i || $end_time_i) {
    $st = str_replace(':00','',$start_time);
    $et = str_replace(':00','',$end_time);
    $times = ( array_filter(array($st,$et)) ) ? implode(' &ndash; ',array_filter(array($st,$et))) : '';
    if($start_time==$end_time) {
      $times = $start_time;
    }

    if($start==$end) {
      if($event_dates) {
        $event_dates .= ' <span class="sep">|</span> ' . $times;
      } 
    }
  }


  $children = list_children_events($event_id);
  $the_dates = array();
  if($children) {
    foreach($children as $id) {
      $month = tribe_get_start_date($id,false,'M');
      $day = tribe_get_start_date($id,false,'d');
      $the_dates[$month][$day] = $day;
    }
  }

  $recurring_dates = [];
  if($the_dates) {
    foreach($the_dates as $month=>$dates) {
      sort($dates);
      $the_dates[$month] = $dates;
      $max = count($dates);
      $first = $dates[0];
      $last = end($dates);
      $n = $max - 1;
      $compare = $first + ($max - 1);
      $ranges = array_to_group_range($dates);
      $recurring_dates[$month] = $ranges;
    }
  }

  $final_dates = '';
  if($recurring_dates) {
    $c=1;
    foreach( $recurring_dates as $month => $days ) {
      $separator = ($c>1) ? ', ':'';
      $range_days = '';
      $month_info = '';
      foreach($days as $x=>$numdays) {
        $comma = ($x>0) ? ', ':'';
        if($numdays && is_array($numdays)) {
          $days_info = '';
          foreach($numdays as $k=>$v) {
            $sep = ($k>0) ? ' - ':'';
            $days_info .= $sep . $v;
          }
          $range_days .= $comma . $month . ' ' . $days_info;
        } else {
          $range_days .= $comma . $month . ' ' . $numdays;
        }
      }
      $final_dates .= $separator . $range_days;
      $c++;
    }
  }

  if($final_dates) {
    $event_dates =  $final_dates;
  }

  return $event_dates;
}






