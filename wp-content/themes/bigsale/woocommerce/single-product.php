<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
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

	$options      = magiccart_options();

	$layout 	= $options['single_product_layout'];
	$classer 	= '';
	$row        = '';
	if(isset($_GET['layout'])) $layout = $_GET['layout']; //  LAYOUT DEMO
	if($layout != 'col1-layout'){
		$row        = 'row';
		$classer 	= ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';
	}

get_header( 'shop' ); ?>
    <div id="content" class="main <?php echo $layout; ?>">
    	<div class="details container">
			<?php woocommerce_breadcrumb(); ?>
			<div class="<?php echo $row ?>">
				<!-- sidebar -->       
		      	<?php if($layout == 'col3-layout'){ ?>
		        	<div class="sidebar sidebar-left col-md-3 col-sm-3">
		             	<?php get_sidebar('left'); ?>
		        	</div>
		      	<?php } ?>
		      	<?php $classer .= $layout == 'col2-left-layout' ? ' f-right' : ''; ?>

				<div class="<?php echo $classer ?> col-main">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php wc_get_template_part( 'content', 'single-product' ); ?>
					<?php endwhile; // end of the loop. ?>
				</div><!-- col-main -->

				<!-- sidebar -->        
		      	<?php 
		        	$sidebar = '';
		        	if($layout == 'col3-layout' || $layout == 'col2-right-layout'){
		            	$sidebar = 'right';
		        	} else if($layout == 'col2-left-layout')
		            	$sidebar = 'left';
		        	if($sidebar){
		      	?>
		        	<div class="sidebar sidebar-<?php echo $sidebar ?> col-md-3 col-sm-3">
		            	<?php get_sidebar($sidebar); ?>
		        	</div>
		        <?php } ?>
			</div><!-- end row -->
		</div>
	</div>
	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		//wc_get_template( 'global/sidebar.php' );
	?>
<?php get_footer( 'shop' ); ?>
