<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2017-08-10 20:58:22
 * @@Function:
 */

namespace Magiccart\Cms\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Cms\Model\Block\Collection;
use Magiccart\Cms\Block\Adminhtml\Block\Grid;
use Magiccart\Cms\Block\Adminhtml\Block\Edit;

define('CMS_IMAGES', plugins_url() . '/Magiccart/Cms/view/adminhtml/web/images/'); // IMAGES

class Cms extends Action
{
    private $_menu_slug = 'magiccart';
    public $_collection;
    public $_block;
    
    public function __construct()
    {
        $this->_initAction();
        add_action('admin_enqueue_scripts', array(
            $this,
            'add_admin_web'
        ));
    }
    
    protected function _initAction()
    {
        add_action('admin_menu', array(
            $this,
            'subMenu'
        ));
    }
    
    public function subMenu()
    {
        add_submenu_page($this->_menu_slug, __('Block', "alothemes"), __('Block', "alothemes"), 'manage_options', $this->_menu_slug, array(
            $this,
            'indexAction'
        ));
    }
    
    public function indexAction()
    {
        $this->_block = new Block();
        
        $this->_collection = new Collection();
        
        if (isset($_GET['action']) && trim($_GET['action']) != '' && ($_GET['action'] == 'edit' || $_GET['action'] == 'add')) {
            $edit = new Edit();
            $edit->addData($this->_block->saveBlock());
            echo $edit->toHtml();
        } else {
            $this->grid();
        }
        
        if (isset($_GET['status']))
            $this->_block->editStatus();
        
        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $this->_block->delete();
        }
        
    }
    
    public function grid()
    {
        $block = new Grid();
        echo $block->toHtml();
    }
    
    function add_admin_web()
    {
        wp_register_style('magiccart_cms', $this->get_url("adminhtml/web/css/magiccart_cms.css"), array(), '1.0');
        wp_enqueue_style('magiccart_cms');
    }
}
