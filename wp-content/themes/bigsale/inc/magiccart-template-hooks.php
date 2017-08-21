<?php
/**
 * magiccart hooks
 *
 * @package magiccart
 */

/**
 * General
 *
 * @see  magiccart_header_widget_region()
 * @see  magiccart_get_sidebar()
 */
add_action( 'magiccart_before_content', 'magiccart_header_widget_region', 10 );
add_action( 'magiccart_sidebar',        'magiccart_get_sidebar',          10 );

/**
 * Header
 *
 * @see  magiccart_skip_links()
 * @see  magiccart_secondary_navigation()
 * @see  magiccart_site_branding()
 * @see  magiccart_primary_navigation()
 */
add_action( 'magiccart_header', 'magiccart_skip_links',                       0 );
add_action( 'magiccart_header', 'magiccart_site_branding',                    20 );
add_action( 'magiccart_header', 'magiccart_secondary_navigation',             30 );
add_action( 'magiccart_header', 'magiccart_primary_navigation_wrapper',       42 );
add_action( 'magiccart_header', 'magiccart_primary_navigation',               50 );
add_action( 'magiccart_header', 'magiccart_primary_navigation_wrapper_close', 68 );

/**
 * Footer
 *
 * @see  magiccart_footer_widgets()
 * @see  magiccart_credit()
 */
add_action( 'magiccart_footer', 'magiccart_footer_widgets', 10 );
add_action( 'magiccart_footer', 'magiccart_credit',         20 );

/**
 * Homepage
 *
 * @see  magiccart_homepage_content()
 * @see  magiccart_product_categories()
 * @see  magiccart_recent_products()
 * @see  magiccart_featured_products()
 * @see  magiccart_popular_products()
 * @see  magiccart_on_sale_products()
 * @see  magiccart_best_selling_products()
 */
add_action( 'homepage', 'magiccart_homepage_content',      10 );
add_action( 'homepage', 'magiccart_product_categories',    20 );
add_action( 'homepage', 'magiccart_recent_products',       30 );
add_action( 'homepage', 'magiccart_featured_products',     40 );
add_action( 'homepage', 'magiccart_popular_products',      50 );
add_action( 'homepage', 'magiccart_on_sale_products',      60 );
add_action( 'homepage', 'magiccart_best_selling_products', 70 );

/**
 * Posts
 *
 * @see  magiccart_post_header()
 * @see  magiccart_post_meta()
 * @see  magiccart_post_content()
 * @see  magiccart_init_structured_data()
 * @see  magiccart_paging_nav()
 * @see  magiccart_single_post_header()
 * @see  magiccart_post_nav()
 * @see  magiccart_display_comments()
 */
add_action( 'magiccart_loop_post',           'magiccart_post_header',          10 );
add_action( 'magiccart_loop_post',           'magiccart_post_meta',            20 );
add_action( 'magiccart_loop_post',           'magiccart_post_content',         30 );
add_action( 'magiccart_loop_post',           'magiccart_init_structured_data', 40 );
add_action( 'magiccart_loop_after',          'magiccart_paging_nav',           10 );
add_action( 'magiccart_single_post',         'magiccart_post_header',          10 );
add_action( 'magiccart_single_post',         'magiccart_post_meta',            20 );
add_action( 'magiccart_single_post',         'magiccart_post_content',         30 );
add_action( 'magiccart_single_post',         'magiccart_init_structured_data', 40 );
add_action( 'magiccart_single_post_bottom',  'magiccart_post_nav',             10 );
add_action( 'magiccart_single_post_bottom',  'magiccart_display_comments',     20 );
add_action( 'magiccart_post_content_before', 'magiccart_post_thumbnail',       10 );

/**
 * Pages
 *
 * @see  magiccart_page_header()
 * @see  magiccart_page_content()
 * @see  magiccart_init_structured_data()
 * @see  magiccart_display_comments()
 */
add_action( 'magiccart_page',       'magiccart_page_header',          10 );
add_action( 'magiccart_page',       'magiccart_page_content',         20 );
add_action( 'magiccart_page',       'magiccart_init_structured_data', 30 );
add_action( 'magiccart_page_after', 'magiccart_display_comments',     10 );

add_action( 'magiccart_homepage',       'magiccart_homepage_header',      10 );
add_action( 'magiccart_homepage',       'magiccart_page_content',         20 );
add_action( 'magiccart_homepage',       'magiccart_init_structured_data', 30 );
