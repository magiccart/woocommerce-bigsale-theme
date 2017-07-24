<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids && has_post_thumbnail() ) {
	$index = 1;
	foreach ( $attachment_ids as $attachment_id ) {
		$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$thumbnail_post   = get_post( $attachment_id );
		$image_title      = $thumbnail_post->post_content;

		$attributes = array(
			'title'                   => $image_title,
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		$html  = '<div data-index="' . $index . '" data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
		$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
 		$html .= '</a></div>';
 		
	 	$index++;
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
		
	}
	echo "</figure>";
	$selector = 'alo-content-'.rand(0,999999999);
	$optionSettings = magiccart_options('product_thumnail');

	$settings = settings_slide($optionSettings);
	?>
	<figure id="wrapper-thumbs" <?php foreach($settings as $key => $value){?>
                                   data-<?php echo $key;   ?>  = '<?php echo $value; ?>'
                       <?php } ?> >
    <?php
	
}
?>
<script type="text/javascript">
// jQuery(document).ready(function($){
// 	var gallery = $('.woocommerce-product-gallery__wrapper');
// 	var thumbnails = $('#wrapper-thumbs');
	
// 	var html = '';
// 	gallery.children().each(function(index){
// 		if(!$(this).data('index') ){
// 			$(this).data('index', 0);
// 		}
// 		html += '<li class="thumb-image" data-index="' + $(this).data('index') + '"><img src="' + $(this).data('thumb') + '"/></li>';
// 	})
// 	thumbnails.append('<ol class="flex-control-nav flex-control-thumbs">' + html + '</ol>');
// 	var slider = $('#wrapper-thumbs .flex-control-nav').slick(thumbnails.data());

// 	slider.on( "click", ".thumb-image", function() {
// 		console.log('click')
// 		var index 		= $(this).data('index');
// 		var item  ='';
// 		gallery.children().each(function(){
// 				if(index == $(this).data('index')){
// 					gallery.children().removeClass('flex-active-slide');
// 					$(this).addClass('flex-active-slide');
// 					gallery.prepend($(this));
					
// 				} 
// 			})
//         //thumbnails.slick('slickSetOption', "autoplay",false,false);

//     }); 
// });
</script>