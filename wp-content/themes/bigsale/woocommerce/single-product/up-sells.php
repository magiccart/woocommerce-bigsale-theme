<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! $upsells ) return;

$selector = 'alo-content-'.rand(0,999999999);
$optionSettings = magiccart_options('product_up_sells');

$settings = settings_slide($optionSettings);

?>
<div class="<?php echo $selector ?>">
	<section class="up-sells upsells products auto-height">

		<h2><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>

		<?php //woocommerce_product_loop_start(); ?>
		<ol class="products grid" <?php foreach($settings as $key => $value){?>
                                   data-<?php echo $key;   ?>  = '<?php echo $value; ?>'
                           <?php } ?> >

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				 	$post_object = get_post( $upsell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>
		</ol>
		<?php //woocommerce_product_loop_end(); ?>

	</section>
</div>

<?php
	wp_reset_postdata();
?>

<script type="text/javascript">
jQuery(document).ready(function(){
	(function ($) {
		var upsells  = $('.<?php echo $selector ?> .upsells .products');
		if(upsells.length) $('head').append(magicproduct(upsells, '.type-product'));
    })(jQuery);
});
</script>
