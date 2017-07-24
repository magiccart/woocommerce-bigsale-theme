<?php
namespace Magiccart\Magicslider\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Magicslider\Model\Collection;
use Magiccart\Magicslider\Block\Shortcode;
use Magiccart\Magicslider\Block\Adminhtml\Slider\Grid;
use Magiccart\Magicslider\Block\Adminhtml\Slider\Edit;

class Magicslider extends Action {
    private $_menu_slug         = 'magiccart';
    public $_collection ;
    public $_slider;
    
    public function __construct(){
        if(!is_admin()) new Shortcode();
        $this->_initAction();
        add_action('admin_enqueue_scripts', array($this, 'add_admin_web'));
    }
    protected function _initAction(){
        add_action('admin_menu', array($this, 'subMenu'));
        
    }
    public function subMenu(){
        add_submenu_page($this->_menu_slug, __('Slider', "alothemes"), __('Slider', "alothemes"), 'manage_options',
        $this->_menu_slug . '-slider' , array($this, 'indexAction'));
    }
    
    public function setTemplate($template){
        if($template) return;
        
        $fileTheme = get_stylesheet_directory() . " Magiccart/' " . $template ;
        if(!file_exists($fileTheme)) $fileTheme = ABSPATH . 'wp-content/plugins/Magiccart/' . $template ;
        $this->_templateAdd = $fileTheme;
    }
    
    public function indexAction(){
       $page    = $_GET['page'];
       $action  = isset($_GET['action']) ? $_GET['action'] : '';
       $this->_slider = new Slider();
       
       $this->_collection = new Collection();
       
       if(isset($_GET['action']) && trim($_GET['action']) != '' && ($_GET['action'] == 'edit' || $_GET['action'] == 'add') ){
           $edit = new Edit();
           $edit->addData( $this->_slider->saveGroupSlider() );
           echo $edit->toHtml();
       }else{
            $this->grid();
       }
       
       if($action == 'delete'){
           $this->_slider->deleteItemGroup();
           $this->_slider->deleteGroup();
       }
       
    }
    public function grid(){
       $block = new Grid();

       echo $block->toHtml();
    }
    // **********************************************************************//
    // add admin
    // **********************************************************************//
    function  add_admin_web(){
        wp_enqueue_media();

        wp_register_style('magicslider', $this->get_url("adminhtml/web/css/magicslider.css"), array(), '1.0');
        wp_enqueue_style('magicslider');

        wp_register_script('magicslider', $this->get_url('adminhtml/web/js/magicslider.js') , '1.0');
        wp_enqueue_script('magicslider');
    }
}