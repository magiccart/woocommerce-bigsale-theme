<?php
namespace Magiccart\Widgets\Controller;

use Magiccart\Widgets\Block\Product\Categories;
use Magiccart\Widgets\Block\Product\Topseller;
use Magiccart\Widgets\Block\Product\Recentreviews;

use Magiccart\Widgets\Block\Blog\Picture;
use Magiccart\Widgets\Block\Blog\Posts;
use Magiccart\Widgets\Block\Blog\Tags;
use Magiccart\Widgets\Block\Blog\Shortcode;
use Magiccart\Core\Controller\Action;


class Widgets extends Action{
	public function __construct(){
		add_action( 'widgets_init', array($this, 'magiccart_load_widget') );
		add_action( 'admin_enqueue_scripts', array($this, 'add_admin_web') );
		add_action('wp_enqueue_scripts', array($this, 'add_fontend_web'), 11);
	}
	
	public function magiccart_load_widget() {
		
		$blogPicture = new Picture;
		register_widget( $blogPicture );
		
		$blogPosts = new Posts();
		register_widget( $blogPosts );
		
		$blogTags = new Tags;
		register_widget( $blogTags );

		$blogShortcode = new Shortcode;
		register_widget( $blogShortcode );
		
		$productCategories = new Categories;
		register_widget( $productCategories );

		$productTopSeller = new Topseller;
		register_widget( $productTopSeller );

		$productRecentreviews = new Recentreviews;
		register_widget( $productRecentreviews );
		
	}
	
	public function add_admin_web(){
		wp_register_script('upload-image-widget',  $this->get_url("adminhtml/web/js/upload-image-widget.js") , array('jquery') ,'1.0');
		wp_enqueue_script('upload-image-widget');
	}
	
	function  add_fontend_web(){
		wp_register_style('magiccart_widget', $this->get_url("frontend/web/css/magiccart_widget.css"));
		wp_enqueue_style('magiccart_widget');
	}
}