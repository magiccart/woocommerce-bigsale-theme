<?php
namespace Magiccart\Magicslider\Model;

class Collection{
    public function __construct(){
    }
    
    /* Get Data ArrBlock */
    public function getGroupSlider(){
        $groups     = get_option('magiccart_slider', '');
        $groups     = json_decode($groups, true);

        $temp = array();
         
        if(is_array($groups)){
            foreach ($groups as $key => $value) {
                $temp[$key]['name']     = $value['name'];
                $temp[$key]['total']    = count($value['value']);
                $firstItem              = array_slice($value['value'], 0, 1);
                foreach ($firstItem as $value) {
                    $temp[$key]['avatar']   = $value['src'];
                }
            }
        }
        $groups = $temp;
        
        return $groups;
    }   
}