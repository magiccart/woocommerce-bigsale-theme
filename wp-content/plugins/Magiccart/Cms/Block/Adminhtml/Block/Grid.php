<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 23:54:46
 * @@Modify Date: 2017-08-03 23:55:00
 * @@Function:
 */
namespace Magiccart\Cms\Block\Adminhtml\Block;
use Magiccart\Cms\Model\Block\Collection;

 class Grid extends  \WP_List_Table{
    private $_per_page = 15;
    private $_total_block;
    protected $_template ;
    
    public function __construct(){
        $collection = new Collection();
        
        $this->items            = $collection->getDataBlock();
        $this->_total_block     = $collection->totalBlock();
        
        $this->_template = ABSPATH . 'wp-content/plugins/Magiccart/Cms/view/adminhtml/templates/gird.phtml';
        $args = array(
            'plural' 	=> 'magiccart-block-grid',
			'singular' 	=> 'magiccart-block-grid'
        );
        
        parent::__construct($args);
    }
    
     public function setTemplate($template){
        if($template) return;
        
        $fileTheme = get_stylesheet_directory() . " Magiccart/' " . $template ;
        if(!file_exists($fileTheme)) $fileTheme = ABSPATH . 'wp-content/plugins/Magiccart/' . $template ;
        $this->_template = $fileTheme;
    }
    

    public function toHtml(){
        require_once $this->_template;
    }

    public function getTemplate(){
        return $this->_template;
    }
    
    /* return columns header */
    public function get_columns(){
        $columnHeader = array(
            'stt'           => 'STT',
            'name'          => 'Name',
            'short_code'    => 'Short Code',
            'published'     => 'Published',
            'action'        => 'Action'
        );
        return $columnHeader;
    }
    
    /* return columns hidden */
    public function get_hidden_columns(){
        return array();
    }
    
    /* return columns sortable */
    public function get_sortable_columns(){
        return array(
            'id' => array('id' => true)
        );
    }
   
    public function prepare_items(){
        $columnsHeader  = $this->get_columns();
        $columnsHidden  = $this->get_hidden_columns();
        $columnSortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columnsHeader, $columnsHidden, $columnSortable);
        
        $totalPages = ceil($this->_total_block/$this->_per_page);
        $this->set_pagination_args(array(
                                        'total_items' => $this->_total_block,
                                        'per_page'    => $this->_per_page,
                                        'total_pages' => $totalPages
                                    ));
    }
    
    
    public function column_stt($item){
        return $item['stt'];
    }
    public function column_name($item){
        $page       = $_GET['page'];
        $xhtml      = "<a href='?page={$page}&identifier={$item['key']}&action=edit'>{$item['name']} </a>";
        return $xhtml;
    }
    public function column_short_code($item){
        $disabled = $item['status'] ? '' : 'disabled="disabled"';
        // return "<input type='text' $disabled value='[magiccart_shortcode identifier={$item['key']}]' />";
        return '<textarea ' . $disabled . '>[magiccart_shortcode class="Magiccart\\\\Cms\\\\Block\\\\Block" identifier="' .$item['key'] . '"]</textarea>';
    }
    public function column_published($item){
        if($item['status']){
            $img    = CMS_IMAGES . 'publish.png';
            $action = 'inactive';
        }else{
            $img    = CMS_IMAGES . 'unpublish.png';
            $action = 'active';
        }
        $page  = $_GET['page'];
        
        $xStatus = "<a href='?page={$page}&status={$action}&identifier={$item['key']}' ><img src='{$img}' /></a>";
        return $xStatus;
    }
    
    public function column_action($item){
        $img = CMS_IMAGES . 'delx.png';
        $page = $_GET['page'];
        $xAction = "<a href='?page={$page}&action=delete&identifier={$item['key']}' ><img src='{$img}' /></a>";
        return $xAction;
    }  
}

