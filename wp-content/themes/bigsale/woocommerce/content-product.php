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
// $products_cats = $product->get_categories();
// list($fistpart) = explode(',', $products_cats);
// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
$srcDefault = ALOTHEMES_IMAGES . 'default.png';
$optionsCfg  = magiccart_options();
$configLazy   = $optionsCfg['lazy-load'];
$typeView = '';
if(is_shop()){
    $typeView  = $optionsCfg['product_shop_default_view'];
}else{
    $typeView  = $optionsCfg['product_category_default_view'];
}

$classLi = is_home() ? post_class('product') : 'class="product type-product"';
?>

<li <?php echo $classLi; ?> >
    <div class="inner-wrap per-product product clearfix">
       
        <div class="product-img">
             <?php if ( $product->is_on_sale() ) : ?>
                <div class="badge">
                    <div class="badge-inner sale-label">
                         <?php echo apply_filters( 'woocommerce_sale_flash', '<div class="inner-text">' . __( 'Sale', 'woocommerce' ) . '</div>', $post, $product ); ?>
                    </div>
                </div>
            
            <?php endif; ?>
            <?php
                if( (isset($args['review']) && $args['review'] == "yes") || (!is_front_page() && !isset($args['review']) && $typeView != 'list-view' ) ){
                    echo "<div class='quickview'>";
                        echo '<a href="#" class="button yith-wcqv-button" title="Quick View" data-product_id="'. $post->ID .'">Quick View</a>';
                    echo "</div>";
                }
                
                $imgCatalog = get_the_post_thumbnail_url($post->ID, 'shop_catalog');
                $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
               
                if($imgCatalog == ''){
                    $imgCatalog = $srcDefault;
                }
                
            ?>
                
        <div class="image-overlay"></div>
        <div class="main-img">
            <a href="<?php echo get_the_permalink() ?>">
                <?php
                    if( ! $configLazy){
                        echo '<img  src="'. $imgCatalog .'"  class="attachment-shop_catalog size-shop_catalog" alt="'. $props['alt'] .'" title="'. $props['title'] .'">';
                    }else{
                        echo '<img  src="'. $srcDefault .'" data-lazy="'. $imgCatalog .'"  class="attachment-shop_catalog size-shop_catalog lazy" alt="'. $props['alt'] .'" title="'. $props['title'] .'">';
                    }
                ?>
            </a>
        </div>
        <?php 
        
        $backImgCfg = isset($optionsCfg['backImgCfg']) ? $optionsCfg['backImgCfg'] : 0;
        
        if($backImgCfg){
            $attachment_ids = $product->get_gallery_image_ids();
            if ( $attachment_ids ) {
                $backImg        = wp_get_attachment_image_src( $attachment_ids[0], 'shop_catalog' );
                if(isset($backImg[0]) && $backImg[0]){
                    if( ! $configLazy){
                       echo '<div class="back-img back"><a href="' . get_the_permalink() .'"><img src="'. $backImg[0] .'" class="attachment-shop_catalog size-shop_catalog" alt="'. $props['alt'] .'" title="'. $props['title'] .'"></a></div>';
                    }else{
                        echo '<div class="back-img back"><a href="' . get_the_permalink() .'"><img src="'. $srcDefault .'" data-lazy="'. $backImg[0] .'" class="attachment-shop_catalog size-shop_catalog lazy" alt="'. $props['alt'] .'" title="'. $props['title'] .'"></a></div>';
                    }
                }
            } 
        }
        
        ?>
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
                
                <div class="product-summary">
                    <?php 
                        if ( $product ) {
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
                    ?>
                </div>
            </div>
            <div class="description">
                <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
            </div>
        </div>
    </div>   
</li>

