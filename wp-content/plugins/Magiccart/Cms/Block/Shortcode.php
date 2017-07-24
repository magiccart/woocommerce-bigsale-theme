<?php
namespace Magiccart\Cms\Block;
class Shortcode {
    public function __construct(){
        if(!shortcode_exists('magiccartBlock')){
            add_shortcode('magiccartBlock', array($this, 'shortcodeEditor') );
        }
    }
    public function shortcodeEditor($text){
        if (!isset($text['text']) || !$text['text']) return ;
        $value   = get_option('magiccart_block', '');
        $value   = json_decode($value, true);
        $text    = $text['text'];
        if(isset($value[$text]['value'])){
            if($value[$text]['status']){
                $editorText = $value[$text]['value'];
                print_r(wp_kses_post( $editorText));
            }else{
                echo '';
            }
        }
    }
}


