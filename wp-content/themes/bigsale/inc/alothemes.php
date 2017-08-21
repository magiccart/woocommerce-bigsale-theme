<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2017-08-15 22:24:24
 * @@Function:
 */

global $alothemes;
global $themecfg;

class Alothemes{

    /**
     * Core singleton class
     * @var self - pattern realization
     */
    private static $_instance;

	public $_optionsName;
	public $_options;

	public function __construct(){

		$this->_optionsName = get_option('theme_options', '');
		$this->_options = $this->get_options();
		add_action( 'init', array($this, 'theme_setup') );
		add_action( 'init', array($this, 'magiccart_web_init') );

		add_action( 'widgets_init', array($this, 'widgets_init') );
	    add_action( 'wp_enqueue_scripts', array($this, 'dequeue_css'), 11 );
		add_action( 'wp_enqueue_scripts', array($this, 'magiccart_web'), 15 );

    	add_filter( 'excerpt_more', array($this, 'magiccart_readmore'));
    	add_filter( 'excerpt_length', array($this, 'magiccart_custom_excerpt_length'), 999 );

    	add_filter( 'woocommerce_breadcrumb_defaults', array($this, 'change_breadcrumb_woo') );
	    add_filter( 'woocommerce_output_related_products_args', array($this, 'related_products_args') );

		add_filter( 'add_to_cart_fragments', array($this, 'woocommerce_header_add_to_cart_fragment') );
		add_action( 'pre_get_posts', array($this, 'woo_alter_category_search') );

		/*Options Theme Shop*/
		if(!is_front_page()){
		  add_filter( 'loop_shop_per_page', array($this, 'setPerPage'), 20 );
		}
		
	}
		
