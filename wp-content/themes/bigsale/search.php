<?php  get_header(); ?>
<?php 
    $options    = magiccart_options();
    $blogHeader = $options['blog_header_text'];
    $layout     = $options['blog_layout'];
    $blog_view  = isset($options['blog_view']) ? $options['blog_view'] : 'list-view';
    $classer    = '';
    $row        = '';

    if(isset($_GET['layout'])) $layout = $_GET['layout']; //  LAYOUT DEMO
    if($layout != 'col1-layout'){
        $row        = 'row';
        $classer    = ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';
    }   
    $search_query = new WP_Query('s='.$s.'&showpost=-1');
?>
<div class="content <?php echo $layout; ?>">
    <div class="container">
    <?php breadcrumbs(); ?>
        <div class="post-content <?php echo $row ?>" >
              <!-- sidebar -->       
              <?php if($layout == 'col3-layout'){ ?>
                <div class="sidebar sidebar-left col-md-3 col-sm-3">
                     <?php get_sidebar('left'); ?>
                </div>
              <?php } ?>
              <?php $classer .= $layout == 'col2-left-layout' ? ' f-right' : ''; ?>

            <div class="<?php echo $classer ?> col-main">
                <div class="title-page clearfix">
                    <h2><?php echo $blogHeader; ?></h2>
                    <div class="hd-pagination" >
                    <?php wpbeginner_numeric_posts_nav('<div class="blog-next"></div>', '<div class="blog-prev"></div>'); ?>
                    </div>
                </div><!-- title-page -->
                
                <ul class="list-blog <?php echo $blog_view; ?> clearfix">
                    <?php if( $search_query->have_posts()) : while( $search_query->have_posts() ) : $search_query->the_post(); ?>
                        <?php get_template_part('content', "none"); ?>
                    <?php endwhile ?>
                </ul> <!-- list-blog -->
                
                <div class="hd-pagination last clearfix">
                    <?php wpbeginner_numeric_posts_nav('<div class="blog-next"></div>', '<div class="blog-prev"></div>'); ?>
                </div>
                <?php else: ?>
                    <?php get_template_part('content', 'none'); ?>
                <?php endif; ?>
            </div><!-- end col-main-->
            
            <!-- sidebar -->        
            <?php 
                $sidebar = '';
                if($layout == 'col3-layout' || $layout == 'col2-right-layout'){
                    $sidebar = 'right';
                } elseif($layout == 'col2-left-layout')
                    $sidebar = 'left';
                if($sidebar){
            ?>
                <div class="sidebar sidebar-<?php echo $sidebar ?> col-md-3 col-sm-3">
                    <?php get_sidebar($sidebar); ?>
                </div>
            <?php } ?>
        </div>
    </div><!-- end container -->    
</div><!--  End .content -->

<?php get_footer(); ?>



