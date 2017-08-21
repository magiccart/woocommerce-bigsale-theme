<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2017-08-12 17:03:20
 * @@Function:
 */

namespace Magiccart\Megamenu\Controller;

use Magiccart\Megamenu\Block\Menu;
use Magiccart\Megamenu\Model\Menu\Collection;
use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Megamenu\Block\Adminhtml\Menu\Item;

class Megamenu extends Action{
    private $_conllection;
    public $_template = "setting.phtml";
    public function __construct(){

        if(is_admin()){
            if(!$this->is_edit_menu()) return;
            new Item();
            add_action( 'admin_enqueue_scripts', array($this, 'add_admin_web'));
        }else {
            $menu = new Menu();
            add_filter( 'wp_nav_menu_args', array($menu, 'setMenu') );
            add_action( 'wp_enqueue_scripts', array($this, 'add_fontend_web') );
        }
        
    }

    protected function is_edit_menu($new_edit = null){
        global $pagenow;
        //make sure we are on the backend
        // if (!is_admin()) return false;
        return in_array( $pagenow, array( 'nav-menus.php' ) );
    }
    
    public function add_admin_web(){
        wp_register_script('upload',  $this->get_url("adminhtml/web/js/upload-image.js"), array('jquery') ,'1.0');
        wp_enqueue_script('upload');
    }

    public function add_fontend_web(){
        wp_register_style('magicmenu.css', $this->get_url("frontend/web/css/magicmenu.css"));
        wp_enqueue_style('magicmenu.css');
    
        /*wp_register_style('meanmenu.min.css', $this->get_url("frontend/web/css/meanmenu.min.css"));
        wp_enqueue_style('meanmenu.min.css');*/

        wp_register_script('magicmenu',  $this->get_url("frontend/web/js/magicmenu.js"), array('jquery') ,'1.0');
        wp_enqueue_script('magicmenu');
    }   
}
