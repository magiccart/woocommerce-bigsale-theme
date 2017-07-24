<?php
namespace Magiccart\Widgets\Block\Blog;
class Posts extends \WP_Widget{
	public function __construct(){
		parent::__construct('magiccart-blog-posts',  __('Magiccart Blog Posts', 'alothemes'), array('magiccart-blog-posts'));
	} 
	public function widget($args, $instance){
		 
			$argss = array(
					'numberposts' => $instance['number'],
					'category' => 0, 'orderby' => 'date',
					'order' => 'DESC', 'include' => array(),
					'exclude' => array(), 'meta_key' => '',
					'meta_value' =>'', 'post_type' => 'post',
					'suppress_filters' => true
			);
			
			$posts = get_posts($argss);
			
			echo $args['before_widget'];
			?>
			<div class="blog-post">
					<h3><?php echo $instance['title']?></h3>
					<ul>
						<?php 
							foreach($posts as $key => $value){
								$idImage    = get_post_thumbnail_id($value->ID);
								$image 		= wp_get_attachment_image_src($idImage,'thumbnail');
								if($image){
									$picture 	= "<img src='{$image[0]}' alt='{$value->post_title}' />";
									echo "<li class='item type-product clearfix'>" .'<div class="left-post">'.
											'<a href="'. $value->guid .'"><span class="img-post">' . $picture . '</span></a></div>'
											.'<div class="right-post">'
											. "<p class='title'><a href='". $value->guid ."'>" . $value->post_title . "</a></p>"
											. "<span class='date'>" . date("d M", strtotime($value->post_date)) . " / </span>"
											. "<span class='view'> " . getPostViews($value->ID) ." Views </span>"
											.'</div>'
										. '</li>';
								}
							}
						?>
					</ul>
				</div>
				<?php 
			echo $args['after_widget'];
	} 
	public function form($instance){
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		}else{
			$number = __( 3, 'alothemes' );
		}
		
		if ( isset( $instance[ 'title' ] ) ) {
			$titlePost = $instance[ 'title' ];
		}else{
			$titlePost = __( 'BLOG POSTS', 'alothemes' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $titlePost ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show :' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<?php
				
	}
	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['number'] = ( ! empty( $new_instance['number'] ) ) ? strip_tags( $new_instance['number'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	} 
}