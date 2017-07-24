<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Product;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Products extends Vc{
    
    // **********************************************************************//
    // get $alothemesProduct
    // **********************************************************************//
    public function initMap(){
        $temp = array(
		                array(
		                    "type"              => "multi_select",
		                    "heading"           => __("Product Collection  <span style='color:red;'>*</span> :", 'alothemes'),
		                    "param_name"        => "product_collection",
		                    'value'             => $this->get_type("name"),
		                ),
		                array(
		                    "type"      	=> "dropdown",
		                    "heading"   	=> __("Product Activated : ", 'alothemes'),
		                    "param_name" 	=> "product_activated",
		                    'value' 		=>  $this->get_type(),
		                    'save_always' 	=> true,
		                )
		            );
        $params = array_merge($temp, $this->get_settings(), $this->settingShow(), $this->countTime(), $this->defaultBlock());
        
        $this->add_VcMap($params);
    }
}