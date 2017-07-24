<?php 
namespace Magiccart\Import\Controller\Adminhtml;

use Magiccart\Core\Controller\Adminhtml\Action;
use Magiccart\Import\Block\Adminhtml\Import\Importblock;
use Magiccart\Import\Model\Import\Collection;

class Import extends Action {
	private $_menu_slug         = 'magiccart';
	public $_import;
	public $_collection;
	
	public function __construct(){
		add_action('admin_enqueue_scripts', array($this, 'add_admin_web'));
		add_action("wp_ajax_load_page", array($this, 'load_page'));
		if(is_admin())  $this->_initAction();
	}
	
	protected function _initAction(){
		add_action('admin_menu', array($this, 'subMenu'));
	}
	
	public function subMenu(){
		add_submenu_page($this->_menu_slug, __('Import / Export', "alothemes"), __('Import / Export', "alothemes"), 'manage_options',
				$this->_menu_slug . '-import-export' , array($this, 'indexAction'));
	}
	
	public function indexAction(){
		$this->_import = new Importblock();
		$this->_collection = new Collection();
		$this->_import->addData($this->_collection->tools());
		echo $this->_import->toHtml();
	}

	public function add_admin_web(){
         wp_register_script('mc-import', $this->get_url('adminhtml/web/js/import.js') );
         wp_enqueue_script('mc-import');
	}
	public function load_page(){
        $xhtml = '';
		if($_POST['selectAction'] == 'export'){
			foreach (get_pages() as  $value) {
	            $xhtml .= '<option value="'. $value->post_title .'_'. $value->ID .'"> '. $value->post_title .' </option>';
	        }
		}else{
			$pathEtc 	= ABSPATH . 'wp-content/plugins/Magiccart/Import/etc/data_page';
			$folder 	= scandir($pathEtc);
			$folder 	= array_slice($folder, 2);
			
			foreach ($folder as  $value) {
				$name 		= explode('_', $value);
	            $xhtml .= '<option value="'. $value . '"> '. $name[0] .' </option>';
	        }
		}
		echo $xhtml;
	}
}

