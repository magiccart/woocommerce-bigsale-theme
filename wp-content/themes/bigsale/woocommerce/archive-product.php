<?php
/**
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
$_delay = 200;
$_count = 1;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global  $wp_query;

$typelist = (isset($_COOKIE['gridcookie']) && $_COOKIE['gridcookie'] == 'list') ? true : false;

$hasSidebar = true;

get_header('shop');

$options          = magiccart_options();
$classer          = '';
$row              = '';
$visible          = '';
if(is_shop()){
  $layout   = $options['product_shop_layout'];
  $visible  =  $options['product_shop']['visible'];
}else{
  $layout = $options['product_category_layout'];
  $visible  = $options['product_category']['visible'];
}
if(isset($_GET['layout'])) $layout = $_GET['layout']; //  LAYOUT DEMO
if(isset($_GET['visible'])) $visible = $_GET['visible']; //  LAYOUT DEMO
if($layout != 'col1-layout'){
  $row        = 'row';
  $classer  = ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';

} 
$classer .= " col-visible-$visible";
$category_name = "";
if(is_product_category()){
  $cat_obj = $wp_query->get_queried_object();
  $category_name = $cat_obj->name;
  
}
?>
<div class="woo-shop content <?php echo $layout ?>">
  <div class="container">
    <?php do_action('woocommerce_before_main_content'); ?>
    <div class="<?php echo $row ?>">
      <!-- sidebar -->       
      <?php if($layout == 'col3-layout'){ ?>
        <div class="sidebar sidebar-left col-md-3 col-sm-3">
             <?php get_sidebar('left'); ?>
        </div>
      <?php } ?>
      <?php $classer .= $layout == 'col2-left-layout' ? ' f-right' : ''; ?>

      <div class="col-main <?php echo $classer ?>">
        <div class="category-image"> 
          <img src="<?php echo ALOTHEMES_IMAGES . 'Grid.jpg' ?>" alt="<?php echo $category_name ?>">
        </div>
        <div class="cat-header">
        	<div class="sort-bar">
                 <?php if ( have_posts() ) : do_action( 'woocommerce_before_shop_loop' ); ?><?php endif; ?>
            </div>
            <div class="woo-pagination clearfix">
               <!-- Pagination -->
               <?php do_action( 'woocommerce_after_shop_loop' );?>
               <!-- End Pagination -->
            </div>
        </div>
        <div class="category-page">
        	<?php //do_action( 'woocommerce_archive_description' ); ?>
            <?php if ( have_posts() ) : ?>
                <?php woocommerce_product_loop_start(); ?>
                    <?php woocommerce_product_subcategories(); ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <!-- Product Item -->
                        <?php wc_get_template( 'content-product.php', array('_delay' => $_delay, 'wrapper' => 'li') ); ?>
                        <!-- End Product Item -->
                        <?php  $_delay+=200; ?>
                    <?php endwhile;?>
                <?php woocommerce_product_loop_end(); ?>
                <div class="woo-pagination clearfix">
                    <!-- Pagination -->
                    <?php do_action( 'woocommerce_after_shop_loop' );?>
                    <!-- End Pagination -->
                </div>
            <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>
                <?php wc_get_template( 'loop/no-products-found.php' ); ?>
            <?php endif; ?>
          </div>
        </div>
      <!-- sidebar -->        
      <?php 
        $sidebar = '';
        if($layout == 'col3-layout' || $layout == 'col2-right-layout'){
            $sidebar = 'right';
        } elseif($layout == 'col2-left-layout')
            $sidebar = 'left';
        if($sidebar){
      ?>
        <div class="sidebar sidebar-<?php echo $sidebar ?> col-md-3 col-sm-3">
            <?php get_sidebar($sidebar); ?>
        </div>
        <?php } ?>
    </div>
    <?php do_action('woocommerce_after_main_content'); ?>  
  </div>
</div> <!-- end container -->
<?php get_footer('shop'); ?>