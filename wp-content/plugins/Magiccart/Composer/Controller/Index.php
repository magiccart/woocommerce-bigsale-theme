<?php
namespace Magiccart\Composer\Controller;

use Magiccart\Composer\Block\Product\Catalog;
use Magiccart\Composer\Block\Product\Categories;
use Magiccart\Composer\Block\Product\Products;
use Magiccart\Composer\Block\Post\Posts;
use Magiccart\Composer\Block\Post\Slider;
use Magiccart\Composer\Block\Post\Testimonial;
use Magiccart\Composer\Block\Post\Portfolio;
use Magiccart\Composer\Block\Post\Desandro;
use Magiccart\Composer\Block\Product\Brands;

class Index{
	public function __construct(){
		new Catalog();
		new Categories();
		new Products();
		new Posts();
		new Brands();
		new Slider();
		new Testimonial();
		new Portfolio();
		new Desandro();
	}
}