<?php
namespace Magiccart\Composer\Block;
use Magiccart\Core\Block\Template;
use Magiccart\Composer\Model\Product\Collection;
use Magiccart\Composer\Model\Vccomposer;

class Shortcode extends Template{
    protected $_products = array();
    protected $_collection;
    protected $_vcComposer;
    protected $_post = array();
    protected $_brands = array();
    protected $_sliders = array();
    protected $_testimonial = array();
    protected $_portfolio = array();

    public function __construct(){
        parent::__construct();
        $this->_collection = new Collection();
        $this->_vcComposer = new Vccomposer();
        $nameShortcode = 'magiccart_' . $this->_class;
        add_shortcode($nameShortcode, array($this, 'initShortcode'));

    }

    public function get_type_name($key){
        $arrType = array(
            __('Best Selling', 'alothemes')      => 'best_selling',
            __('Featured Products', 'alothemes') => 'featured_product',
            __('Top Rate', 'alothemes')          => 'top_rate',
            __('Recent Products', 'alothemes')   => 'recent_product',
            __('On Sale', 'alothemes')           => 'on_sale',
            __('Recent Review', 'alothemes')     => 'recent_review',
            __('Product Deals', 'alothemes')     => 'deals'
        );
    
        $arrType = array_flip($arrType);
        return $arrType[$key];
    }

    // **********************************************************************//
    // arr Default
    // **********************************************************************//
   /* protected function get_default(){
    	$default =  array(
			            'number'            => '4',
			            'category'          => '',
			            'type'              => 'best_selling',
			            'speed'             => '300',
			            'autoplay-speed'    => '3000',
			            'padding'           => '15',
                        'autoplay'          => 'true',
                        'arrows'            => 'true',
                        'dots'              => 'false',
                        'infinite'          => 'true',
                        'cart'              => 'yes',
                        'compare'           => 'yes',
                        'wishlist'          => 'yes',
                        'review'            => 'yes',
                        'slide'             => 'yes',
                        'vertical'          => 'false',

			        );
        return $default;
    }*/
    
    public function initShortcode($atts, $content = null ){
    	// NULL
    }
   
    protected function get_name_category($parent_id = ""){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => $parent_id,
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        return $categories = get_categories( $args );
    }
    
    public function getOptions(){

        if(isset($_GET['visible'])) $this->addData(array('visible' => $_GET['visible'])); // USED DEMO 

    	$arrResponsive = array(1201=>'visible', 1200=>'desktop', 992=>'notebook', 768=>'tablet', 641=>'landscape', 481=>'portrait', 361=>'mobile');
    	$settings = array();
    	$settings['padding'] = $this->getData('padding');  	 
    	$total   = count($arrResponsive);
    	if($this->getData('slide') == 'yes'){
    		$options = array(
    				'autoplay',
    				'arrows',
    				'dots',
    				'infinite',
    				'padding',
    				'responsive' ,
    				'rows',
    				//'vertical-swiping',
    				//'swipe-to-slide',
    				'autoplay-speed',
    				//'slides-to-show'
    				'vertical',
    		);
    		
    		foreach ($options as $value){
    			$settings[$value] = $this->getData( $value );
    		}
    		$settings['vertical-swiping'] = $this->getData('vertical');
    		$settings['slides-to-show']   = $this->getData('visible');
    		$settings['swipe-to-slide']   = 'true';
    		
    		$responsive = '[';
    		foreach ($arrResponsive as $size => $screen) {
    			$responsive .= '{"breakpoint": "'.$size.'", "settings":{"slidesToShow":"'.$this->getData($screen).'"}}';
    			if($total-- > 1) $responsive .= ', ';
    		}
    		$responsive .= ']';
    		$settings['responsive']         = $responsive;
 
    	}else{   		
    		$responsive = '[["'. $this->getData('mobile') .'"],';
    		ksort($arrResponsive);
    		foreach ($arrResponsive as $size => $screen) {
    			$size -= 1;
    			$responsive .= '{"'.$size.'":"'.$this->getData($screen).'"}';
    			if($total-- > 1) $responsive .= ',';
    		}
    		$responsive .= ']';
    		$settings['responsive'] = $responsive;
    	}
    	return $settings;
    }

    public function getCategoriesByIdKey($ids){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => '',
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        $categories = get_categories( $args );

        $arrCategories = explode(',', $ids);

        $keyCat = '';
        foreach ($categories as $key => $value) {
            foreach ($arrCategories as $ky => $val) {
                if($value->cat_ID == $val){
                    $keyCat .= $value->slug . ',';
                }
            }
        }
        return $keyCat;
    }

    public function getCategoriesByIdName($ids, $arr = true){
        $args = array(
            'type'          => 'post',
            'child_of'      => 0,
            'parent'        => '',
            'orderby'       => 'id',
            'order'         => 'ASC',
            'hide_empty'    => false,
            'hierarchical'  => 1,
            'exclude'       => '',
            'include'       => '',
            'number'        => '',
            'taxonomy'      => 'product_cat',
            'pad_counts'    => false,
    
        );
        $categories = get_categories( $args );

        $arrCategories = explode(',', $ids);

        $nameCat = '';
        foreach ($categories as $key => $value) {
            foreach ($arrCategories as $ky => $val) {
                if($arr == true){
                    if($value->cat_ID == $val){
                        $nameCat[$value->slug] = $value->name ;
                    }
                }else{
                    if($value->cat_ID == $val){
                        $nameCat .= $value->name;
                    }
                }
            }
        }
        return $nameCat;
    }

    public function get_products(){
        $type = (new \ReflectionObject($this))->getShortName();
        $post = $_POST;
        define( 'DOING_AJAX', true);
        $this->addData(array('cart'     => $post["info"]['cart']));
        $this->addData(array('compare'  => $post["info"]['compare']));
        $this->addData(array('wishlist' => $post["info"]['wishlist']));
        $this->addData(array('review'   => $post["info"]['review']));
        $this->addData(array('number'   => $post["info"]['number']));
        $this->addData(array('lazy'     => $post["info"]['lazy']));

        $this->_products = array();

        if($type == "Categories"){
            $this->addData(array('type' => $post["info"]['filter']));

            $this->_products[$post['type']] = $this->_collection->woo_query($this->getData('type'),$this->getData('number'), $post['type']);
            
            foreach($this->_products as $key => $collection){
                include ABSPATH . 'wp-content/plugins/Magiccart/Composer/view/frontend/templates/categories/grid.phtml';
            }
        }else if($type == 'Products'){
            $this->_products[$post['type']] = $this->_collection->woo_query($post['type'],$this->getData('number'));
            
            foreach($this->_products as $key => $collection){
                include ABSPATH . 'wp-content/plugins/Magiccart/Composer/view/frontend/templates/products/grid.phtml';
            }
        }else if($type == 'Catalog'){
            $typeFilter = array("best_selling", 'featured_product', 'top_rate', 'recent_product', 'on_sale', 'recent_review', "deals");
            if(in_array($post['type'], $typeFilter)){
                
                $this->_products[$post['type']] = $this->_collection->woo_query($post['type'],$this->getData('number'), $post['info']['filter'] );
            }else{
                $this->_products[$post['type']] = $this->_collection->woo_query("",$this->getData('number'), $post['type']);
            }
            foreach($this->_products as $key => $collection){
                include ABSPATH . 'wp-content/plugins/Magiccart/Composer/view/frontend/templates/catalog/grid.phtml';
            }
        }
    }
}

