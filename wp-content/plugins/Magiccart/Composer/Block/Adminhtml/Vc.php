<?php 
namespace Magiccart\Composer\Block\Adminhtml;

use Magiccart\Composer\Model\Vccomposer;
class Vc {
	protected $_vcSetting = array();
    protected $_productCategories; // List arr Category
    protected $_parent; // List Parent Category
    
    public function __construct(){
    	add_action('init', array($this, 'initMap'), 99);
    }
    
    // **********************************************************************//
    // add Vc
    // **********************************************************************//
	public function initMap()
	{
		$params =array();
		$this->add_VcMap($params);
	}
    protected function add_VcMap($params){
    	
		//     	$namespace = (new \ReflectionObject($this))->getNamespaceName();
		//     	$name = str_replace($namespace. '\\','', get_class($this) );
    	$name = (new \ReflectionObject($this))->getShortName();
    	$this->_vcSetting = array(
    			"name"           => __("Magiccart {$name}", 'alothemes'),
    			'base'           => "magiccart_" . strtolower($name),
    			"category"       => __('Magiccart','alothemes'),
                "is_container"   => false,
    			"params"	     => $params,
                "icon"           =>  get_template_directory_uri() . "/images/logo.png",
                'show_settings_on_create' => false,

    	);
        vc_map($this->_vcSetting);
    }
    
    // **********************************************************************//
    // List Parent Category
    // **********************************************************************//
    protected function getArrParentCat(){
        $vcComposer = new Vccomposer();
        return $vcComposer->get_parent_category();
    }
    
    // **********************************************************************//
    // List arr Category
    // **********************************************************************//
    protected function getCategories(){
        $vcComposer = new Vccomposer();
        return $vcComposer->get_arr_category();
    }

    // **********************************************************************//
    // List Slider
    // **********************************************************************//
    protected function getSlider(){
        $vcComposer = new Vccomposer();
        return $vcComposer->getSlider();
    }

    // **********************************************************************//
    // Type Posts
    // **********************************************************************//
    protected function getTypePosts(){
    	$arrType = array(
            __('Date', 'alothemes')     => 'date',
            __('Author', 'alothemes') 	=> 'author',
            __('Title', 'alothemes')  	=> 'title',
    		__('Modified', 'alothemes') => 'modified',
    		__('Rand', 'alothemes') 	=> 'rand',
    		__('Comment', 'alothemes')  => 'comment_count',
        );
    	return $arrType;
    }
    
        /* Categories */
        function magiccart_category_portfolio(){
          $args = array(
              'type'          => 'portfolio',
              'child_of'      => 0,
              'parent'        => '',
              'orderby'       => 'id',
              'order'         => 'ASC',
              'hide_empty'    => false,
              'hierarchical'  => 1,
              'exclude'       => '',
              'include'       => '',
              'number'        => '',
              'taxonomy'      => 'portfolio_category',
              'pad_counts'    => false,

          );
          $categories = get_categories( $args );
          $portfolioCategories = array();
          $portfolioCategories["all"] = "All Category";
          foreach ($categories as  $value) {
              $portfolioCategories[$value->term_id] = $value->name;
          }
          return $portfolioCategories;
        }

    // **********************************************************************//
    // Bool
    // **********************************************************************//
    protected function bool($type ="yn", $defaut = 0, $flip = true){
        $bool = array();
        if($type == "yn"){
            if(!$defaut){
                $bool = array(
                    'no'  => __('No', 'alothemes'),
                    'yes' => __('Yes', 'alothemes'),
                );
            }else{
                $bool = array(
                    'yes' => __('Yes', 'alothemes'),
                    'no'  => __('No', 'alothemes'),
                );
            }
        }else{
            if(!$defaut){
                $bool = array(
                    'false' => __('False', 'alothemes'),
                    'true'  => __('True', 'alothemes'),
                );
            }else{
                $bool = array(
                    'true'  => __('True', 'alothemes'),
                    'false' => __('False', 'alothemes'),
                );
            }
        }
        if($flip){
            return array_flip($bool);
        }
        return $bool;
    }
    
