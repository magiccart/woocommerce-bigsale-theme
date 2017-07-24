<?php
namespace Magiccart\Composer\Controller;

use Magiccart\Composer\Block\CreateTypeComposer;
use Magiccart\Composer\Controller\Adminhtml\Index;
use Magiccart\Core\Controller\Action;
use Magiccart\Composer\Block\Product\Categories;
use Magiccart\Composer\Block\Product\Products;
use Magiccart\Composer\Block\Product\Catalog;
			
 class Composer extends Action{
 	protected $_indexVc;
 	protected $_indexShort;
    public function __construct( ){
     	 new CreateTypeComposer();
         add_action('wp_enqueue_scripts', array($this, 'add_fontend_web'));
         
         if(!is_admin()){
         	new \Magiccart\Composer\Controller\Index ;
         }else{
         	new \Magiccart\Composer\Controller\Adminhtml\Index;
         }
         
         if(is_user_logged_in()){
            add_action("wp_ajax_magiccart_categories", array($this, 'magiccart_categories'), 5);
            add_action("wp_ajax_magiccart_products", array($this, 'magiccart_products'), 5);
            add_action("wp_ajax_magiccart_catalog", array($this, 'magiccart_catalog'), 5);
         }else{
            add_action("wp_ajax_nopriv_magiccart_categories", array($this, 'magiccart_categories'), 5);
            add_action("wp_ajax_nopriv_magiccart_products", array($this, 'magiccart_products'), 5);
            add_action("wp_ajax_nopriv_magiccart_catalog", array($this, 'magiccart_catalog'), 5);
         }
     }
     
     public function add_fontend_web(){
        wp_register_script('magicproduct', $this->get_url('frontend/web/js/magicproduct.js') , '1.0');
        wp_enqueue_script('magicproduct');

        wp_register_style('magiccart_composer', $this->get_url('frontend/web/css/magiccart_composer.css'));
        wp_enqueue_style('magiccart_composer');

        wp_register_script('masonry.pkgd.min', $this->get_url('frontend/web/js/masonry.pkgd.min.js') );
        wp_enqueue_script('masonry.pkgd.min');
     }

    public function magiccart_categories(){
        $cat = new Categories();
        echo $cat->get_products();
        die();
    }

    public function magiccart_products(){
        $product = new Products();
        echo $product->get_products();
        die();
    }

    public function magiccart_catalog(){
        $catalog = new Catalog();
        echo $catalog->get_products();
        die();
    }
 }
