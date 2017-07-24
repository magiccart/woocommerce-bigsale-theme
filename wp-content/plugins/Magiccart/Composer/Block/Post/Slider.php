<?php
namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Slider extends Shortcode{
    // **********************************************************************//
    // alothemes Slider
    // **********************************************************************//
    public function initShortcode( $atts, $content = null ){

        $this->addData($atts);
        
        $optionSlider                  = get_option('magiccart_slider', '');
        $optionSlider                  = json_decode($optionSlider, true);
        if(!isset( $optionSlider[$this->getData('slider')] )) return ; 
        
        $group         = $optionSlider[$this->getData('slider')];
        $idSlider      = array();
        $slider = array();
       
        foreach ($group['value'] as $key => $value) {
            if($value['status']){
                unset($group['value'][$key]);
            }
        }
        $this->_sliders = array_slice($group['value'], 0, $this->getData('number'));

        return $this->toHtml();
    }
}