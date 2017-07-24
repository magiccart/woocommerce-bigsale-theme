<?php
/*
 * Khai bao hang gia tri :
 *      ALOTHEMES_URL   : Lay duong dan url thu muc theme
 *      ALOTHEMES_DIR   : Lay duong dan thu muc theme
 *      ALOTHEMES_CORE  : Lay duong dan thu muc /core
 *   */
define('ALOTHEMES_DIR', get_stylesheet_directory());
define('ALOTHEMES_URL', get_stylesheet_directory_uri());
define('ALOTHEMES_CORE'     , ALOTHEMES_DIR . '/core/');

define('ALOTHEMES_IMAGES', ALOTHEMES_URL . '/images/');
require_once (ALOTHEMES_DIR . '/post-like.php');

/* 
 * Nhung file /core/init.php
 * */
if(!class_exists('Magiccart')){
  echo __('This theme require plugin Magiccart, please install and activate it.');
  die;
}

require_once (ALOTHEMES_CORE . 'init.php');
$objmcInit = new mcInit();
$redux    = WP_PLUGIN_DIR . "/redux-framework/redux-framework.php";
if( file_exists($redux) ){
  if(is_plugin_active("redux-framework/redux-framework.php")){
        if(is_admin()){
            new Magiccart\Core\Block\Options;
        }
  }
}



echo basename(get_template_directory());

/* Get options Redux */
  function magiccart_options($key = ''){
    global $objmcInit;
    return $objmcInit->get_options($key);
  }

/* Function phan trang */
if(!function_exists('magiccart_pagination')){
     function magiccart_pagination(){
        if($GLOBALS['wp_query']->max_num_pages < 2){
            return "";
        } ?>
        <nav class="pagination" role="navigation">
            <?php if (get_next_posts_link()) : ?>
                <div class="prev"><?php next_posts_link( __('Older Posts', 'alothemes') ); ?></div>
            <?php endif; ?>
            <?php if(get_previous_posts_link() ) : ?>
                <div class="next"><?php previous_posts_link( __('Newest Posts', 'alothemes')); ?></div>
            <?php endif;?>
        </nav>
<?php }
}

/* show tag */
if(!function_exists('magiccart_entry_tag')){
    function magiccart_entry_tag(){
        if(has_tag()) :
            echo '<div class="rentry-tag">';
            printf(__('Tagged in %1$s', 'alothemes'), get_the_tag_list('', ','));
            echo '</div>';
        endif;
    }
}

/* Categories */
function magiccart_get_all_category(){
  $args = array(
      'type'          => 'post',
      'child_of'      => 0,
      'parent'        => '',
      'orderby'       => 'id',
      'order'         => 'ASC',
      'hide_empty'    => false,
      'hierarchical'  => 1,
      'exclude'       => '',
      'include'       => '',
      'number'        => '',
      'taxonomy'      => 'product_cat',
      'pad_counts'    => false,

  );
  $categories = get_categories( $args );
  return $categories;
}

