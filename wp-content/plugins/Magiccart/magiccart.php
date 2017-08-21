<?php
/*
 Plugin Name: Magiccart
 Plugin URI: http://alothemes.com
 Description: Plugins Magiccart
 Author: alothemes.com
 Version: 1.0
 Author URI: http://alothemes.com/
 */

/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 17:19:56
 * @@Modify Date: 2017-08-15 21:54:30
 * @@Function:
 */

define('MAGICCART_URL'            , plugin_dir_url(__FILE__));            // URL

define('MAGICCART_DIR'            , ABSPATH . 'wp-content/plugins/Magiccart/');           // DIR



//echo ABSPATH  . 'wp-content/plugins/woocommerce/includes/walkers/class-product-cat-dropdown-walker.php';
//include_once( ABSPATH . 'wp-content/plugins/woocommerce/includes/walkers/class-product-cat-dropdown-walker.php' );
//include_once( ABSPATH . 'wp-content/plugins/redux-framework/ReduxCore/inc/class.redux_api.php' );
//require_once( plugin_dir_path( __FILE__ ) . 'custom_media_fields.php' );


use Magiccart\Core\Controller\Core;
use Magiccart\Core\Controller\Header;
use Magiccart\Testimonial\Controller\Testimonial;
use Magiccart\Portfolio\Controller\Portfolio;
use Magiccart\Core\Controller\Footer;
use Magiccart\Megamenu\Controller\Megamenu;
use Magiccart\Widgets\Controller\Widgets;
use Magiccart\Composer\Controller\Composer;
use Magiccart\Cms\Controller\Adminhtml\Cms;
use Magiccart\Shopbrand\Controller\Adminhtml\Shopbrand;
use Magiccart\Magicslider\Controller\Adminhtml\Magicslider;
use Magiccart\Import\Controller\Adminhtml\Import;

// **********************************************************************//
// Register autoloader
// **********************************************************************//

spl_autoload_register( 'maggiccart_autoloader' ); 
function maggiccart_autoloader( $class_name ) {
    if ( false !== strpos( $class_name, 'Magiccart' ) ) {
        $class_file = ABSPATH . 'wp-content'. DIRECTORY_SEPARATOR .'plugins'. DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';
        if(file_exists($class_file)) require_once  $class_file;
        // else echo '<div class="message error woocommerce-error">' . __( "Class $class_name not exist", "alothemes" ) . '</div>';
    }   
}

class Magiccart{

    /**
     * Core singleton class
     * @var self - pattern realization
     */
    private static $_instance;

    private $_menu_slug         = 'magiccart';
    public function __construct(){

        add_action("plugins_loaded", array($this, 'init'), 55); // 99

        if(is_admin()){
            // if (isset($_GET['page']) && $_GET['page'] == 'magiccart') {
            //     add_action('admin_print_scripts', array($this, 'admin_scripts') );
            //     add_action('admin_print_styles', array($this, 'admin_styles') );
            // }
            add_action( 'admin_enqueue_scripts', array($this, 'load_wp_media_files') );
            add_action('admin_menu', array($this, '_setActiveMenu'));
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
    
    public function init(){

        new Core();
        new Header();
        new Portfolio();
        new Testimonial();
        new Footer();
        if ( class_exists( 'WooCommerce' ) ) {
            new Widgets();   
        } else {
                // <div class="message error"><p>Color Filters by <a href="https://www.elementous.com" target="_blank">Elementous</a> is enabled but not effective. It requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> plugin in order to work.</p></div>
                echo '<div class="message error woocommerce-error"><p>' . __('WooCommerce not installed or Activate', 'alothemes') . '</p></div>';

        }
        if ( class_exists( 'Vc_Manager' ) ) {
            new Composer();
        } else {
            echo '<div class="message error woocommerce-error"><p>' . __('Visual Composer not installed or Activate', 'alothemes') . '</p></div>';
        }


        // new Megamenu();
        if(is_admin()){
            new Cms();
            new Magicslider();
            new Shopbrand();
            new Import();
        }
    }
    
    public function _setActiveMenu(){
        add_menu_page(__('Magiccart', "alothemes"), __('Magiccart', "alothemes"), 'manage_options', $this->_menu_slug 
            , "", "dashicons-smiley", 30);
    }
    
    
    public function admin_scripts() {
    	wp_enqueue_script('media-upload');
    	wp_enqueue_script('thickbox');
    }
    public function admin_styles() {
    	wp_enqueue_style('thickbox');
    }
    public function load_wp_media_files() {
    	wp_enqueue_media();
    }   
}

global $magiccart;
if ( ! $magiccart ) {
    $magiccart = Magiccart::getInstance();
}
