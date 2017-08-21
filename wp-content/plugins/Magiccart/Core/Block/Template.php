<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-07-24 12:11:00
 * @@Modify Date: 2017-08-15 21:54:14
 * @@Function:
 */
 
namespace Magiccart\Core\Block;
use Magiccart\Core\Block\Html;

class Template extends Html{
    protected $_class="";
    protected $_template = "";
    protected $_data = array();
    protected $_dirModule;
    protected $_dirTemplate;
    public function __construct(){
        // echo get_class($this);
        $this->_class = strtolower((new \ReflectionObject($this))->getShortName());
        $this->_template = $this->_class . '.phtml'; //$this->_class . '.phtml';
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
    
    public function toHtml(){

        $fileName = $this->getTemplateFile();
        $html = $this->fetchView($fileName);
        return $html;
    }

    /**
     * Get absolute path to template
     *
     * @return string
     */
    public function getTemplateFile($_template='')
    {
        if(!$_template){
            if($this->getData('template')) $this->_template = $this->getData('template');
            $_template = $this->_template;      
        }
        $class = explode('\\', get_class($this));
        $templateName = get_stylesheet_directory() . '/' . $class[0] . '_' .$class[1] . '/templates/' . $_template ;
        if(!file_exists($templateName)){
            $templateName = get_template_directory() . '/' . $class[0] . '_' .$class[1] . '/templates/' . $_template ;
            if(!file_exists($templateName)){
                $templateName = $this->dirTemplate() . $_template;
            }
        }
        return $templateName;
    }

    /**
     * Retrieve block view from file (template)
     *
     * @param   string $fileName
     * @return  string
     */
    public function fetchView($fileName, $do=true)
    {
        if($do){
            ob_start();
        }
            if(!file_exists($fileName)){
                // $error = new \WP_Error( 'broke', __( "File $this->_template not exist", "alothemes" ) );
                // return $error->get_error_message();
                return '<div class="message error woocommerce-error">' . __( "File $this->_template not exist", "alothemes" ) . '</div>';
            }
            if ($this->getShowTemplateHints()) {
                echo '<div style="position:relative; border:1px dotted red; margin:6px 2px; padding:18px 2px 2px 2px; zoom:1;"><div style="position:absolute; left:0; top:0; padding:2px 5px; background:red; color:white; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="'.$fileName.'">'.$fileName.'</div>';
                $thisClass = (is_object($this)) ? get_class($this) : '';
                if($thisClass) {
                    echo '<div style="position:absolute; right:0; top:0; padding:2px 5px; background:red; color:blue; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="' .$thisClass. '">' .$thisClass. '</div>';

                }
       
            }

            include $fileName;

            if ($this->getShowTemplateHints()) {
                echo '</div>';
            }

        if($do){
            $content = ob_get_contents();
            ob_end_clean();
            return $content;
        }      
    }

    public function getShowTemplateHints(){
        return defined('TEMPLATEDHINTS');
    }
    
    protected function setTemplate($file){
        $this->_template =  $file ;
    }

    protected function getTemplate(){
        return $this->_template;
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
