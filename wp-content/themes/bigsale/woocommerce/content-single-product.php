<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
	exit; // Exit if accessed directly
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook.
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div id="product-<?php the_ID(); ?>" <?php post_class(); ?> >

	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		//do_action( 'woocommerce_before_single_product_summary' );

		wc_get_template( 'single-product/sale-flash.php' );
	?>
<div class="row">
	<div class="product-img-box col-md-5 col-sm-5 col-xs-12">
		<?php
			wc_get_template( 'single-product/product-image.php' );
		?>

		<?php
			function woo_available_options(){
				global $product;
				if($product->is_type( 'variable' ) ){
					echo '<div class="available-options">
	                    <h3 class="available-title">Available Options:</h3>
	                </div>';
				}
			}
		?>
	</div>
	<div class="product-info-main col-md-7 col-sm-7 col-xs-12">
		<div class="summary entry-summary">

			<?php
			 
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 */

				remove_action( 'woocommerce_single_product_summary', 
	               'woocommerce_template_single_price',10 );
				add_action( 'woocommerce_single_product_summary', 
	            'woocommerce_template_single_price', 9 );

	            remove_action( 'woocommerce_single_product_summary', 
	               'woocommerce_template_single_meta',40 );
				add_action( 'woocommerce_single_product_summary', 
	            'woocommerce_template_single_meta', 9 );
	            
				add_action( 'woocommerce_single_product_summary', 
	            'woo_available_options', 21 );
	            add_action( 'woocommerce_template_single_add_to_cart', 
	            'woo_widhlist', 32 );



				do_action( 'woocommerce_single_product_summary' );
				
				
			
				/*wc_get_template( 'single-product/title.php' );
				wc_get_template( 'single-product/price.php' );
				wc_get_template( 'single-product/rating.php' );
				
				wc_get_template( 'single-product/short-description.php' );
				
				wc_get_template( 'single-product/meta.php' );
				echo "<p>Available Options:</p>";
				global $product;
				do_action( 'woocommerce_' . $product->product_type . '_add_to_cart' );
				wc_get_template( 'single-product/share.php' );
				*/


			?>
			
			<!-- ==================== START SOCIAL SHARE ===================== -->
			<div class="addit">
		         <div class="alo-social-links clearfix">
		            <div class="so-facebook so-social-share">
		                <div id="fb-root"></div>
		                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="20" data-show-faces="false"></div>
		            </div>
		            <div class="so-twitter so-social-share">
		                <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-dnt="true">Tweet</a>
		            </div>
		            <div class="so-plusone so-social-share">
		                <div class="g-plusone" data-size="medium"></div>
		                <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		            </div>
		        </div>
		    </div>
	    	<script type="text/javascript">
	    		(function(d, s, id) {
				    var js, fjs = d.getElementsByTagName(s)[0];
				    if (d.getElementById(id)) return;
				    js = d.createElement(s);
				    js.id = id;
				    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=115245961994281";
				    fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				!function(d,s,id){
				    var js,fjs=d.getElementsByTagName(s)[0];
				    if(!d.getElementById(id)){
				        js=d.createElement(s);
				        js.id=id;
				        js.src="//platform.twitter.com/widgets.js";
				        fjs.parentNode.insertBefore(js,fjs);
				    }
				}(document,"script","twitter-wjs");
	    	</script>
	    	<!-- ==================== END SOCIAL SHARE ===================== -->
		</div><!-- .summary -->
	</div>
</div>



	<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
