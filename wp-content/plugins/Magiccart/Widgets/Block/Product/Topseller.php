<?php
namespace Magiccart\Widgets\Block\Product;
class Topseller extends \WP_Widget{
    public function __construct(){
        parent::__construct('magiccart-product-posts',  __('Magiccart Product Top Seller', 'alothemes'), array('magiccart-product-topseller'));
    } 
    public function widget($args, $instance){
            global $woocommerce;
            if(!$woocommerce) return array();
        
            $meta_query   = array();
            $meta_query[] = $woocommerce->query->stock_status_meta_query();
            $meta_query[] = $woocommerce->query->visibility_meta_query();

            /*remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
            remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );*/

            $argsProduct = array(
                'post_type'         => 'product',
                'posts_per_page'    => $instance['number'],
                'post_status'       => 'publish',
                'paged'             => '',
                'meta_key'          => 'total_sales',
                'ignore_sticky_posts' => 1,
                'meta_query'          => array(),
                'meta_query'          => $meta_query,
            );

            $products = new \WP_Query($argsProduct);
            
            echo $args['before_widget'];
            ?>
            <div class="widget-topseller">
                    <h3><?php echo $instance['title']?></h3>
                    <ul class="products-topseller">
                        <?php 
                            
                                if($products->have_posts() ){
                                    $dataArgs['cart']       = 'no';
                                    $dataArgs['compare']    = 'no';
                                    $dataArgs['wishlist']   = 'no';
                                    $dataArgs['review']     = 'no';
                                        while ( $products->have_posts() ) : $products->the_post();
                                            wc_get_template( 'content-product-sidebar.php', $dataArgs); 
                                        endwhile; 
                                }else{
                                    echo '<p class="woocommerce-info">'. __('No products were found matching your selection.', 'alothemes') .'</p>';
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
            $titlePost = __( 'Top Seller', 'alothemes' );
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