<?php
namespace Magiccart\Magicslider\Block\Adminhtml\Slider;
use Magiccart\Magicslider\Model\Collection;

 class Grid{
    public $_items;
    public function __construct(){
        
        $collection = new Collection();
        
        $this->_items            = $collection->getGroupSlider();
        
        $this->_template = ABSPATH . 'wp-content/plugins/Magiccart/Magicslider/view/adminhtml/templates/gird.phtml';
    }
    
     public function setTemplate($template){
        if($template) return;
        
        $fileTheme = get_stylesheet_directory() . " Magiccart/' " . $template ;
        if(!file_exists($fileTheme)) $fileTheme = ABSPATH . 'wp-content/plugins/Magiccart/' . $template ;
        $this->_template = $fileTheme;

    }
    public function toHtml(){
        require_once $this->_template;
    }

    public function getTemplate(){
        return $this->_template;
    }
}