<?php
namespace Magiccart\Core\Block;
use Magiccart\Core\Block\Html;

class Template extends Html{
    protected $_class="";
    protected $_template = "";
    protected $_data = array();
    protected $_dirModule;
    protected $_dirTemplate;
    public function __construct(){
        $this->_class = strtolower((new \ReflectionObject($this))->getShortName());
        $this->_template = $this->_class . '.phtml';
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
            $this->_dirModule = MAGICCART_DIR  . $tmp[1];            
        } 
        return $this->_dirModule;
    }
    
    public function addData($data){
        if(is_array($data)){
           $this->_data = array_merge($this->_data, $data);
        }
    }

    public function nullData(){
         $this->_data = array();
    }
   
    public function getData($key = ""){
       if(!$key) return $this->_data;
       
       return (isset($this->_data[$key])) ? $this->_data[$key] : null; 
    } 
    
    public function toHtml($do=true){
        if($do){
            ob_start();
        }
            $fileTheme = get_stylesheet_directory() . " Magiccart/' " . $this->_template ;
            if(file_exists($fileTheme)){
                include $fileTheme;
            }else{
                include  $this->dirTemplate() . $this->_template;
            }
        if($do){
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }
    }
    
    protected function setTemplate($file){
        $this->_template =  $file ;
    }

    protected function getTemplate($file){
        return $this->_template;
    }
    
    public function getInclude(){
        $fileTheme = get_stylesheet_directory() . " Magiccart/' " . $this->_template ;
        if(file_exists($fileTheme)){
            return $fileTheme;
        }else{
            return  $this->dirTemplate() . $this->_template;
        }
    }
    
    public function get_options($key = ''){
        $opt = "";
        $template = get_option('stylesheet');
        $opt = $template . "_options";
        if(trim($key) != '' ){
            if(isset($GLOBALS[$opt][$key])){
                return $GLOBALS[$opt][$key];
            }else{
                $options = get_option($opt, array());
                if(isset($options[$key])){
                    return $options[$key];
                }else{
                    echo "$key not isset";
                }
            }
        }
        if(isset($GLOBALS[$opt])){
            return $GLOBALS[$opt];
        }else{
            return get_option($opt, array());
        }
    }
}