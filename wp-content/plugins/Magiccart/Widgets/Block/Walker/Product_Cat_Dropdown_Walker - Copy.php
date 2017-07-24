<?php
namespace Magiccart\Widgets\Block\Walker;
class Product_Cat_Dropdown_Walker extends \Walker {
	public $tree_type = 'category';
	
	/**
	 * DB fields to use.
	 *
	 * @var array
	 */
	public $db_fields = array(
			'parent' => 'parent',
			'id'     => 'term_id',
			'slug'   => 'slug'
	);
	
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= "{$n}{$indent}<ul class=''>{$n}";
	}
	
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );
		$output .= "$indent</ul>{$n}";
	}
	
	public function start_el( &$output, $cat, $depth = 0, $args = array(), $current_object_id = 0 ) {
	$productCat = isset($_GET['product_cat']) ? $_GET['product_cat'] : '';
	
	$action = "";
	if($productCat == $cat->slug){
		$action = 'action';
	}
	
		if ( ! empty( $args['hierarchical'] ) )
			
			$pad = str_repeat('&nbsp;', $depth * 3);
			else
				$pad = '';
	
				$cat_name = apply_filters( 'list_product_cats', $cat->name, $cat );
	
				$value = isset( $args['value'] ) && $args['value'] == 'id' ? $cat->term_id : $cat->slug;
	
				$output .= "\t<li class=\"level-$depth $action\" value=\"" . $value . "\"";
	
				if(isset($args['selected'])){
					if ( $value == $args['selected'] || ( is_array( $args['selected'] ) && in_array( $value, $args['selected'] ) ) )
						$output .= ' selected="selected"';
				}
						$output .= '>';
		
						$output .= '<a href="'. get_category_link($cat->term_id) .'">' . $pad . _x( $cat_name, 'product category name', 'woocommerce' ) . '</a>';
		
						if ( ! empty( $args['show_count'] ) )
							$output .= '&nbsp;(' . $cat->count . ')';
		
							$output .= "</li>\n";
				
						
	}
	
	public function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
		if ( ! $element || ( 0 === $element->count && ! empty( $args[0]['hide_empty'] ) ) ) {
			return;
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}