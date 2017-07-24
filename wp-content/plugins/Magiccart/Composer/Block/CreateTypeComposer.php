<?php
namespace Magiccart\Composer\Block;
class CreateTypeComposer
{
    public function __construct(){
        vc_add_shortcode_param( 'multi_select', array($this, 'multiSelectCreate' ));
        
       /* vc_add_shortcode_param( 'color', array($this, 'color' ));*/
        vc_add_shortcode_param( 'date', array($this, 'date' ));
    }
    
    // **********************************************************************//
    // add type multi select
    // **********************************************************************//
    public function multiSelectCreate( $settings, $value ) {
        ?>
            <style>
                .wp-admin select[multiple] {width: 300px; height: 140px;}
            </style>
        <?php 
        $xhtml = '';
        
        $arrType = explode(',', $value);
    
        foreach($settings['value'] as $key => $val){
    
            if(in_array($key, $arrType)){
                $xhtml .= '<option value="'.$key.'" selected >' . $val . '</option>';
            }else{
                $xhtml .= '<option value="'.$key.'"  >' . $val . '</option>';
            }
        }
    
        return '<div class="my_param_block">'
            .'<select name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-input wpb-select style dropdown list' .
            esc_attr( $settings['param_name'] ) . ' ' .
            esc_attr( $settings['type'] ) . '_field" multiple>' . $xhtml
            . '</select> </div>';
    }
    
    
    // **********************************************************************//
    // add type color
    // **********************************************************************//
    public function color( $settings, $value ) {
        return '<div class="my_param_block">'
            .'<input value="'. $value .'" style="height: 40px;width: 200px;" type="color" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
            esc_attr( $settings['param_name'] ) . ' ' .
            esc_attr( $settings['type'] ) . '_field"'
            . '/> </div>';
        
       
    }

    // **********************************************************************//
    // add type time
    // **********************************************************************//
    public function date( $settings, $value ) {
        
        return '<div class="my_param_block">'
            .'<input value="'. $value .'" style="height: 40px;width: 200px;" type="date" name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
            esc_attr( $settings['param_name'] ) . ' ' .
            esc_attr( $settings['type'] ) . '_field"'
            . '/> </div>';
       
    } 
}



