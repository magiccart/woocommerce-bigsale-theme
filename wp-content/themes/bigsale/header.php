<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-15 21:01:50
 * @@Modify Date: 2017-08-15 21:15:22
 * @@Function:
 */

if(isset($_GET['taxonomy']) && isset($_GET['term'])){
	$type 	= substr($_GET['taxonomy'], 3);
	$data = "?filter_" . $type . "=" . $_GET['term'];
	wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) . $data );
}	
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="profile" href="http://gmgp.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
    <?php echo getGridStyle();?>
	<style type="text/css">
	<?php 
		global $themecfg;
		$styles = '';
		if(isset($themecfg['color'])){
			foreach ($themecfg['color'] as $options) {
				foreach ($options as $value) {
					$styles .= htmlspecialchars_decode($value['selector']) .'{';
						$styles .= $value['color'] 		? 'color:' .$value['color']. ';' 					: '';
						$styles .= $value['background'] 	? ' background-color:' .$value['background']. ';' 	: '';
						$styles .= $value['border'] 		? ' border-color:' .$value['border']. ';' 			: '';
					$styles .= '}';
				}
			}
		}
		$styles .= $themecfg['custom_css'];
		echo $styles;
	?>
	</style>
</head>
<body <?php body_class('woocommerce'); ?> >
    <div id="container-main">
	    <div class="header">
			<?php
				$headerId = magiccart_options('header');
			    if($headerId){
		            $post_header = get_post($headerId);
		            if($post_header){
		                $content = apply_filters('the_content', $post_header->post_content);
		                $content = str_replace(']]>', ']]&gt;', $content);
		                $styles  = get_post_meta( $headerId, 'header-skin', true );
		                $shortcodes_css = get_post_meta( $headerId, '_wpb_shortcodes_custom_css', true );
		                wp_reset_postdata();
		                echo  $content . '<style type="text/css">' . $shortcodes_css . $styles . '</style>';
		            }
		        }
			?>
			
	    </div>
