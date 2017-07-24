<?php
/*
 Plugin Name: Magiccart
 Plugin URI: http://wordpress.org
 Description: Plugins Magiccart
 Author: alothemes.com
 Version: 1.0
 Author URI: http://alothemes.com/
 */

define('MAGICCART_URL'            , plugin_dir_url(__FILE__));            // URL

define('MAGICCART_DIR'            , ABSPATH . 'wp-content/plugins/Magiccart/');           // DIR



//echo ABSPATH  . 'wp-content/plugins/woocommerce/includes/walkers/class-product-cat-dropdown-walker.php';
//include_once( ABSPATH . 'wp-content/plugins/woocommerce/includes/walkers/class-product-cat-dropdown-walker.php' );
//include_once( ABSPATH . 'wp-content/plugins/redux-framework/ReduxCore/inc/class.redux_api.php' );
//require_once( plugin_dir_path( __FILE__ ) . 'custom_media_fields.php' );

// file return include
/* array(
		'Magiccart\Widgets\Block\Blogcategory\Widgets' => array(
				
		)
		
) */


use Magiccart\Core\Controller\Core;
use Magiccart\Testimonial\Controller\Testimonial;
use Magiccart\Portfolio\Controller\Portfolio;
use Magiccart\Megamenu\Controller\Megamenu;
use Magiccart\Cms\Controller\Adminhtml\Cms;
use Magiccart\Widgets\Controller\Widgets;
use Magiccart\Composer\Controller\Composer;
use Magiccart\Shopbrand\Controller\Adminhtml\Shopbrand;
use Magiccart\Magicslider\Controller\Adminhtml\Magicslider;
use Magiccart\Import\Controller\Adminhtml\Import;

// **********************************************************************//
// Register autoloader
// **********************************************************************//

spl_autoload_register( 'maggiccart_autoloader' ); 
function maggiccart_autoloader( $class_name ) {
    if ( false !== strpos( $class_name, 'Magiccart' ) ) {
        require_once  ABSPATH . 'wp-content'. DIRECTORY_SEPARATOR .'plugins'. DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
    }   
}

class Magiccart{
    private $_menu_slug         = 'magiccart';
    public function __construct(){
        add_action('admin_menu', array($this, '_setActiveMenu'));
        add_action("plugins_loaded", array($this, 'init'), 99);
        
        if (isset($_GET['page']) && $_GET['page'] == 'my_plugin_page') {
        	add_action('admin_print_scripts', array($this, 'my_admin_scripts') );
        	add_action('admin_print_styles', array($this, 'my_admin_styles') );
        }
        
        if(is_admin()){
        	add_action( 'admin_enqueue_scripts', array($this, 'load_wp_media_files') );
        }
    }
    
    public function init(){
        new Cms();
        new Testimonial();
        new Portfolio();
        new Core();
        $composer    = WP_PLUGIN_DIR . "/js_composer/js_composer.php";
        $woocommerce = WP_PLUGIN_DIR . "/woocommerce/woocommerce.php";
        
        if(file_exists($composer) && file_exists($woocommerce)){
        	if(is_plugin_active("js_composer/js_composer.php") && is_plugin_active("woocommerce/woocommerce.php")){
        		new Composer();
                new Widgets();
        		if(is_admin()){
        			new Shopbrand();
        		}
        	}
        	
        }
        // new Megamenu();
        if(is_admin()){
            new Magicslider();
            new Import();
        }
    }
    
    public function _setActiveMenu(){
        add_menu_page(__('Magiccart', "alothemes"), __('Magiccart', "alothemes"), 'manage_options', $this->_menu_slug 
            , "", "dashicons-smiley", 30);
    }
    
    
    public function my_admin_scripts() {
    	wp_enqueue_script('media-upload');
    	wp_enqueue_script('thickbox');
    	wp_register_script('my-upload', WP_PLUGIN_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
    	wp_enqueue_script('my-upload');
    }
    public function my_admin_styles() {
    	wp_enqueue_style('thickbox');
    }
    public function load_wp_media_files() {
    	wp_enqueue_media();
    }   
}

function init(){
    new Magiccart();    
}
add_action("plugins_loaded", 'init', 55);





