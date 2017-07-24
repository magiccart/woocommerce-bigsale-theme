<?php
namespace Magiccart\Portfolio\Controller;

use Magiccart\Core\Controller\Adminhtml\Action;

 class Portfolio extends Action {
 	public function __construct(){
 		add_action('init', array($this, 'portfolio_init'));
 		add_action( 'save_post', array($this, 'wpdocs_save_meta_box'), 10, 3 );
 		add_action( 'add_meta_boxes', array($this, 'wpdocs_register_meta_boxes') );
 	}

 	public function portfolio_init(){
		$labels = array(
			'name'               => _x( 'Portfolio', 'alothemes' ),
			'singular_name'      => _x( 'Portfolio', 'alothemes' ),
			'menu_name'          => _x( 'Portfolio', 'alothemes' ),
			'name_admin_bar'     => _x( 'Book', 'alothemes' ),
			'add_new'            => _x( 'Add New', 'alothemes' ),
			'add_new_item'       => __( 'Add New Portfolio', 'alothemes' ),
			'new_item'           => __( 'New Portfolio', 'alothemes' ),
			'edit_item'          => __( 'Edit Portfolio', 'alothemes' ),
			'view_item'          => __( 'View Portfolio', 'alothemes' ),
			'all_items'          => __( 'All Portfolios', 'alothemes' ),
			'search_items'       => __( 'Search Portfolio', 'alothemes' ),
			'parent_item_colon'  => __( 'Parent Portfolio:', 'alothemes' ),
			'not_found'          => __( 'No Portfolio found.', 'alothemes' ),
			'not_found_in_trash' => __( 'No Portfolio found in Trash.', 'alothemes' )
		);

		$args = array(
			'labels'             => $labels,
	        'description'        => __( 'Magiccart Portfolio .', 'alothemes' ),
	        'menu_icon'			 => 'dashicons-image-filter',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'portfolio' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			//'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			'supports'           => array( 'title', 'editor', 'thumbnail', 'postcustom' )
		);
		register_post_type( 'portfolio', $args );

		$category = array(
	        'name' => _x( 'Portfolio Categories', 'taxonomy general name', 'alothemes' ),
	        'singular_name' => _x( 'Category', 'taxonomy singular name', 'alothemes' ),
	        'search_items' =>  __( 'Search Types', 'alothemes' ),
	        'all_items' => __( 'All Categories', 'alothemes' ),
	        'parent_item' => __( 'Parent Category', 'alothemes' ),
	        'parent_item_colon' => __( 'Parent Category:', 'alothemes' ),
	        'edit_item' => __( 'Edit Categories', 'alothemes' ),
	        'update_item' => __( 'Update Category', 'alothemes' ),
	        'add_new_item' => __( 'Add New Category', 'alothemes' ),
	        'new_item_name' => __( 'New Category Name', 'alothemes' ),
	    );

	    register_taxonomy('portfolio_category', array('portfolio'), array(
	        'hierarchical' => true,
	        'labels' => $category,
	        'show_ui' => true,
	        'query_var' => true,
	        'rewrite' => array( 'slug' => 'portfolio-category' ),
	    ));
	}

	public function wpdocs_register_meta_boxes() {
	    add_meta_box( 'meta-box-skill-needed', __( 'Skill needed', 'alothemes' ), array($this, 'callback_skill_needed'), 'portfolio' );
	    add_meta_box( 'meta-box-url', __( 'Url', 'alothemes' ), array($this, 'callback_url'), 'portfolio' );
	    add_meta_box( 'meta-box-copyright', __( 'Copyright', 'alothemes' ), array($this, 'callback_copyright'), 'portfolio' );
	}

	public function wpdocs_save_meta_box( $post_id, $post, $update  ) {
		if(isset($_POST['portfolio-skill-needed'])){
			update_post_meta($post_id, 'portfolio-skill-needed', $_POST['portfolio-skill-needed']);
		}
		if(isset($_POST['portfolio-url'])){
			update_post_meta($post_id, 'portfolio-url', $_POST['portfolio-url']);
		}
		if(isset($_POST['portfolio-copyright'])){
			update_post_meta($post_id, 'portfolio-copyright', $_POST['portfolio-copyright']);
		}
	}

	public function callback_skill_needed( $post ) {
		$metaSkillNeeded = get_post_meta($post->ID, 'portfolio-skill-needed', true);
	    echo  "<input id='mc-skill-needed' name='portfolio-skill-needed' type='text' value='$metaSkillNeeded' style='width:100%;' />";
	}

	public function callback_url( $post ) {
		$metaUrl = get_post_meta($post->ID, 'portfolio-url', true);
	    echo  "<input id='mc-url' name='portfolio-url' type='text' value='$metaUrl' style='width:100%;' />";
	}

	public function callback_copyright( $post ) {
		$metaCopyright = get_post_meta($post->ID, 'portfolio-copyright', true);
	    echo  "<input id='mc-copyright' name='portfolio-copyright' type='text' value='$metaCopyright' style='width:100%;' />";
	}
}