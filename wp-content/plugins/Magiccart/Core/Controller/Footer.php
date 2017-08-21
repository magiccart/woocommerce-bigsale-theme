<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-09 22:09:48
 * @@Modify Date: 2017-08-09 23:35:44
 * @@Function:
 */

namespace Magiccart\Core\Controller;

class Footer extends Action {
    public function __construct(){
        add_action('init', array($this, 'footer_init'));
        add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
        add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        add_submenu_page(
            'magiccart',
            'Footer',
            'Footer',
            'manage_options',
            'edit.php?post_type=footer'
        );

    }

    public function footer_init(){
        $labels = array(
            'name'               => _x( 'Footer', 'alothemes' ),
            'singular_name'      => _x( 'Footer', 'alothemes' ),
            'menu_name'          => _x( 'Footer', 'alothemes' ),
            'name_admin_bar'     => _x( 'Book', 'alothemes' ),
            'add_new'            => _x( 'Add New', 'alothemes' ),
            'add_new_item'       => __( 'Add New Footer', 'alothemes' ),
            'new_item'           => __( 'New Footer', 'alothemes' ),
            'edit_item'          => __( 'Edit Footer', 'alothemes' ),
            'view_item'          => __( 'View Footer', 'alothemes' ),
            'all_items'          => __( 'All Footers', 'alothemes' ),
            'search_items'       => __( 'Search Footer', 'alothemes' ),
            'parent_item_colon'  => __( 'Parent Footer:', 'alothemes' ),
            'not_found'          => __( 'No Footer found.', 'alothemes' ),
            'not_found_in_trash' => __( 'No Footer found in Trash.', 'alothemes' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Magiccart Footer .', 'alothemes' ),
            'menu_icon'          => 'dashicons-image-filter',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false, // show in main admin set true
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'Footer' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            //'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
        );
        register_post_type( 'footer', $args );

    }

    public function register_meta_boxes() {
        add_meta_box( 'meta-box-footer-skin', __( 'Skin', 'alothemes' ), array($this, 'callback_footer_skin'), 'footer' );
    }

    public function save_meta_box( $post_id, $post, $update  ) {
        if(isset($_POST['footer-skin'])){
            update_post_meta($post_id, 'footer-skin', $_POST['footer-skin']);
        }
    }

    public function callback_footer_skin( $post ) {
        $metaFooterSkin = get_post_meta($post->ID, 'footer-skin', true);
        // echo '<textarea id="mc-footer-skin" name="footer-skin"  style="width:100%;" >' . esc_textarea( $metaFooterSkin  )  . '</textarea>';
        echo '<textarea id="mc-footer-skin" name="footer-skin" class="widefat" cols="50" rows="5">' . esc_textarea( $metaFooterSkin  )  . '</textarea>';
    }

}

