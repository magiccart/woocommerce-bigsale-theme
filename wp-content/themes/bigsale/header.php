<?php 
	$options = magiccart_options();
	/*echo "<pre>";
	print_r($options);
	echo "</pre>";*/
	
	
	if(isset($_GET['taxonomy']) && isset($_GET['term'])){
		$type 	= substr($_GET['taxonomy'], 3);
		$data = "?filter_" . $type . "=" . $_GET['term'];
		wp_safe_redirect( get_permalink( woocommerce_get_page_id( 'shop' ) ) . $data );
	}
	
	if( isset($options['logo-image']['url']) ){
	    $logo = '<img src="'. $options['logo-image']['url'] .'"  alt="'.$options['logo_alt'].'" />';
	} else {
		$logo = get_bloginfo('sitename');
	}

	$support = "#";
	if(isset($options['page-support']) &&  $options['page-support'] != ""){
		$support = $options['page-support'];
	}
	
	function getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {
		for ( $i = $pos; $i < count( $array ); $i ++ ) {
			if ( $array[ $i ]->category_parent == $parent_id ) {
				$name = str_repeat( '&nbsp;&nbsp;', $level ) . ucfirst($array[ $i ]->name);
				$value = $array[ $i ]->slug;
				$dropdown[] = array(
						'label' => $name,
						'value' => $value,
				);
				getCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
			}
		}
	}
	
	function all_categories(){
		$categories = magiccart_get_all_category();
		$product_categories_dropdown = array();
		$product_categories = array();
		getCategoryChildsFull( 0, 0, $categories, 0, $product_categories_dropdown );
		
		foreach($product_categories_dropdown as $value){
			$product_categories[$value['value']] = $value['label'];
		}
		return $product_categories;
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
    	<?php 
			echo getGridStyle();
	    ?>
	<style type="text/css">
	    <?php 
			echo $options['custom_css'];
	    ?>
		
	</style>
	<?php 
		$html  = '<style type="text/css">';
		$options = magiccart_options();
		if(isset($options['color'])){
			foreach ($options['color'] as $options) {
				foreach ($options as $value) {
					$html .= htmlspecialchars_decode($value['selector']) .'{';
						$html .= $value['color'] 		? 'color:' .$value['color']. ';' 					: '';
						$html .= $value['background'] 	? ' background-color:' .$value['background']. ';' 	: '';
						$html .= $value['border'] 		? ' border-color:' .$value['border']. ';' 			: '';
					$html .= '}';
				}
			}
		}
		$html  .= '</style>';
		echo $html
	?>
</head>
<?php
    $file = magiccart_options("file-header");
    if($file){
        include(get_template_directory() . "/" . $file);
    }else{
    	echo __("<br /><b>Please save the values in the theme options!</b>", 'alothemes');
    	die();
    }
?>