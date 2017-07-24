<?php
namespace Magiccart\Widgets\Block\Product;

use  Magiccart\Widgets\Block\Walker\Product_Cat_Dropdown_Walker;

class Recentreviews extends \WC_Widget {

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->widget_cssclass    = 'magiccart widget_recent_reviews';
		$this->widget_description = __( 'Display a list of your most recent reviews on your site.', 'alothemes' );
		$this->widget_id          = 'magiccart_recent_reviews';
		$this->widget_name        = __( 'Magiccart recent reviews', 'alothemes' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Recent reviews', 'alothemes' ),
				'label' => __( 'Title', 'alothemes' ),
			),
			'number' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 10,
				'label' => __( 'Number of reviews to show', 'alothemes' ),
			),
		);

		parent::__construct();
	}

	/**
	 * Output widget.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	 public function widget( $args, $instance ) {
		global $comments, $comment;

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : $this->settings['number']['std'];
		$comments = get_comments( array( 'number' => $number, 'status' => 'approve', 'post_status' => 'publish', 'post_type' => 'product' ) );

		if ( $comments ) {
			$this->widget_start( $args, $instance );

			echo '<ul class="product_list_widget">';

			foreach ( (array) $comments as $comment ) {

				$_product = wc_get_product( $comment->comment_post_ID );

				$rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );

				$rating_html = wc_get_rating_html( $rating );

				echo '<li> <div class="product-thumb"><a href="' . esc_url( get_comment_link( $comment->comment_ID ) ) . '">';

				echo $_product->get_image(). '</a></div>';
				echo '<div class="product-info product-review">';
				echo '<h3 class="product-name">'. wp_kses_post( $_product->get_name() ).'</h3>'; 
				echo $rating_html;

				/* translators: %s: review author */
				echo '<span class="reviewer">' . sprintf( esc_html__( 'by %s', 'alothemes' ), get_comment_author() ) . '</span>';
				echo '</div>';
				echo '</li>';
			}

			echo '</ul>';

			$this->widget_end( $args );
		}

		$content = ob_get_clean();

		echo $content;

		$this->cache_widget( $args, $content );
	}
}
