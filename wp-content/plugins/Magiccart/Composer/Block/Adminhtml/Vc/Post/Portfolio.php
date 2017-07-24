<?php
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Portfolio extends Vc{
    
    // **********************************************************************//
    // alothemes Portfolio
    // **********************************************************************//
    public function initMap(){
        $temp = array(
                   array(
                        "type"          => "multi_select",
                        "heading"       => __("Portfolio Collection : <span style='color:red;'>*</span> ", 'alothemes'),
                        "param_name"    => "portfolio_collection",
                        'value'         => $this->magiccart_category_portfolio(),
                        'save_always'   => true,
                    ),
            	);
        $params = array_merge($temp, $this->get_settings());
        
        $this->add_VcMap($params);
    }
}