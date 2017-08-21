<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 15:44:56
 * @@Modify Date: 2017-08-13 21:19:42
 * @@Function:
 */
 
namespace Magiccart\Composer\Block\Adminhtml\Vc\Post;
use Magiccart\Composer\Block\Adminhtml\Vc;

class Testimonial extends Vc{

    public function initMap(){
        $temp = array(
	                array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Avatar :', 'alothemes'),
                        'param_name'    => 'avatar',
                        'value'         => $this->bool($type ="yn", $defaut = 1),
                        'save_always'   => true,
                    ),
                    array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Content :', 'alothemes'),
                        'param_name'    => 'content',
                        'value'         => $this->bool($type ="yn", $defaut = 1),
                        'save_always'   => true,
                    ),
                    array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Name :', 'alothemes'),
                        'param_name'    => 'name',
                        'value'         => $this->bool($type ="yn", $defaut = 1),
                        'save_always'   => true,
                    ),
                    array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Company :', 'alothemes'),
                        'param_name'    => 'company',
                        'value'         => $this->bool($type ="yn", $defaut = 0),
                        'save_always'   => true,
                    ),
                    array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Email :', 'alothemes'),
                        'param_name'    => 'email',
                        'value'         => $this->bool($type ="yn", $defaut = 0),
                        'save_always'   => true,
                    ),
                    array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Website :', 'alothemes'),
                        'param_name'    => 'website',
                        'value'         => $this->bool($type ="yn", $defaut = 0),
                        'save_always'   => true,
                    ),
                    array(
                        'type'          => "dropdown",
                        'heading'       => __('Show Rating :', 'alothemes'),
                        'param_name'    => 'rating',
                        'value'         => $this->bool($type ="yn", $defaut = 0),
                        'save_always'   => true,
                    ),
            	);
        $params = array_merge(
            $temp, 
            $this->get_settings(), 
            $this->get_responsive(),
            $this->get_templates()
        );
        
        $this->add_VcMap($params);
    }
}

