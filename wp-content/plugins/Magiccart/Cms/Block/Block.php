<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-03 20:44:49
 * @@Modify Date: 2017-08-03 23:52:16
 * @@Function:
 */
namespace Magiccart\Cms\Block;
use Magiccart\Core\Block\Template;

class Block extends Template{
    public function initShortcode( $atts ){
        if (!isset($atts['identifier']) || !$atts['identifier']) return ;
        $value   = get_option('magiccart_block', '');
        $value   = json_decode($value, true);
        $text    = $atts['identifier'];
        if(isset($value[$text]['value'])){
            if($value[$text]['status']){
                $editorText = $value[$text]['value'];
                print_r(wp_kses_post( $editorText));
            }
        }
    }
}
