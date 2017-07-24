<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
global $post, $product;
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
$srcDefault = ALOTHEMES_IMAGES . 'default.png';
$optionsCfg  = magiccart_options();
$typeView = '';
if(is_shop()){
    $typeView  = $optionsCfg['product_shop_default_view'];
}else{
    $typeView  = $optionsCfg['product_category_default_view'];
}

$classLi = is_home() ? post_class('product') : 'class="product type-product"';
//echo post_class('product');
?>

<li class="product" >
    <div class="inner-wrap per-product product clearfix">
       
        <div class="product-img">
            <?php
                if( (isset($args['review']) && $args['review'] == "yes") || (!is_front_page() && !isset($args['review']) && $typeView != 'list-view' ) ){
                    echo "<div class='quickview'>";
                        echo '<a href="#" class="button yith-wcqv-button" data-product_id="'. $post->ID .'">Quick View</a>';
                    echo "</div>";
                }
                
                $imgCatalog = get_the_post_thumbnail_url($post->ID, 'shop_catalog');
                $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
               
                if($imgCatalog == ''){
                    $imgCatalog = $srcDefault;
                }
                
            ?>
                
        <div class="sidebar-img">
            <a href="<?php echo get_the_permalink() ?>">
                <?php
                    echo '<img  src="'. $imgCatalog .'" alt="'. $props['alt'] .'" title="'. $props['title'] .'">';
                    
                ?>
            </a>
        </div>

         </div>
         <div class="info">
            <div class="information clearfix">
                <div class="info_main">
                    <?php 
                        echo '<h3 class="product-name"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
                        wc_get_template( 'loop/price.php' );
                    ?>
                    <?php wc_get_template( 'loop/rating.php' ); ?>
                </div>
                
                <?php 
                    if ( $product ) {
                        echo '<div class="product-summary">';
                        $defaults = array(
                            'quantity' => 1,
                            'class'    => implode( ' ', array_filter( array(
                                'button',
                                'product_type_' . $product->get_type(),
                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
                            ) ) )
                        );
                        
                        $args = isset($args) ? $args : array();
                        $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

                        if( (isset($args['cart']) && $args['cart'] == "yes") || (!is_front_page() && !isset($args['cart'])) ){
                                wc_get_template( 'loop/add-to-cart.php', $args );
                        }

                        if((isset($args['wishlist']) && $args['wishlist'] == "yes") || (!is_front_page() && !isset($args['wishlist']) ) ){
                            echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="'. $post->ID .'"]'); 
                        }
                        if((isset($args['compare']) && $args['compare'] == "yes") || (!is_front_page() && !isset($args['compare']))){
                            echo do_shortcode('[yith_compare_button product_id="'. $post->ID .'"]'); 
                        }
                        if(!is_front_page() && !isset($args['review']) && $typeView == 'list-view'  ){
                            echo "<div class='quickview'>";
                                echo '<a href="#" class="button yith-wcqv-button" data-product_id="'. $post->ID .'">Quick View</a>';
                            echo "</div>";
                        }
                        echo '</div>';
                    }
                ?>
            </div>
        </div>
    </div>   
</li>

