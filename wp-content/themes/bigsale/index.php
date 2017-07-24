<?php  
    $options        = magiccart_options();
    $blogHeader     = $options['blog_header_text'];
    $layout         = $options['default_layout'];
    $blog_view      = isset($options['blog_view']) ? $options['blog_view'] : 'list-view';
    $row            = '';
    $classer        = '';
    if(is_blog()){
        $layout         = $options['blog_layout'];
    }
    if(isset($_GET['layout'])) $layout = $_GET['layout']; //  LAYOUT DEMO
    if($layout != 'col1-layout'){
        $row        = 'row';
        $classer    = ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';
    }
?>
<?php  get_header(); ?>

<div class="content <?php echo $layout; ?>">
    <div class="container">
    <?php breadcrumbs(); ?>
        <div id="main-content" class="<?php echo $row ?>">
            <?php if($layout == 'col2-left-layout' || $layout == 'col3-layout'){ ?>
                <div class="sidebar sidebar-left col-md-3 col-sm-3">
                    <?php dynamic_sidebar('left-sidebar'); ?>
                </div>
            <?php } ?>   
            
            <div class="<?php echo $classer ?> col-main">    
                <div class="title-page clearfix" >
            		<h2><?php echo $blogHeader; ?></h2>
                    <div class="hd-pagination" >
                		<?php wpbeginner_numeric_posts_nav('<div class="blog-next"></div>', '<div class="blog-prev"></div>'); ?>
                	</div>
                </div>
            	
                <ul class="list-blog <?php echo $blog_view; ?> clearfix">
                    <?php if( have_posts()) : while( have_posts() ) : the_post(); ?>
                        <?php get_template_part('content', get_post_format()); ?>
                    <?php endwhile ?>
                </ul>

                <div class="hd-pagination">
                	<?php wpbeginner_numeric_posts_nav('<div class="blog-next"></div>', '<div class="blog-prev"></div>'); ?>
                </div>
                <?php else: ?>
                    <?php get_template_part('content', 'none'); ?>
                <?php endif; ?>
            </div>

            <?php if($layout == 'col2-right-layout' || $layout == 'col3-layout'){ ?>
                <div class="sidebar sidebar-right col-md-3 col-sm-3">
                    <?php dynamic_sidebar('right-sidebar'); ?>
                </div>
            <?php } ?>
        </div><!-- End #main-content -->
    </div>
</div><!--  End .content -->

<?php get_footer(); ?>

