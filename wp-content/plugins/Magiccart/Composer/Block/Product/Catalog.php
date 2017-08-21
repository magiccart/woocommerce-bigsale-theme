<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-13 17:51:26
 * @@Modify Date: 2017-08-13 18:42:28
 * @@Function:
 */

namespace Magiccart\Composer\Block\Product;

class Catalog extends Products{

    public function initShortcode( $atts, $content = null ){
        global $woocommerce;
        $this->nullData();
        $this->addData(array_merge( $this->defaultProduct() , $atts ) );

        if(!$woocommerce)  return '';

        $categoriesName             = $this->getCategoriesByIdName($this->getData('categories'));
        $category_activated_name    = $this->getCategoriesByIdName($this->getData('category_activated'), false);
        $category_activated_slug    = $this->getCategoriesByIdKey($this->getData('category_activated'), false);
        
        
        if($this->getData('product_collection')){
            $product_collection         = explode(',', $this->getData('product_collection'));
            $this->addData(array('categoriesName' => $categoriesName));
            $this->addData(array('category_activated_name' => $category_activated_name));
            $this->addData(array('category_activated_slug' => $category_activated_slug));
            $this->addData(array('product_collection' => $product_collection));
            
            if($this->getData('ajax_load') != "no"){
                $key = array_search($this->getData('product_activated'), $product_collection) ;
                $temp[] = isset($product_collection[$key]) ? $product_collection[$key] : '';
                $product_collection = $temp;
            }else{
                $product_collection = array_merge($product_collection, $categoriesName);
            }
            
            $this->_products = array();

            $typeFilter = array("best_selling", 'featured_product', 'top_rate', 'recent_product', 'on_sale', 'recent_review', "deals");
            if(count($product_collection)){
                foreach ($product_collection as $key => $value){
                    if(in_array($value, $typeFilter)){
                        $this->_products[$value] = $this->_collection->woo_query($value, $this->getData('number'), $this->getData('category_activated_slug'));
                    }else{
                        $this->_products[$key] = $this->_collection->woo_query("", $this->getData('number'), $key);
                    }
                }
            }
            return $this->toHtml();
        }
        return __("Collection not yet select!", 'alothemes');
    }
    
    public function defaultProduct(){
    	$categories = $this->_vcComposer->get_arr_category();
    	$category = array_flip(array_slice($categories, 0, 1));
    	$category = implode($category, '');
    	 
    	$catRelated = array_flip(array_slice($categories, 0, 5));;
    	$catRelated = implode($catRelated, ',');
    	
    	$default = array(
    			'default'           => $category,
    			'categories_related'=> $catRelated,
    	);
    	return $default;
    }
}
