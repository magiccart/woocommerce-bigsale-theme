<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package magiccart
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'magiccart_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="footer-container">
            <div id="footer-top">
                <div class="container">
        			<?php
        			/**
        			 * Functions hooked in to magiccart_footer action
        			 *
        			 * @hooked magiccart_footer_widgets - 10
        			 * @hooked magiccart_credit         - 20
        			 */
        			do_action( 'magiccart_footer' ); 
                    ?>
                    <?php
                        $footerId = magiccart_options('footer');
                        if($footerId){
                            $post_footer = get_post($footerId);
                            if($post_footer){
                                $content = apply_filters('the_content', $post_footer->post_content);
                                $content = str_replace(']]>', ']]&gt;', $content);
                                $styles  = get_post_meta( $footerId, 'footer-skin', true );
                                $shortcodes_css = get_post_meta( $footerId, '_wpb_shortcodes_custom_css', true );
                                wp_reset_postdata();
                                echo  $content . '<style type="text/css">' . $shortcodes_css . $styles . '</style>';
                            }
                        }
                    ?>               
                </div>
            </div>

		</div><!-- .footer-container -->
        <a id="toTop"><i class="fa fa-angle-up"></i></a>
	</footer><!-- #colophon -->

	<?php do_action( 'magiccart_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>
<script type="text/javascript"><?php echo magiccart_options('add_js'); ?></script>
</body>
</html>

<?php

// $tmp = new Magiccart\Core\Block\Template\Hints;

////// get files

//$tmp->getIncludeFiles(); // Show all files included
//$tmp->getIncludeFiles('woocommerce'); // Show all files woocommerce included
//$tmp->getWoocommercePlugins(); // Show all files in directory woocommerce included

////// get Template
// $tmp->getTemplates(); // Show all file in directory themes
// $tmp->getWoocommerceTemplates(); // Show all files in directory themes and of plugin woocommerce included

?>
