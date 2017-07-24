<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Catalog extends Vc{
    
    // **********************************************************************//
    // alothemes Catalog
    // **********************************************************************//
	public function initMap()
	{
  		$listCat = array_flip($this->getCategories());
        
        $temp 	= array(
        			array(
	                    'type'          => 'dropdown',
	                    'heading'       => __( "Category Activated :", 'alothemes' ),
	                    'value'         => $listCat,
	                    'param_name'    => 'category_activated',
	                    'save_always' 	=> true,
	                ),
	                array(
	                    "type"      	=> "multi_select",
	                    "heading"   	=> __("Product Collection : <span style='color:red;'>*</span> ", 'alothemes'),
	                    "param_name" 	=> "product_collection",
	                    'value' 		=> $this->get_type("name"),
	                ),
	                array(
	                    'type'          => 'multi_select',
	                    'heading'       => __( "Categories <span style='color:red;'>*</span> :", 'alothemes' ),
	                    'value'         => $this->getCategories(),
	                    'param_name'    => 'categories',
	                    'description'   => __( 'Product Categories list', 'alothemes' ),
	                ),
	                array(
	                    "type"      	=> "dropdown",
	                    "heading"   	=> __("Product Activated : ", 'alothemes'),
	                    "param_name" 	=> "product_activated",
	                    'value' 		=>  $this->get_type(),
	                    'save_always' 	=> true,
	                ),
	                
	            );
        
        $params = array_merge($temp, $this->get_settings(), $this->settingShow(), $this->defaultBlock());
        
		$this->add_VcMap($params);
	}	
}