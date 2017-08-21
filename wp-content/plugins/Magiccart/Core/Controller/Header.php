<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-08-09 22:09:48
 * @@Modify Date: 2017-08-09 23:50:31
 * @@Function:
 */

namespace Magiccart\Core\Controller;

class Header extends Action {
    public function __construct(){
        add_action('init', array($this, 'header_init'));
        add_action( 'save_post', array($this, 'save_meta_box'), 10, 3 );
        add_action( 'add_meta_boxes', array($this, 'register_meta_boxes') );
        add_submenu_page(
            'magiccart',
            'Header',
            'Header',
            'manage_options',
            'edit.php?post_type=header'
        );

    }

    public function header_init(){
        $labels = array(
            'name'               => _x( 'Header', 'alothemes' ),
            'singular_name'      => _x( 'Header', 'alothemes' ),
            'menu_name'          => _x( 'Header', 'alothemes' ),
            'name_admin_bar'     => _x( 'Book', 'alothemes' ),
            'add_new'            => _x( 'Add New', 'alothemes' ),
            'add_new_item'       => __( 'Add New Header', 'alothemes' ),
            'new_item'           => __( 'New Header', 'alothemes' ),
            'edit_item'          => __( 'Edit Header', 'alothemes' ),
            'view_item'          => __( 'View Header', 'alothemes' ),
            'all_items'          => __( 'All Headers', 'alothemes' ),
            'search_items'       => __( 'Search Header', 'alothemes' ),
            'parent_item_colon'  => __( 'Parent Header:', 'alothemes' ),
            'not_found'          => __( 'No Header found.', 'alothemes' ),
            'not_found_in_trash' => __( 'No Header found in Trash.', 'alothemes' )
        );

        $args = array(
            'labels'             => $labels,
            'description'        => __( 'Magiccart Header .', 'alothemes' ),
            'menu_icon'          => 'dashicons-image-filter',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => false, // show in main admin set true
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'header' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            //'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
            'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
        );
        register_post_type( 'header', $args );

    }

    public function register_meta_boxes() {
        add_meta_box( 'meta-box-header-skin', __( 'Skin', 'alothemes' ), array($this, 'callback_header_skin'), 'header' );
    }

    public function save_meta_box( $post_id, $post, $update  ) {
        if(isset($_POST['header-skin'])){
            update_post_meta($post_id, 'header-skin', $_POST['header-skin']);
        }
    }

    public function callback_header_skin( $post ) {
        $metaHeaderSkin = get_post_meta($post->ID, 'header-skin', true);
        echo '<textarea id="mc-header-skin" name="header-skin" class="widefat" cols="50" rows="5">' . esc_textarea( $metaHeaderSkin  )  . '</textarea>';
    }

}

