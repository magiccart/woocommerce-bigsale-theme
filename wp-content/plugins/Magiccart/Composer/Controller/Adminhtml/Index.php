<?php
namespace Magiccart\Composer\Controller\Adminhtml;

use Magiccart\Composer\Block\Adminhtml\Vc\Product\Catalog;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Categories;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Brands;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Posts;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Slider;
//use Magiccart\Composer\Block\Adminhtml\Vc\Post\Picturecategory;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Testimonial;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Portfolio;
use Magiccart\Composer\Block\Adminhtml\Vc\Post\Desandro;
use Magiccart\Composer\Block\Adminhtml\Vc\Product\Products;

class Index{
	public function __Construct(){
		new Products();
		new Catalog();
		new Categories();
		new Brands();
		new Slider();
		new Posts();
		new Testimonial();
		new Portfolio();
		new Desandro();
	}
}