<?php
namespace Magiccart\Composer\Block\Product;
use Magiccart\Composer\Block\Shortcode;

class Products extends Shortcode{
    // **********************************************************************//
    // aloThemes Product
    // **********************************************************************//
    public function initShortcode( $atts, $content = null ){
        global $woocommerce;
        if(!$woocommerce)  return '';
        $this->nullData();
        $this->addData(array_merge(  $this->defaultProduct(), $atts ) );
    
        if($this->getData('product_collection')){
            $productCollection          = explode(',', $this->getData('product_collection'));
            
            $this->addData(array('product_collection' => $productCollection));
            if($this->getData('ajax_load') != "no"){
                $temp = array();
                $key = array_search($this->getData('product_activated'), $productCollection) ;
                if(!$key){
                    $this->addData(array('product_activated' => $productCollection[0]));
                }
                $temp[] = $productCollection[$key];
                $productCollection = $temp;
            }else{
                $key = array_search($this->getData('product_activated'), $productCollection) ;
                if($key){
                    $this->addData(array('product_activated' => $productCollection[0]));
                }
            }
            $this->_products = array();
            foreach ($productCollection as $type){
                $this->_products[$type] = $this->_collection->woo_query($type,$this->getData('number'));
            }
            return $this->toHtml();
        }
        
        return __("Please select !", 'alothemes');
    }
    
    public function defaultProduct(){
    	$types = $this->get_type();
    	$categories = $this->_vcComposer->get_arr_category();
    	$type = array_flip(array_slice($types, 0, 1));
    	$type = implode($type, '');
    
    	$catRelated = array_flip(array_slice($categories, 0, 5));;
    	$catRelated = implode($catRelated, ',');
    
    	$default = array(
    			'default'           => $type,
    			'categories_related'=> $catRelated,
    	);
    	return $default;
    }
    
    private function get_type($type_default = "key"){
    	$type = $type_default;
    	$arrType = array(
    			__('Best Selling', 'alothemes')      => 'best_selling',
    			__('Featured Products', 'alothemes') => 'featured_product',
    			__('Top Rate', 'alothemes')          => 'top_rate',
    			__('Recent Products', 'alothemes')   => 'recent_product',
    			__('On Sale', 'alothemes')           => 'on_sale',
    			__('Recent Review', 'alothemes')     => 'recent_review',
    			__('Product Deals', 'alothemes')     => 'deals'
    	);
    	if($type == "key") return $arrType;
    
    	return array_flip($arrType);
    } 
}