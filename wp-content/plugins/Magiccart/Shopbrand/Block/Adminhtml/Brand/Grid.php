<?php
namespace Magiccart\Shopbrand\Block\Adminhtml\Brand;

 use Magiccart\Shopbrand\Model\Brand\Collection;
	
 class Grid extends  \WP_List_Table{
    private $_per_page = 15;
    private $_total_brands;
    protected $_template ;
    
    public function __construct(){
    	$collection = new Collection();
    	
        $this->items             = $collection->getBrands();
        $this->_total_brands     = $collection->totalBrands();
        
        $this->_template = ABSPATH . 'wp-content/plugins/Magiccart/Shopbrand/view/adminhtml/templates/grid.phtml';
        $args = array(
            'plural' 	=> 'magiccart-brand-grid',
			'singular' 	=> 'magiccart-brand-grid'
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
        	'attributes'    => 'Attributes',
        	'term'    		=> 'Term',
            'image'    		=> 'Image',
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
            
        );
    }
   
    public function prepare_items(){
        $columnsHeader  = $this->get_columns();
        $columnsHidden  = $this->get_hidden_columns();
        $columnSortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columnsHeader, $columnsHidden, $columnSortable);
        
        
        $totalPages = ceil($this->_total_brands/$this->_per_page);
        $this->set_pagination_args(array(
                                        'total_items' => $this->_total_brands,
                                        'per_page'    => $this->_per_page,
                                        'total_pages' => $totalPages
                                    ));
    }
    
    
    public function column_stt($item){
        return $item['stt'];
    }
    public function column_name($item){
        $page       = $_GET['page'];
        $xhtml      = "<a href='?page={$page}&key={$item['key']}&modul=shopbrand&action=edit'>{$item['name']} </a>";
        return $xhtml;
    }
    public function column_attributes($item){
        if($item['attributes'] == -1) return " ";
    	$attribute = ucfirst(substr($item['attributes'], 3));
    	return $attribute;
    }
    public function column_term($item){
        if($item['term'] == -1) return " ";
    	$term = ucfirst($item['term']);
    	return $term;
    }
    public function column_image($item){
    	$img = "<img width='70px' height='35px' style='border:1px dotted #8CCFFA;' src='{$item['image']}' />";
    	
    	return $img;
    }
    public function column_published($item){
        if($item['status']){
            $show    = 'brand-publish';
            $action = 'unpublish';
        }else{
            $show    = 'brand-unpublish';
            $action = 'publish';
        }
        $page  = $_GET['page'];
        
        $xStatus = "<a class='{$show}' href='?page={$page}&status={$action}&key={$item['key']}' ></a>";
        return $xStatus;
    }
    public function column_action($item){
    	$page = $_GET['page'];
    	$xAction = "<a class='del-shopbrand' title='delete' href='?page={$page}&action=delete&key={$item['key']}' ></a>";
    	return $xAction;
    }
}