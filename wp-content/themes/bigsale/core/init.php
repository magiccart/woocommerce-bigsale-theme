<?php  
class mcInit{
	public $_options = array();
	public function __construct(){
		$this->_options = $this->get_options();
		add_action('init', array($this, 'theme_setup'));
		add_action('widgets_init', array($this, 'create_sidebar'));
		add_action('pre_get_posts', array($this, 'woo_alter_category_search'));
		add_filter('add_to_cart_fragments', array($this, 'woocommerce_header_add_to_cart_fragment'));
		add_action('wp_enqueue_scripts', array($this, 'magiccart_web_font'), 15);
    	add_action('init', array($this, 'magiccart_web_init'));
    	add_filter('excerpt_more', array($this, 'magiccart_readmore'));
    	add_filter( 'excerpt_length', array($this, 'magiccart_custom_excerpt_length'), 999 );
    	add_filter( 'woocommerce_breadcrumb_defaults', array($this, 'change_breadcrumb_woo') );
	    add_filter( 'woocommerce_output_related_products_args', array($this, 'related_products_args') );
	    add_action('wp_enqueue_scripts', array($this, 'dequeue_css'), 11);
	    
		/*Options Theme Shop*/
		if(!is_front_page()){
		  add_filter( 'loop_shop_per_page', array($this, 'setPerPage'), 20 );
		}
		
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		
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
       $languages_folder = ALOTHEMES_DIR . '/languages';
       load_theme_textdomain('alothemes', $languages_folder);
       
       /* Tu dong them link RSS len <head> */
       add_theme_support('automatic-feed-links');
       
       /* add post thumbnail */
       add_theme_support('post-thumbnails');
       
       /* add title-tag */
       add_theme_support('title-tag');
       
       add_theme_support('post-formats', array(
            'image',
            'video',
            'gallery',
            'quote',
            'portfolio'
       ));

       /* add custom background */
       $default_background = array(
           'default-color' => '#fff'
       );
       add_theme_support('custom-background', $default_background);
       
       /* add menu */
       register_nav_menu('top-menu', __('Top Menu', 'alothemes'));
       register_nav_menu('vertical-menu', __('Vertical Menu', 'alothemes'));
       register_nav_menu('mobile-menu', __('Mobile Menu', 'alothemes'));
       
       
    }

    public function create_sidebar(){
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

       // Post
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
    }


  	public function related_products_args( $args ) {
		$args['posts_per_page'] = $this->_options['product_related_number']; // related products
		//$args['columns'] = 2; // arranged in 2 columns
		return $args;
	}

	public function magiccart_web_font(){
    	wp_register_style('reset-style', ALOTHEMES_URL . '/reset.css');
	    wp_enqueue_style('reset-style');
	    
	    wp_register_style('bootstrap-min', ALOTHEMES_URL . '/bootstrap/css/bootstrap.min.css');
	    wp_enqueue_style('bootstrap-min');

	    wp_register_style('woocommerce-theme', ALOTHEMES_URL . '/css/woocommerce.css');
	    wp_enqueue_style('woocommerce-theme');

	    wp_register_style('woocommerce-layout-theme', ALOTHEMES_URL . '/css/woocommerce-layout.css');
	    wp_enqueue_style('woocommerce-layout-theme');

	    wp_register_style('main-style', ALOTHEMES_URL . '/style.css');
	    wp_enqueue_style('main-style');

	    wp_register_style('simple-likes-public', ALOTHEMES_URL . '/css/simple-likes-public.css');
	    wp_enqueue_style('simple-likes-public');

	    if( is_string($this->get_options("file-style")) ){
	    	wp_register_style('main-style-v', ALOTHEMES_URL . '/css/style/' . $this->get_options("file-style"));
	    	wp_enqueue_style('main-style-v');
	    }
	    

	    wp_register_style('responsive', ALOTHEMES_URL . '/responsive.css', '', '1.0');
	    wp_enqueue_style('responsive');

	    wp_register_script('magiccart', ALOTHEMES_URL . '/js/magiccart.js', array('jquery'), '1.0', true);
	  	wp_enqueue_script('magiccart', true);

	  	wp_register_script('simple-likes-public', ALOTHEMES_URL . '/js/simple-likes-public.js');
	  	wp_enqueue_script('simple-likes-public', true);

	  	wp_register_script('jquery.easing.1.3.min', ALOTHEMES_URL . '/js/jquery.easing.1.3.min.js');
	  	wp_enqueue_script('jquery.easing.1.3.min', true);
	}

	public function magiccart_web_init(){
	  wp_register_style('font-awesome', ALOTHEMES_URL . '/font-awesome/css/font-awesome.css');
	  wp_enqueue_style('font-awesome');
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
	/* Get options Redux */
	public static function get_options($key = '', $debug=false){
		
	    $opt 	= get_option('theme_options', '');

	    if(!is_admin()){
	      if(isset($_SESSION["magiccart_option"])) {
	        $opt = $_SESSION["magiccart_option"];
	      }

	      // if(is_page()){
	      //   global $post;
	      //   $tmp = get_post_meta($post->ID, 'meta_boxes_theme_option', true );
	      //   if($tmp){
	      //     $opt = $tmp;
	      //     add_filter( 'pre_option_page_on_front', 'option_page_on_front' );
	      //     // add_filter( 'pre_option_theme_options', 'option_theme_options' );
	      //   }  

	      // }
	    }

	    if($opt){
	    	if(trim($key) != '' ){
		        if(isset($GLOBALS[$opt][$key])){
		            return $GLOBALS[$opt][$key];
		        }else{
		            $options = get_option($opt, array());
		            if(isset($options[$key])){
		                return $options[$key];
		            }else{
		                if($debug) echo "$key not isset";
		                else return $options[$key];
		            }
		        }
		    }

		    if(isset($GLOBALS[$opt])){
		        return $GLOBALS[$opt];
		    }else{
		        return get_option($opt, array());
		    }
	    }else{
	    	return __('Please save theme options !', 'alothemes');
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


	/* Categories */
	public static function magiccart_get_all_category(){
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

	

	public function woocommerce_header_add_to_cart_fragment( $fragments ) {
	  global $woocommerce;
	  
	  ob_start();
	  ?>
	    <span class="cart-quantity">
	      <?php echo WC()->cart->get_cart_contents_count() . " items";?>
	    </span>
	  <?php
	  
	  $fragments['span.cart-quantity'] = ob_get_clean();
	  
	  return $fragments;
	}
}