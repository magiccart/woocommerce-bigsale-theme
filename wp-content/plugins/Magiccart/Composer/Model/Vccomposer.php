<?php
namespace Magiccart\Composer\Model;

class Vccomposer{
    
    // **********************************************************************//
    // get Category + parent-child category
    // **********************************************************************//
    public function getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {
        for ( $i = $pos; $i < count( $array ); $i ++ ) {
            if ( $array[ $i ]->category_parent == $parent_id ) {
                $name = str_repeat( '- ', $level ) . $array[ $i ]->name;
                $value = $array[ $i ]->cat_ID;
                $dropdown[] = array(
                    'label' => $name,
                    'value' => $value,
                );
                $this->getCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
            }
        }
    }
    
    // **********************************************************************//
    // get_arr value category
    // **********************************************************************//
    public function get_arr_category(){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => '',
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        $categories = get_categories( $args );
        /*echo "<pre>";
        print_r($categories);
        echo "</pre>";*/
        $product_categories_dropdown = array();
        $product_categories = array();
        $this->getCategoryChildsFull( 0, 0, $categories, 0, $product_categories_dropdown );


        foreach($product_categories_dropdown as $value){
            $product_categories[$value['value']] = $value['label'];
        }
       
        return $product_categories;
    }

    // **********************************************************************//
    // Get Block
    // **********************************************************************//
    function getBlock(){
        $arrBlock   = array();
        $arrBlock[] = '-- Please select a static block --';
        $blocks     = get_option('magiccart_block', '');
        $blocks     = json_decode($blocks, true);
        
        if(is_array($blocks)){
            foreach($blocks as $key => $value){
                if($value['status']) $arrBlock[$key] = $value['name'];
            }
        }
        return array_flip($arrBlock);
    }
    
    // **********************************************************************//
    // get parent category
    // **********************************************************************//
    public function get_parent_category(){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => '',
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        $parent = array();
        $parent['-- Select --'] = "";
        $categories = get_categories( $args );
        
        foreach ($categories as $value){
            if($value->parent == 0){
                $parent[ $value->name ] = $value->term_id;
            }
        }
        return $parent;
    }

    // **********************************************************************//
    // Get Slider
    // **********************************************************************//
    public function getSlider(){
        $optionSlider                  = get_option('magiccart_slider', '');
        $optionSlider                  = json_decode($optionSlider, true);
        $sliders                       = array();
        
        if(is_array($optionSlider)){
            foreach($optionSlider as $value){
                $sliders[$value['key-group']] = $value['name'];
            }
        }
        return $sliders;
    }
}
