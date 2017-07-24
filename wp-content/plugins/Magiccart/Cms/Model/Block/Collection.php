<?php
namespace Magiccart\Cms\Model\Block;

class Collection{
    public $_per_page = 15;
    public function __construct(){
    }
    
    /* Get Data ArrBlock */
    public function getDataBlock(){
        $data           = array();
        $arrSearch      = array();
        $arrBlock       = get_option('magiccart_block', '');
        $arrBlock       = json_decode($arrBlock, true);
    
        $paged          = isset($_GET['paged']) ? $_GET['paged'] : 1;
        $offset         = ($paged - 1) * $this->_per_page;
    
        // Search
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 1){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($arrBlock as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $arrSearch[$key] = $value;
                    }
                }
                $arrBlock = $arrSearch;
            }
        }
        
        if(is_array($arrBlock)){
            $arrBlock  = array_slice($arrBlock, $offset, $this->_per_page);
             
            $i = $offset;
            foreach($arrBlock as $key => $value){
                $data_menu['name']      = $value['name'];
                $data_menu['value']     = $value['value'];
                $data_menu['status']    = $value['status'];
                $data_menu['key']       = $key;
                $data_menu['stt']       = $i;
                $data[]                 = $data_menu;
                $i++;
            }
        }
        return $data;
    }
    
    /* Count Block */
   public function totalBlock(){
        $arrSearch= array();
        $arrBlock = get_option('magiccart_block', array());
        $arrBlock = json_decode($arrBlock, true);
        // Search
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 1){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($arrBlock as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $arrSearch[$key] = $value;
                    }
                }
                $arrBlock = $arrSearch;
            }
        }
        return count($arrBlock);
    }   
}