<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-13 23:10:38
 * @@Function:
 */

namespace Magiccart\Composer\Block\Element;
use Magiccart\Composer\Block\Shortcode;

class Copyright extends Shortcode{

    public function initShortcode( $atts, $content = null){
        $this->addData($atts);
        return $this->toHtml();
    }

}