    /**
     * Get the instane of Magiccart
     *
     * @return self
     */
    public static function getInstance() {
        if ( ! ( self::$_instance instanceof self ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function getSkinUrl($fileName){
        $templateName = get_stylesheet_directory() . '/' . $fileName;
        if(file_exists($templateName)) return get_stylesheet_directory_uri() . '/' . $fileName;
        return get_template_directory_uri() . '/' . $fileName;
    }

    public function getThemeFile($fileName, $message=true){
        $templateName = get_stylesheet_directory() . '/' . $fileName;
        if(!file_exists($templateName)){
            $templateName = get_template_directory() . '/' . $fileName;
            if(!file_exists($templateName)){
                // $error = new \WP_Error( 'broke', __( "File Template $this->_template not exist", "alothemes" ) );
                // return $error->get_error_message();
                if($message) return '<div class="message error woocommerce-error">' . __( "File Template $fileName not exist", "alothemes" ) . '</div>';
                return;
            }
        }
        return $templateName;
    }

	public function dequeue_css() {
	    wp_dequeue_style('newsletter-subscription');
	    wp_dequeue_style('woocommerce-general');
	    wp_dequeue_style('woocommerce-layout');
	}

	public function dequeue_js() {
	  //wp_dequeue_script('flexslider');
	}

	public function setPerPage(){
		if(is_shop()){
			return $this->_options['product_shop_per_page'];
		}
		return $this->_options['product_category_per_page'];
	}
	public function theme_setup(){
		if ( ! isset( $content_width ) ) $content_width = 1200;
		if ( is_singular() ) wp_enqueue_script( "comment-reply" );
		wp_link_pages();
		comments_template();

        /* Thiet lap textdomain */
		$languages_folder = get_stylesheet_directory() . '/languages';
		load_theme_textdomain('alothemes', $languages_folder);

		/* Auto add link RSS to <head> */
		add_theme_support('automatic-feed-links');

		/* add post thumbnail */
		add_theme_support('post-thumbnails');

		/* add title-tag */
		add_theme_support('title-tag');

		add_theme_support('post-formats', array( 'image', 'video', 'gallery', 'quote', 'portfolio' ));

		add_theme_support( 'custom-background', array('default-color' => '#fff') );

		// support woocommerce
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		/* add menu */
		// register_nav_menu('top-menu', __('Top Menu', 'alothemes'));
		// register_nav_menu('vertical-menu', __('Vertical Menu', 'alothemes'));
		// register_nav_menu('mobile-menu', __('Mobile Menu', 'alothemes'));
       	register_nav_menus();
		// register_nav_menus( array(
		// 	'primary' => __( 'Primary Menu',      'alothemes' ),
		// 	'social'  => __( 'Social Links Menu', 'alothemes' ),
		// ) );       
    }

    public function widgets_init(){
    	/* create sidebar */
       $sidebarLeftShop = array(
           'name'           => __('Left Sidebar Shop', 'alothemes'),
           'id'             => 'left-sidebar-shop',
           'class'          => 'left-sidebar-shop',
           'before_title'   => '<h3 class="left-widget-title">',
           'after_title'    => '</h3>'
       );
       register_sidebar($sidebarLeftShop);

       $sidebarRightShop = array(
           'name'           => __('Right Sidebar Shop', 'alothemes'),
           'id'             => 'right-sidebar-shop',
           'class'          => 'right-sidebar-shop',
           'before_title'   => '<h3 class="right-widget-title">',
           'after_title'    => '</h3>'
       );
       register_sidebar($sidebarRightShop);

       // Detail
       $sidebarLeftDetail = array(
           'name'           => __('Left Sidebar Details', 'alothemes'),
           'id'             => 'left-sidebar-detail',
           'class'          => 'left-sidebar-detail',
           'before_title'   => '<h3 class="left-widget-title">',
           'after_title'    => '</h3>'
       );
       register_sidebar($sidebarLeftDetail);

       $sidebarRightDetail = array(
           'name'           => __('Right Sidebar Details', 'alothemes'),
           'id'             => 'right-sidebar-detail',
           'class'          => 'right-sidebar-detail',
           'before_title'   => '<h3 class="right-widget-title">',
           'after_title'    => '</h3>'
       );
       register_sidebar($sidebarRightDetail);

		// Register Post sidebar
		$sidebarLeft = array(
			'name'           => __('Left Sidebar Post', 'alothemes'),
			'id'             => 'left-sidebar',
			'description'    => __('left sidebar', 'alothemes'),
			'class'          => 'left-sidebar',
			'before_title'   => '<h3 class="left-widget-title">',
			'after_title'    => '</h3>'
		);
       register_sidebar($sidebarLeft);

       	$sidebarRight = array(
			'name'           => __('Right Sidebar Post', 'alothemes'),
			'id'             => 'right-sidebar',
			'description'    => __('right sidebar', 'alothemes'),
			'class'          => 'right-sidebar',
			'before_title'   => '<h3 class="right-widget-title">',
			'after_title'    => '</h3>'
       	);
       	register_sidebar($sidebarRight);

		// Register footer sidebar
		$nfooter = $this->get_options('footer_widget_columns');
		if(!$nfooter) $nfooter = 5;
		register_sidebars( $nfooter, array(
			'name'          => __( 'Footer', 'alothemes' ) . ' %d',
			'id'            => 'footer-sidebar',
			'description'    => __('Footer sidebar', 'alothemes'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

    }


  	public function related_products_args( $args ) {
		$args['posts_per_page'] = $this->_options['product_related_number']; // related products
		//$args['columns'] = 2; // arranged in 2 columns
		return $args;
	}

	public function magiccart_web(){
    	wp_register_style('reset-style', $this->getSkinUrl('reset.css'));
	    wp_enqueue_style('reset-style');
	    
	    wp_register_style('bootstrap-min', $this->getSkinUrl('bootstrap/css/bootstrap.min.css'));
	    wp_enqueue_style('bootstrap-min');

	    wp_register_style('woocommerce-general-theme', $this->getSkinUrl('css/woocommerce.css'));
	    wp_enqueue_style('woocommerce-general-theme');

	    wp_register_style('woocommerce-layout-theme', $this->getSkinUrl('css/woocommerce-layout.css'));
	    wp_enqueue_style('woocommerce-layout-theme');

	    wp_register_style('main-style', $this->getSkinUrl('style.css'));
	    wp_enqueue_style('main-style');

	    if( is_string($this->get_options("style")) ){
	    	$skin = 'css/style/' . $this->get_options("style");
	    	wp_register_style('main-skin', $this->getSkinUrl( $skin ));
	    	wp_enqueue_style('main-skin');
	    }
	    
	    wp_register_style('responsive', $this->getSkinUrl('responsive.css'), '', '1.0');
	    wp_enqueue_style('responsive');

	    wp_register_script('magiccart', $this->getSkinUrl('js/magiccart.js'), array('jquery'), '1.0', true);
	  	wp_enqueue_script('magiccart', true);

	  	wp_register_script('simple-likes-public', $this->getSkinUrl('js/simple-likes-public.js'));
	  	wp_enqueue_script('simple-likes-public', true);

	  	wp_register_script('jquery.easing.1.3.min', $this->getSkinUrl('js/jquery.easing.1.3.min.js'));
	  	wp_enqueue_script('jquery.easing.1.3.min', true);
	}

	public function magiccart_web_init(){
	  	wp_register_style('font-awesome', $this->getSkinUrl('font-awesome/css/font-awesome.css'));
	  	wp_enqueue_style('font-awesome');
	    wp_register_style('simple-likes-public', $this->getSkinUrl('css/simple-likes-public.css'));
	    wp_enqueue_style('simple-likes-public');

	}

	
	public function change_breadcrumb_woo( $defaults ) {
		$defaults = array(
            'delimiter'   => '',
            'wrap_before' => '<ul class="breadcrumbs woocommerce-breadcrumb" >',
            'wrap_after'  => '</ul>',
            'before'      => '<li class="trail-item">',
            'after'       => '</li>',
            'home'        => __( 'Home', 'alothemes'),
        );
		return $defaults;
	}

	public function magiccart_readmore(){
		$readMore = $this->_options['readmore_text'];
		return '<a class="read-more" href="'. get_permalink(get_the_ID()) .'"> '. $readMore . '</a>';
	}

	/*Excerpt length on blog page*/
	public function magiccart_custom_excerpt_length( $length ) {
		if($this->_options['blog_view'] == "grid-view" ){
		  	return $this->_options['excerpt_length_grid'];
		}
	    return $this->_options['excerpt_length_list'];
	}

	/* Get options Redux */
	public function get_options($key = '', $debug=false){
		
		$options = $this->_optionsName;
	    if(!is_admin()){
	      if(isset($_SESSION["magiccart_option"])) {
	        $options = $_SESSION["magiccart_option"];
	      }

	      // if(is_page()){
	      //   global $post;
	      //   $tmp = get_post_meta($post->ID, 'meta_boxes_theme_option', true );
	      //   if($tmp){
	      //     $options = $tmp;
	      //     add_filter( 'pre_option_page_on_front', 'option_page_on_front' );
	      //     // add_filter( 'pre_option_theme_options', 'option_theme_options' );
	      //   }  

	      // }
	    }

	    if($options){
	    	if(trim($key) != '' ){
		        if(isset($GLOBALS[$options][$key])){
		            return $GLOBALS[$options][$key];
		        }else{
		            $options = get_option($options, array());
		            if(isset($options[$key])){
		                return $options[$key];
		            }else{
		            	// WP_DEBUG
		            	if(!$debug) $debug = defined('WP_DEBUG');
		                if($debug) echo "$key not isset";
		                else return  $options;
		            }
		        }
		    }

		    if(isset($GLOBALS[$options])){
		        return $GLOBALS[$options];
		    }else{
		        return get_option($options, array());
		    }
	    }else{
	    	return __('Please save theme options!', 'alothemes');
	    }
	}

	/* Search */
	public function woo_alter_category_search($query) {
	    if (is_admin() || !is_search())
	        return false;

	    if ($product_cat = $query->get('product_cat')) {
	        $query->set('product_cat', '');
	        $query->set('tax_query', array(
	            array(
	                'taxonomy' 	=> 'product_cat',
	                'field' 	=> 'slug',
	                'terms' 	=> $product_cat,
	                'include_children' => false,
	            )
	        ));
	    }
	}

	public function woocommerce_header_add_to_cart_fragment( $fragments ) {
	  	global $woocommerce;
	  	ob_start();
	    echo '<span class="cart-quantity">' . WC()->cart->get_cart_contents_count() . ' ' . __('item(s)', 'alothemes') . '</span>';
	  	$fragments['span.cart-quantity'] = ob_get_clean();

	  	return $fragments;
	}
}

if ( !$alothemes ) $alothemes = Alothemes::getInstance();
if ( !$themecfg ) $themecfg  = $alothemes->get_options();


class Alowoowcommrece{

	/* Categories */
	public static function get_categories(){
	    $args = array(
	        'type'          => 'post',
	        'child_of'      => 0,
	        'parent'        => '',
	        'orderby'       => 'id',
	        'order'         => 'ASC',
	        'hide_empty'    => false,
	        'hierarchical'  => 1,
	        'exclude'       => '',
	        //'include'       => '',
	        'number'        => '',
	        'taxonomy'      => 'product_cat',
	        'pad_counts'    => false,

	    );

	    $categories = get_categories( $args );

	    return $categories;
	}
}
