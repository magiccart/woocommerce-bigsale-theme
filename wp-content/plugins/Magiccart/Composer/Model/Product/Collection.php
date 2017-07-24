<?php
namespace Magiccart\Composer\Model\Product;

class Collection{
	
	/*==========================================================================
	 WooCommerce - Function get Query
	 ==========================================================================*/
	public function woo_query($type,$post_per_page=-1,$cat='',$paged=''){
		global $woocommerce;
		if(!$woocommerce) return array();
	
		$meta_query   = array();
		$meta_query[] = $woocommerce->query->stock_status_meta_query();
		$meta_query[] = $woocommerce->query->visibility_meta_query();
	
		remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
		if($type != "top_rate"){
			remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
		}
		
		if($paged == '') {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		$args = array(
				'post_type'         => 'product',
				'posts_per_page'    => $post_per_page,
				'post_status'       => 'publish',
				'paged'             => $paged
		);
		switch ($type) {
			case 'best_selling':
				$args['meta_key']='total_sales';
				$args['orderby'] ='meta_value_num';
				$args['ignore_sticky_posts']   = 1;
				$args['meta_query'] = array();
				$args['meta_query'] = $meta_query;
				break;
			case 'featured_product':
				$args['ignore_sticky_posts']=1;
				$args['meta_query']   = array();
				$args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
				$args['meta_query'][] = array(
						'key'   => '_featured',
						'value' => 'yes'
				);
				$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
				break;
			case 'top_rate':
				$args['meta_query'] = array();
				$args['meta_query'] = $meta_query;
				break;
			case 'recent_product':
				$args['meta_query']     = array();
				$args['meta_query'][]   = $woocommerce->query->stock_status_meta_query();
				break;
			case 'on_sale':
				$args['meta_query'] = array();
				$args['meta_query'] = $meta_query;
				$args['post__in']   = wc_get_product_ids_on_sale();
				break;
			case 'recent_review':
				if($post_per_page == -1) $_limit = 4;
				else $_limit = $post_per_page;
				global $wpdb;
				$query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = %s AND p.post_status = %s AND p.comment_count > %s ORDER BY c.comment_date ASC LIMIT 0, ". $_limit;
				$results = $wpdb->get_results($wpdb->prepare($query, 'product', 'publish', '0', OBJECT));
				$_pids = array();
				foreach ($results as $re) {
					$_pids[] = $re->comment_post_ID;
				}
	
				$args['meta_query'] = array();
				$args['meta_query'] = $meta_query;
				$args['post__in']   = $_pids;
				break;
			case 'deals':
				$args['meta_query'] = array();
				$args['meta_query'] = $meta_query;
				$args['meta_query'][] = array(
						'key' 		=> '_sale_price_dates_to',
						'value' 	=> '0',
						'compare' 	=> '>'
				);
				$args['post__in'] = wc_get_product_ids_on_sale();
				break;
		}
	
		if($cat!=''){
			$args['product_cat']= $cat;
		}
		return new \WP_Query($args);
	}
}



 