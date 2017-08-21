<?php 
namespace Magiccart\Shopbrand\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Shopbrand\Block\Adminhtml\Brand\Grid;
use Magiccart\Shopbrand\Block\Adminhtml\Brand\Edit;
use Magiccart\Shopbrand\Controller\Adminhtml\Brand;

class Shopbrand extends Action {
	private $_menu_slug         = 'magiccart';
	public $_brand;
	
	public function __construct(){
		add_action('admin_enqueue_scripts', array($this, 'add_admin_web'));
		
		add_action("wp_ajax_load_terms", array($this, 'load_terms'));
		if(is_admin())  $this->_initAction();
	}
	
	protected function _initAction(){
		add_action('admin_menu', array($this, 'subMenu'));
	
	}
	
	public function subMenu(){
		add_submenu_page($this->_menu_slug, __('Shop Brand', "alothemes"), __('Shop Brand', "alothemes"), 'manage_options',
				$this->_menu_slug . '-shopbrand' , array($this, 'indexAction'));
	}
	
	public function indexAction(){
		$this->_brand = new Brand();
		 if(isset($_GET['action']) && $_GET['module'] == 'shopbrand' && trim($_GET['action']) != '' && ($_GET['action'] == 'edit' || $_GET['action'] == 'add') ){
		 	$edit = new Edit();
		 	$data = $this->_brand->saveBrand();
		 	
		 	$edit->addData($data);
		 	
		 	echo $edit->toHtml();
		 }else{
		 	if(isset($_GET['action']) && $_GET['action'] == 'delete'){
		 		$this->_brand->delete();
		 	}
		 	$brand = new Grid();
		 	echo $brand->toHtml();
		 }
		 
		 if(isset($_GET['status'])) $this->_brand->editStatus();
		 
	}
     public function add_admin_web(){
         wp_register_script('shopbrand', $this->get_url('adminhtml/web/js/shopbrand.js') , '1.0');
         wp_enqueue_script('shopbrand');
         wp_localize_script( 'mpProduct', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));
         
		 wp_register_style('shopbrand', $this->get_url("adminhtml/web/css/shopbrand.css"), array(), '1.0');
     	 wp_enqueue_style('shopbrand');
     }
     
     public function load_terms(){
     	if(isset($_POST['typeAttr'])){
     		$termDefault 	= $_POST['termDefault'];
     		$typeAttr 		= $_POST['typeAttr'];
     		$listTerm 		= get_terms();
     		$xhtml = "";
     		foreach($listTerm as $value){
     			if($value->taxonomy == $typeAttr){
     				$selected =  "";
     				if($value->slug == $termDefault){
     					$selected = "selected= 'selected'";
     				}
     				$xhtml .= "<option {$selected} value='{$value->slug}'>{$value->name}</option>";
     			}
     		}
     	}
     	echo $xhtml;
     	die();
     }
}

