<?php
namespace Magiccart\Composer\Block\Product;
use Magiccart\Composer\Block\Shortcode;

class Brands extends Shortcode{

    protected $_brands = array();

    public function initShortcode( $atts, $content = null ){
        $this->nullData();
        $this->addData($atts);
        $brands = get_option('magiccart_brand', array());
        $brands = json_decode($brands, true);
        foreach ($brands as $key => $value) {
            if(!$value['status']){
                unset($brands[$key]);
            }
        }
        $this->_brands = array_slice($brands, 0, $atts['number']);
        
        return $this->toHtml();
    }
}

