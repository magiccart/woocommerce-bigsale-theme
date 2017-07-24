<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Picturecategory extends Vc{
    
    // **********************************************************************//
    // alo Themes Category Product
    // **********************************************************************//
    public function initMap(){
        $params = array(
		                array(
		                    'type' 			=> 'attach_image',
		                    "heading" 		=> __("Image", 'alothemes'),
		                    "param_name" 	=> "img_src"
		                    'save_always' 	=> true,
		                ),
		                array(
		                    "type"      	=> "dropdown",
		                    "heading"   	=> __("Parent Category", 'alothemes'),
		                    "param_name" 	=> "parent",
		                    'value' 		=>  parent::getArrParentCat(),
		                    'save_always' 	=> true,
		                ),
		            );
        
        $this->add_VcMap($params);
    }
}