<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Brands extends Vc{
    
    // **********************************************************************//
    // alothemes Catalog
    // **********************************************************************//
	public function initMap()
	{
  		$listCat = array_flip($this->getCategories());
        
        $temp 	= array(
	                
	            );
        
        $params = array_merge($temp, $this->get_settings());
        
		$this->add_VcMap($params);
	}
	
}