<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Posts extends Vc{
    
    // **********************************************************************//
    // alothemes Posts
    // **********************************************************************//
    public function initMap(){
        $temp = array(
	                array(
            				'type'          => 'dropdown',
            				'heading'       => __( 'Order by : ', 'alothemes' ),
            				'value'         => array_flip(parent::getTypePosts()),
            				'param_name'    => 'orderby',
                            'save_always'   => true,
            		),
            	);
        $params = array_merge($temp, $this->get_settings());
        
        $this->add_VcMap($params);
    }
}