/* Get view */
  function getPostViews($postID){ 
    $count_key  = 'post_views_count';
    $count      = get_post_meta($postID, $count_key, true);
    if($count==''){ 
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
      return "0"; 
    }
    return $count; 
  }

  /* Set + Update view */
  function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
      $count = 0;
      delete_post_meta($postID, $count_key);
      add_post_meta($postID, $count_key, '0');
    }else{
      $count++; 
      update_post_meta($postID, $count_key, $count); // update count
    }
  }

  function breadcrumbs(){ ?>
      <ul class="breadcrumbs" >
          <li class="trail-item trail-begin"><a href="<?php echo home_url(); ?>"><?php esc_html_e('Home','alothemes') ?></a></li> 
          <?php if( is_tag() ) { ?>
              <?php esc_html_e('Posts Tagged &quot;','alothemes') ?><?php single_tag_title(); echo(''); ?>
          <?php } elseif (is_day()) { ?>
              <?php esc_html_e('Posts made in','alothemes') ?> <?php the_time('F jS, Y'); ?>
          <?php } elseif (is_month()) { ?>
              <?php esc_html_e('Posts made in','alothemes') ?> <?php the_time('F, Y'); ?>
          <?php } elseif (is_year()) { ?>
              <?php esc_html_e('Posts made in','alothemes') ?> <?php the_time('Y'); ?>
          <?php } elseif (is_search()) { ?>
              <?php esc_html_e('Search results for','alothemes') ?> <?php the_search_query() ?>
          <?php } elseif (is_single()) { ?>
              <?php 
                  $category = get_the_category();
                  if(empty($category)){
                      //echo get_the_term_list( get_the_ID(), "product_category");
                      echo ' <li class="trail-item trail-end"> '.get_the_title() . '</li>'; 
                  }else{
                      $catlink = get_category_link( $category[0]->cat_ID );
                      echo ('<li class="trail-item"><a href="'.esc_url($catlink).'">'.esc_html($category[0]->cat_name).'</a></li>  <li class="trail-item trail-end">'.get_the_title() . "</li>"); 
                  }?>
          <?php } elseif (is_category()) { ?>
              <?php echo "<li class='trail-item trail-end'>" . single_cat_title('', false) . "</li>"; ?>
                  <?php } elseif(is_tax() ){
              $queried_object = get_queried_object();
              $term_id = $queried_object->term_id;
              $term_obj = get_term( $term_id, "product_category");
              if(!isset($term_obj)){
                  $term_obj = get_term( $term_id, "new_product");
                  if(!isset($term_obj)){
                      $term_obj = get_term( $term_id, "hot_deal");
                  }
              }
              echo "<li class='trail-item'>" . $term_obj->name . "</li>";?>
          <?php } elseif (is_author()) { ?>
              <?php esc_html_e('Posts by ','alothemes'); echo ' ',$curauth->nickname; ?>
          <?php } elseif (is_page()) { ?>
              <?php echo "<li class='trail-item'>" .  wp_title('', false) . "</li>" ?>
          <?php } ?>
      </ul> <!-- end .breadcrumbs -->
      <?php 
  }

  function wpbeginner_numeric_posts_nav($class="pagination", $next = "", $prev ="") {
    if( is_singular() ) return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if( $wp_query->max_num_pages <= 1 )
      return;

      $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
      $max   = intval( $wp_query->max_num_pages );

      /** Add current page to the array */
      if ( $paged >= 1 )
        $links[] = $paged;

        /** Add the pages around the current page to the array */
        if ( $paged >= 3 ) {
          $links[] = $paged - 1;
          $links[] = $paged - 2;
        }

        if ( ( $paged + 2 ) <= $max ) {
          $links[] = $paged + 2;
          $links[] = $paged + 1;
        }

        echo '<nav class="pagination ' . $class . '"><ul class="page-numbers">' . "\n";

        /** Previous Post Link */
        if ( get_previous_posts_link() )
			echo '<li><a class="prev page-numbers" href="' . esc_url( previous_posts(false)) .'" >' . $prev . '</a></li>';

          /** Link to first page, plus ellipses if necessary */
          if ( ! in_array( 1, $links ) ) {
            $class = 1 == $paged ? 'current' : '';
			if($class){
				echo '<li><span class="page-numbers current">1</span></li>';
			} else {
				printf( '<li><a class="page-numbers" href="%s">%s</a></li>' . "\n", esc_url( get_pagenum_link( 1 ) ), '1' );
			}
            if ( ! in_array( 2, $links ) )
              echo '<li></li>';
          }

          /** Link to current page, plus 2 pages in either direction if necessary */
          sort( $links );
          foreach ( (array) $links as $link ) {
			$class = $paged == $link ? 'current' : '';
			if($class){
				echo '<li><span class="page-numbers current">' . $link  . '</span></li>';
			} else {
				printf( '<li><a class="page-numbers" href="%s">%s</a></li>' . "\n", esc_url( get_pagenum_link( $link ) ), $link );
			}
          }

          /** Link to last page, plus ellipses if necessary */
          if ( ! in_array( $max, $links ) ) {
            if ( ! in_array( $max - 1, $links ) )
				echo '<li><span class="page-numbers dots">…</span></li>' . "\n";
				$class = $paged == $max ? 'current' : '';
				if($class){
					echo '<li><span class="page-numbers current">' . $max  . '</span></li>';
				} else {
					printf( '<li><a class="page-numbers" href="%s">%s</a></li>' . "\n", esc_url( get_pagenum_link( $max ) ), $max );
				}
          }

          /** Next Post Link */
          if ( get_next_posts_link() )
            echo '<li><a class="next page-numbers" href="' . esc_url( next_posts(0, false)) .'" >' . $next . '</a></li>';

            echo '</ul></nav>' . "\n";
  }

  function magiccart_register($before = '<li>', $after = '</li>', $echo = true , $title = "Register") {
    if ( ! is_user_logged_in() ) {
      if ( get_option('users_can_register') )
        $link = $before . '<a href="' . esc_url( wp_registration_url() ) . '">' . $title . '</a>' . $after;
      else
        $link = '';
    } elseif ( current_user_can( 'read' ) ) {
      $link = $before . '<a href="' . admin_url() . '">' . __('Site Admin', 'alothemes') . '</a>' . $after;
    } else {
      $link = '';
    }
    $link = apply_filters( 'register', $link );

    if ( $echo ) {
      echo $link;
    } else {
      return $link;
    }
  }

  function is_blog () {
    global  $post;
    $posttype = get_post_type($post );
    return ( ((is_archive()) || (is_author()) || (is_category()) || (is_home()) || (is_single()) || (is_tag())) && ( $posttype == 'post')  ) ? true : false ;
  }

  function getPrcents(){
      return array(1 => '100%', 2 => '50%', 3 => '33.333333333%', 4 => '25%', 5 => '20%', 6 => '16.666666666%', 7 => '14.285714285%', 8 => '12.5%');
  }

  function getResponsiveBreakpoints(){
      return array(1201=>'visible', 1200=>'desktop', 992=>'notebook', 769=>'tablet', 641=>'landscape', 481=>'portrait', 361=>'mobile', 1=>'mobile');
  }

  function getGridStyle($selector=' .woocommerce ul.products.grid li.product'){
      $options = magiccart_options();
      $responsive   = array();
      if(is_shop()){
        $responsive = isset($options['product_shop']) ? $options['product_shop'] : array();
      } else if(is_blog() || is_category()){
        $selector   =  ' ul.grid-view li.content-default';
        $responsive = isset($options['blog']) ? $options['blog'] : array();
      }else if($pos = strpos(get_page_template_slug(), 'portfolio')){
        if(is_page_template(get_page_template_slug())){
          $selector   =  ' ul.grid-view li.content-default';
          $responsive = isset($options['portfolio']) ? $options['portfolio'] : array();
        }
      }else {
        $responsive = isset($options['product_category']) ? $options['product_category'] : array();
      }

      if(isset($_GET['visible'])) $responsive['visible'] = $_GET['visible'];  // USED DEMO

      $styles       = $selector .'{ float: left;}';
      $listCfg      = $responsive;
      $padding      = $listCfg['padding'];
      $prcents      = getPrcents();
      $breakpoints  = getResponsiveBreakpoints(); ksort($breakpoints);
      $total = count($breakpoints);
      $i = $tmp = 1;
      foreach ($breakpoints as $key => $value) {
          $tmpKey = ( $i == 1 || $i == $total) ? $value : current($breakpoints);
          if($i >1){
              $styles .= ' @media (min-width: '. $tmp .'px) and (max-width: ' . ($key-1) . 'px) {' .$selector. '{padding: 0 '.$padding.'px; width: '.$prcents[$listCfg[$value]] .'} ' .$selector. ':nth-child(' .$listCfg[$value]. 'n+1){clear: left;}}';
              next($breakpoints);
          }
          if( $i == $total ) $styles .= ' @media (min-width: ' . $key . 'px) {' .$selector. '{padding: 0 '.$padding.'px; width: '.$prcents[$listCfg[$value]] .'} ' .$selector. ':nth-child(' .$listCfg[$value]. 'n+1){clear: left;}}';
          $tmp = $key;
          $i++;
      }
      return  '<style type="text/css">' .$styles. '</style>';
  }

  function settings_slide($optionSettings){
      $arrResponsive = array(1201=>'visible', 1200=>'desktop', 992=>'notebook', 768=>'tablet', 641=>'landscape', 481=>'portrait', 361=>'mobile');
    $settings = array();   
    $total   = count($arrResponsive);
    $options = array(
        'autoplay',
        'arrows',
        'dots',
        'infinite',
        'padding',
        'rows',
        'autoplay-speed',
        'vertical',
    );

    foreach ($options as $value){
      if(isset($optionSettings[$value])){
        $settings[$value] = $optionSettings[$value];
      }
    }
    $settings['vertical-swiping'] = $optionSettings['vertical'];
    $settings['slides-to-show']   = isset($_GET['visible']) ? $_GET['visible'] : $optionSettings['visible']; // USED DEMO
    $settings['padding']          = $optionSettings['padding'];  
    $settings['swipe-to-slide']   = 'true';

    $responsive = '[';
    foreach ($arrResponsive as $size => $screen) {
      $responsive .= '{"breakpoint": "'.$size.'", "settings":{"slidesToShow":"'. $optionSettings[$screen].'"}}';
      if($total-- > 1) $responsive .= ', ';
    }
    $responsive .= ']';
    $settings['responsive']         = $responsive;

    return $settings;
  }

  function upload_featured_image( $image_url, $post_id  ){
      $upload_dir = wp_upload_dir();
      $image_data = file_get_contents($image_url);
      $filename = basename($image_url);
      if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
      else                                    $file = $upload_dir['basedir'] . '/' . $filename;
      file_put_contents($file, $image_data);

      $wp_filetype = wp_check_filetype($filename, null );
      $attachment  = array(
          'post_mime_type' => $wp_filetype['type'],
          'post_title'     => sanitize_file_name($filename),
          'post_content'   => '',
          'post_status'    => 'inherit'
      );
      $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
      require_once(ABSPATH . 'wp-admin/includes/image.php');
      $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
      $res1 = wp_update_attachment_metadata( $attach_id, $attach_data );
      $res2 = set_post_thumbnail( $post_id, $attach_id );
  }

