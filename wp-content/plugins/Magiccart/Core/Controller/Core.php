<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 17:22:24
 * @@Modify Date: 2017-08-14 14:54:48
 * @@Function:
 */
 
namespace Magiccart\Core\Controller;
use Magiccart\Core\Block\Shortcode;
use Magiccart\Core\Model\System\Theme\Option;
// use Magiccart\Core\Block\Themecfg;

class Core {
	public $_templateTheme = "bigsale";
	public $_option;
    public function __construct(){
        $this->_option = new Option();
        $opt = $this->_option->getName();

        if(!is_admin()){
            // new \Magiccart\Core\Controller\Index ;
            new Shortcode();
            add_action('wp_enqueue_scripts', array($this, 'add_fontend_web'));
        }else{
            // new Themecfg();
            // new \Magiccart\Core\Controller\Adminhtml\Index;
            add_action('tgmpa_register', array($this, 'magiccart_plugin_activation') );

            //add_action('init', array($this, 'activateTheme'));
            add_action('init', array($this, 'changeOptions'));
           
            $tgm = MAGICCART_DIR .'Core/Block/includes/class-tgm-plugin-activation.php';
            if( file_exists($tgm) ) require_once ($tgm); 
        }

    } 


    public function get_url($link = ""){
    	$tmp = explode('\\', get_class($this));
    	return  plugins_url() . '/Magiccart/' . $tmp[1] . '/view/' . $link;
    }
    
    public function magiccart_plugin_activation() {
        //  plugin active
        $plugins = array(
            array(
                'name'      => 'Redux Framework',
                'slug'      => 'redux-framework',
                'required'  => true
            ),
            array(
                'name'      => 'woocommerce',
                'slug'      => 'woocommerce',
                'required'  => true,
                'version'   => '3.0.0'
            ),
            //  array(
            //     'name'                  => 'Revolution Slider',
            //     'slug'                  => 'revslider',
            //     'version'               => '4.6.3',
            //     'required'              => true,
            // ),
            array(
                'name'                  => 'WPBakery Visual Composer', // The plugin name
                'slug'                  => 'js_composer', // The plugin slug (typically the folder name)
                //'source'                => get_stylesheet_directory() . '/plugins/js_composer.zip', // The plugin source
                'required'              => true, 
                ),
            array(
                'name'                  => 'Contact Form 7', 
                'slug'                  => 'contact-form-7',
                'required'              => true, 
            ),
            array(
                'name'                  => 'Yith Plugins', 
                'slug'                  => 'yith-essential-kit-for-woocommerce-1',
                'required'              => true, 
            ),
            array(
                'name'                  => 'Newsletter', 
                'slug'                  => 'newsletter',
                'required'              => true, 
            ),
            array(
                'name'                  => 'Color Filters for WooCommerce', 
                'slug'                  => 'color-filters',
                'required'              => true, 
            ),
        );
    
        // Setting TGM
        $configs = array(
            'menu'          => 'tp_plugin_install',
            'has_notice'    =>  true,
            'dismissable'   => false,
            'is_automatic'  => true
        );
        tgmpa( $plugins, $configs );
    }
    
    public function changeOptions(){
        $currentOptions = $this->_option->getName();

        if(isset($_POST[$currentOptions]['theme_options'])){
            update_option('theme_options', $_POST[$currentOptions]['theme_options']);
        }

        if(isset($GLOBALS[$currentOptions]['theme_options']) && $GLOBALS[$currentOptions]['theme_options'] != ""){
            $newOptions = $GLOBALS[$currentOptions]['theme_options'];
            if($currentOptions != $newOptions){
                $GLOBALS[$newOptions]['theme_options'] = $newOptions;
                if(isset($GLOBALS[$currentOptions])){
                   $GLOBALS[$currentOptions]['theme_options'] = $currentOptions;
                   update_option($currentOptions, $GLOBALS[$currentOptions]);
                }
                $optBackUp = $this->_option->getName();
                $valueBackUp = get_option($optBackUp, array());
                
                $GLOBALS[$optBackUp] = $valueBackUp;
                wp_redirect("?page=" . $_GET['page']);
            }
        } 
    }

    public function activateTheme(){
    	$opt = $this->_option->getName();
    	$template = get_option('stylesheet');
    	
    	if(isset($GLOBALS[$opt]['theme']) && $GLOBALS[$opt]['theme'] != ""){
    		
    		$theme = $GLOBALS[$opt]['theme'];
    		if($GLOBALS[$opt]['theme'] != $template){
    			$GLOBALS[$opt]['theme'] = "";
    			update_option($opt, $GLOBALS[$opt]);
    			
    			update_option('stylesheet', $theme);
    			update_option('template', $this->_templateTheme);
    			
    			$optBackUp = $this->_option->getName();
    			$valueBackUp = get_option($optBackUp, array());
    			$GLOBALS[$optBackUp] = $valueBackUp;
    			
    			wp_redirect("?page=" . $_GET['page']);
    		}
    	}
    }

     public function add_fontend_web(){
        wp_register_script('jquerylazyloadmin', $this->get_url('frontend/web/js/jquery.lazyload.min.js'));
        wp_enqueue_script('jquerylazyloadmin');

        wp_register_script('slickminjs', $this->get_url('frontend/web/js/slick-master/slick/slick.min.js'));
        wp_enqueue_script('slickminjs');
       
        wp_register_style('slick', $this->get_url('frontend/web/js/slick-master/slick/slick.css'));
        wp_enqueue_style('slick');

        wp_register_style('magnific-popup', $this->get_url('frontend/web/js/Magnific-Popup/dist/magnific-popup.css'));
        wp_enqueue_style('magnific-popup');
        
        wp_register_script('jquery.magnific-popup.min', $this->get_url('frontend/web/js/Magnific-Popup/dist/jquery.magnific-popup.min.js'));
        wp_enqueue_script('jquery.magnific-popup.min');

        wp_register_script('jquery-cookie-master', $this->get_url('frontend/web/js/jquery.cookie.js'));
        wp_enqueue_script('jquery-cookie-master');
     }
}

