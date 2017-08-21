<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-10 10:22:36
 * @@Modify Date: 2017-08-15 18:26:49
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Menu;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Topmenu extends Navigation{

    public function initMap(){
        $temp = array(
                        array(
                            "type"          => "dropdown",
                            "heading"       => __('Select a menu :', 'alothemes'),
                            "param_name"    => 'menu',
                            "value"         => $this->get_nav_menus(),
                            'group'         => __( 'Settings', 'alothemes' ),
                            'save_always'   => true,
                        ),
                        array(
                                "type"          => "textfield",
                                "heading"       => __("Maximal Depth : ", 'alothemes'),
                                "param_name"    => "depth",
                                "value"         => "0",
                                'group'         => __( 'Settings', 'alothemes' ),
                                'save_always'   => true,
                        ),
                        array(
                            "type"          => "dropdown",
                            "heading"       => __('Use in Mobile :', 'alothemes'),
                            'description'   => __('Add menu to mobile version.', 'alothemes'),
                            "param_name"    => 'mobile',
                            "value"         => $this->bool($type ="", $defaut = 1),
                            'group'         => __( 'Settings', 'alothemes' ),
                            'save_always'   => true,
                        ),

		            );
        $params = array_merge($temp, $this->get_templates());
        $name = 'Magiccart Menu ' . ucfirst($this->_class);
        $shortcode = 'magiccart_' . strtolower($this->_class);
        $this->add_VcMap($params,  $name, $shortcode);
    }

}

