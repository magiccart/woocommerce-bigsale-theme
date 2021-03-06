<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 11:09:08
 * @@Modify Date: 2017-08-15 18:33:10
 * @@Function:
 */

namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;

class Categories extends Products{
	
    public function initMap(){
        $temp = array(
        			array(
	        			'type'          => "textfield",
	        			'heading'       => __("Title : ", 'alothemes'),
	        			'param_name'    => "title",
	        			'save_always' 	=> true,
		        	),
	                array(
	                    'type'          => 'multiselect',
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
	                    'type'      	=> "dropdown",
	                    'heading'   	=> __("Product Activated :", 'alothemes'),
	                    'param_name' 	=> "product_activated",
	                    'value' 		=> array_flip($this->get_type("name")),
	                    'save_always' 	=> true,
	                ),

	            );
        $params = array_merge(
        	$temp, 
        	$this->get_settings(), 
        	$this->get_responsive(), 
        	$this->settingShow(), 
        	$this->defaultBlock(), 
        	$this->get_templates()
        );
        
        $this->add_VcMap($params);
    }

}

