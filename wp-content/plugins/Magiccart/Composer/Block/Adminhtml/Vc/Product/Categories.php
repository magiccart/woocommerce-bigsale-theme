<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Categories extends Vc{
    // **********************************************************************//
    // alothemes Categories
    // **********************************************************************//
    public function initMap(){
        $temp = array(
        			array(
	        			"type"          => "textfield",
	        			"heading"       => __("Title : ", 'alothemes'),
	        			"param_name"    => "title",
	        			'save_always' 	=> true,
		        	),
	                array(
	                    'type'          => 'multi_select',
	                    'heading'       => __( 'Categories <span style="color:red;">*</span> : ', 'alothemes' ),
	                    'value'         => $this->getCategories(),
	                    'param_name'    => 'categories',
	                    'description'   => __( 'Product categories list', 'alothemes' ),
	                ),
	                array(
	                    'type'          => 'dropdown',
	                    'heading'       => __( 'Category Activated :', 'alothemes' ),
	                    'value'         => $this->getCategories(),
	                    'param_name'    => 'category_activated',
	                    'save_always' 	=> true,
	                ),
	                array(
	                    "type"      	=> "dropdown",
	                    "heading"   	=> __("Product Activated :", 'alothemes'),
	                    "param_name" 	=> "product_activated",
	                    'value' 		=> array_flip($this->get_type("name")),
	                    'save_always' 	=> true,
	                ),

	            );
        $params = array_merge($temp, $this->get_settings(), $this->settingShow(), $this->defaultBlock());
        
        $this->add_VcMap($params);
    }
}