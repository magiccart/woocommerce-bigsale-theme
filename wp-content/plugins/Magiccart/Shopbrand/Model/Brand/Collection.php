<?php
namespace Magiccart\Shopbrand\Model\Brand;

class Collection{
    public $_per_page = 15;
    public function __construct(){
    }
    
    /* Get Data ArrBlock */
    public function getBrands(){
        $data           = array();
        $paged          = isset($_GET['paged']) ? $_GET['paged'] : 1;
        $brands         = get_option('magiccart_brand', '');
        $brands         = json_decode($brands, true);
        $offset         = ($paged - 1) * $this->_per_page;
    
        // Search
        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 0){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($brands as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $brandSearch[$key] = $value;
                    }
                }
                $brands = $brandSearch;
            } 
        }
        
        if(is_array($brands)){
            $brands  = array_slice($brands, $offset, $this->_per_page);
         
            $i = $offset;
            foreach($brands as $key => $value){
                $dataBrand['stt']           = $i;
                $dataBrand['name']          = $value['name'];
                $dataBrand['attributes']    = $value['attr-type'];
                $dataBrand['term']          = $value['term'];
                $dataBrand['image']         = $value['img'];
                $dataBrand['status']        = $value['status'];
                $dataBrand['key']           = $key;
                
                $data[]                     = $dataBrand;
                $i++;
            }
        }
            
        return $data;
    }
    
    /* Count Block */
   public function totalBrands(){
        $brands         = get_option('magiccart_brand', '');
        $brands         = json_decode($brands, true);

        if(isset($_POST['s'])){
            if(strlen(trim($_POST['s'])) > 0){
                $strSearch = trim($_POST['s']);
                $RE = "#.*{$strSearch}.*#i";
                foreach($brands as $key => $value){
                    if(preg_match($RE, $value['name'])){
                        $brandSearch[$key] = $value;
                    }
                }
                $brands = $brandSearch;
            } 
        }
        return count($brands);
    }   
}