    protected function get_type($type_default = "key"){
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
    
    // **********************************************************************//
    // get_item_per_column
    // **********************************************************************//
    protected function get_rows($row = 4, $flip=true){
        $option = array();
    
        for($i = 1; $i < $row; $i++){
            $option[$i] = $i . __(' row(s)', 'alothemes');
        }
        if($flip){
            return array_flip($option);
        }
        return $option;
    }
    
    // **********************************************************************//
    // get_item_per_column
    // **********************************************************************//
    protected function get_item_per_rows($item = 10, $flip=true){
        $perRows = array();
        for($i = 1; $i < $item; $i++){
            $perRows[$i] = $i . __(' item(s) /row', 'alothemes');
        }
       
       if($flip){
            return array_flip($perRows);
       }
        return $perRows;
    }
    
    // **********************************************************************//
    // get_params settings
    // **********************************************************************//
    protected function get_settings(){
        /* New Obj Vccomposer */
        $vcComposer = new Vccomposer();
        $get_item_per_rows = $this->get_item_per_rows();
        $settings = array(
        	array(
        			"type"          => "textfield",
        			"heading"       => __("Number of posts to show : ", 'alothemes'),
        			"param_name"    => "number",
        			"value"         => "4",
                    'group'         => __( 'Settings', 'alothemes' ),
                    'save_always'   => true,
        	),
            array(
                "type"          => "dropdown",
                "heading"       => __('Timer :', 'alothemes'),
                "param_name"    => 'timer',
                "value"         => $this->bool($type ="yn"),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Slide :', 'alothemes'),
                "param_name"    => 'slide',
                "value"         => $this->bool($type ="yn", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Slider Vertical :', 'alothemes'),
                "param_name"    => 'vertical',
                "value"         =>  $this->bool($type ="tf", $defaut = 0),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Infinite :', 'alothemes'),
                "param_name"    => 'infinite',
                "value"         => $this->bool($type ="tf", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Auto Play :', 'alothemes'),
                "param_name"    => 'autoplay',
                "value"         => $this->bool($type ="tf", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Arrows :', 'alothemes'),
                "param_name"    => 'arrows',
                "value"         => $this->bool($type ="tf", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Dots :', 'alothemes'),
                "param_name"    => 'dots',
                "value"         => $this->bool($type ="tf", $defaut = 0),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Rows :', 'alothemes'),
                "param_name"    => 'rows',
                "value"         => $this->get_rows(),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "textfield",
                "heading"       => __("Speed <span style='color:red;'>*</span> :", 'alothemes'),
                "param_name"    => "speed",
                "value"         => "300",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "textfield",
                "heading"       => __("AutoPlay Speed <span style='color:red;'>*</span> :", 'alothemes'),
                "param_name"    => "autoplay-speed",
                "value"         => "3000",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "textfield",
                "heading"       => __("Padding <span style='color:red;'>*</span> :", 'alothemes'),
                "param_name"    => "padding",
                "value"         => "15",
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Max-Width 360 : ', 'alothemes'),
                "param_name"    => 'mobile',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Max-Width 480 : ', 'alothemes'),
                "param_name"    => 'portrait',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Max-Width 640 : ', 'alothemes'),
                "param_name"    => 'landscape',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 1,
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Max-Width 767 : ', 'alothemes'),
                "param_name"    => 'tablet',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 2,
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Max-Width 991 : ', 'alothemes'),
                "param_name"    => 'notebook',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 3,
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Max-Width 1199 : ', 'alothemes'),
                "param_name"    => 'desktop',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 4,
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Min-Width 1200 : ', 'alothemes'),
                "param_name"    => 'visible',
                "value"         => $get_item_per_rows,
                'group'         => __( 'Responsive', 'alothemes' ),
                'std'           => 4,
                'save_always'   => true,
            ),
           /* array(
                'type'          => 'css_editor',
                'param_name'    => 'css',
                'group'         => __( 'Design options', 'alothemes' ),
                'admin_label'   => false,
            ),*/
        );
        return $settings;
    }   

    public function countTime(){
        $downTime = array(
                        array(
                            "type"          => "date",
                            "heading"       => __('Countdown Time :', 'alothemes'),
                            "param_name"    => 'date',
                            'group'         => __( 'Settings', 'alothemes' ),
                        ),
                    );
        return $downTime;
    }

    public function settingShow(){
        $settings = array(
            array(
                "type"          => "dropdown",
                "heading"       => __('Show Cart :', 'alothemes'),
                "param_name"    => 'cart',
                "value"         => $this->bool($type ="yn", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Show Compare :', 'alothemes'),
                "param_name"    => 'compare',
                "value"         => $this->bool($type ="yn", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Show Wishlist :', 'alothemes'),
                "param_name"    => 'wishlist',
                "value"         => $this->bool($type ="yn", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Show Review :', 'alothemes'),
                "param_name"    => 'review',
                "value"         => $this->bool($type ="yn", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
            array(
                "type"          => "dropdown",
                "heading"       => __('Ajax :', 'alothemes'),
                "param_name"    => 'ajax_load',
                "value"         => $this->bool($type ="yn", $defaut = 1),
                'group'         => __( 'Settings', 'alothemes' ),
                'save_always'   => true,
            ),
        );
        return $settings;
    }
    
    public function defaultBlock(){
    	$vcComposer = new Vccomposer();
    	$settings = array(
    			array(
    					"type"          => "dropdown",
    					"heading"       => __("Block Left :", 'alothemes'),
    					"param_name"    => "shortcode_left",
    					"value"         => $vcComposer->getBlock(),
                        'save_always'   => true,
    			),
    			array(
    					"type"          => "dropdown",
    					"heading"       => __("Block Bottom :", 'alothemes'),
    					"param_name"    => "shortcode_bottom",
    					"value"         => $vcComposer->getBlock(),
                        'save_always'   => true,
    			),
    	);
    	return $settings;
    }
}