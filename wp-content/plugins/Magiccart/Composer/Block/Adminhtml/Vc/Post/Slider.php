<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Slider extends Vc{
    
    // **********************************************************************//
    // alothemes Slider
    // **********************************************************************//
    public function initMap(){
        $temp = array(
	                array(
            				'type'          => 'dropdown',
            				'heading'       => __( 'Slider : ', 'alothemes' ),
            				'value'         => array_flip($this->getSlider()),
            				'param_name'    => 'slider',
                            'save_always'   => true,
            		),
            	);
        $params = array_merge($temp, $this->get_settings());
        
        $this->add_VcMap($params);
    }
}