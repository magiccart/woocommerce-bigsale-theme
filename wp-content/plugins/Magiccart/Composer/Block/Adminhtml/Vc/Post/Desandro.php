<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Desandro extends Vc{
    
    // **********************************************************************//
    // alothemes Desandro
    // **********************************************************************//
    public function initMap(){
        $temp = array(
                   array(
                        "type"          => "dropdown",
                        "heading"       => __("Portfolio : <span style='color:red;'>*</span> ", 'alothemes'),
                        "param_name"    => "portfolio",
                        'value'         => array_flip($this->magiccart_category_portfolio()),
                        'save_always'   => true,
                    ),
                   array(
                            "type"          => "textfield",
                            "heading"       => __("Number of posts to show : ", 'alothemes'),
                            "param_name"    => "number",
                            "value"         => "20",
                            'save_always'   => true,
                    ),
            	);
        $params = array_merge($temp, $this->get_settings());
        
        $this->add_VcMap($temp);
    }
}