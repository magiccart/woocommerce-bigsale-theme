<?php
namespace Magiccart\Core\Controller;

class Action{
    protected $_template = "";
    protected $_data = array();
    protected $_dirModule;
    protected $_dirTemplate;
    public function __construct(){
       $this->getModule();
    }
    protected function dirTemplate(){
        if(!$this->_dirTemplate){
            $tmp = (is_admin()) ?  'adminhtml' : 'frontend';
            $this->_dirTemplate = $this->getModule() . '/view/' .$tmp .'/templates/';
        }
        return $this->_dirTemplate;
    }
    
    protected function getModule(){
        if(!$this->_dirModule){
            $tmp = explode('\\', get_class($this));
            $this->_dirModule = MAGICCART_DIR  . strtolower($tmp[1]);            
        } 
        return $this->_dirModule;
    }
    
    public function addData($data){
        if(is_array($data)){
           $this->_data = array_merge($this->_data, $data);
        }
    }
   
    public function getData($key = ""){
       if(!$key) return $this->_data;
       
       return (isset($this->_data[$key])) ? $this->_data[$key] : null; 
    } 
    
    public function toHtml(){
        $fileTheme = get_stylesheet_directory() . " Magiccart/' " . $this->_template ;
        if(file_exists($fileTheme)){
            require_once $fileTheme;
        }else{
            require_once  $this->dirTemplate() . $this->_template;
        }
    }
    
    public function get_url($link){
    	$tmp = explode('\\', get_class($this));
    	return  plugins_url() . '/Magiccart/' . $tmp[1] . '/view/' . $link;
    }
    
    protected function setTemplate($file){
        $this->_template =  $file ;
    }

    protected function getTemplate(){
        return $this->_template;
    }
    protected function getOptions($key = ''){
        $opt = "";
        $template = get_option('stylesheet');
        $opt = $template . "_options";
        if(trim($key) != '' ){
            return $GLOBALS[$opt][$key];
        }
        return $GLOBALS[$opt];
    }
    
}