function alothemes_wishlist_link($id){

  if ( in_array( 'yith-woocommerce-wishlist/init.php', apply_filters('active_plugins', get_option( 'active_plugins' )))){
      echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="'. $id .'"]');
  }
}

function list_hooks( $hook = '' ) {
    global $wp_filter;

    if ( isset( $wp_filter[$hook]->callbacks ) ) {      
        array_walk( $wp_filter[$hook]->callbacks, function( $callbacks, $priority ) use ( &$hooks ) {           
            foreach ( $callbacks as $id => $callback )
                $hooks[] = array_merge( [ 'id' => $id, 'priority' => $priority ], $callback );
        });         
    } else {
        return [];
    }

    foreach( $hooks as &$item ) {
        // skip if callback does not exist
        if ( !is_callable( $item['function'] ) ) continue;

        // function name as string or static class method eg. 'Foo::Bar'
        if ( is_string( $item['function'] ) ) {
            $ref = strpos( $item['function'], '::' ) ? new ReflectionClass( strstr( $item['function'], '::', true ) ) : new ReflectionFunction( $item['function'] );
            $item['file'] = $ref->getFileName();
            $item['line'] = get_class( $ref ) == 'ReflectionFunction' 
                ? $ref->getStartLine() 
                : $ref->getMethod( substr( $item['function'], strpos( $item['function'], '::' ) + 2 ) )->getStartLine();

        // array( object, method ), array( string object, method ), array( string object, string 'parent::method' )
        } elseif ( is_array( $item['function'] ) ) {

            $ref = new ReflectionClass( $item['function'][0] );

            // $item['function'][0] is a reference to existing object
            $item['function'] = array(
                is_object( $item['function'][0] ) ? get_class( $item['function'][0] ) : $item['function'][0],
                $item['function'][1]
            );
            $item['file'] = $ref->getFileName();
            $item['line'] = strpos( $item['function'][1], '::' )
                ? $ref->getParentClass()->getMethod( substr( $item['function'][1], strpos( $item['function'][1], '::' ) + 2 ) )->getStartLine()
                : $ref->getMethod( $item['function'][1] )->getStartLine();

        // closures
        } elseif ( is_callable( $item['function'] ) ) {     
            $ref = new ReflectionFunction( $item['function'] );         
            $item['function'] = get_class( $item['function'] );
            $item['file'] = $ref->getFileName();
            $item['line'] = $ref->getStartLine();

        }       
    }

    return $hooks;
}


function getPostLikeLink( $post_id ) {
    $like_count = get_post_meta( $post_id, "_post_like_count", true ); // get post likes
    $count = ( empty( $like_count ) || $like_count == "0" ) ? 'Like' : esc_attr( $like_count );
    if ( AlreadyLiked( $post_id ) ) {
      $class = esc_attr( ' liked' );
      $title = esc_attr( 'Unlike' );
      $heart = '<i class="fa fa-heart"></i>';
    } else {
      $class = esc_attr( '' );
      $title = esc_attr( 'Like' );
      $heart = '<i class="fa fa-heart-o"></i>';
    }
    $output = '<a href="#" class="jm-post-like'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.'&nbsp;'.$count.'</a>';
    return $output;
  }


remove_filter ( 'the_content' , 'wpautop' ) ; // disable wpautop(p and br) 