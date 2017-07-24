<?php
namespace Magiccart\Widgets\Block\Blog;
class Tags extends \WP_Widget{
	public function __construct(){
		parent::__construct('magiccart-blog-tags',  __('Magiccart Blog Tags', 'alothemes'), array('magiccart-blog-tags'));
	} 
	public function widget($args, $instance){
			$argss = array( 'number'  => $instance['number'] );
			echo $args['before_widget'];
			?>
			<div class="blog-tags">
				<h3><?php echo $instance['title']?></h3>
				<div class="magiccart-tag">
					<?php wp_tag_cloud( $argss ); ?>
				</div>
			</div>
			<?php 
			echo $args['after_widget'];
	} 
	public function form($instance){
		if ( isset( $instance[ 'number' ] ) ) {
			$number = $instance[ 'number' ];
		}else{
			$number = __( 10, 'alothemes' );
		}
		
		if ( isset( $instance[ 'title' ] ) ) {
			$titlePost = $instance[ 'title' ];
		}else{
			$titlePost = __( 'BLOG TAGS', 'alothemes' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $titlePost ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of tags to show :' ); ?></label>
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