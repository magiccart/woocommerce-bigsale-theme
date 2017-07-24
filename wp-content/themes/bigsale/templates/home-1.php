<?php 
/* 
 * Template Name: Home 1
 * */
?>
<?php  get_header(); ?>
<?php 
    $options    = magiccart_options();
    $blogHeader = $options['blog_header_text'];
    $layout     = $options['default_layout'];
    $blog_view  = isset($options['blog_view']) ? $options['blog_view'] : 'list-view';
    $classer    = '';
    $row        = '';
    if($layout != 'col1-layout'){
        $row        = 'row';
        $classer    = ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';
    }   
    $args = array( 
        'post_type' => 'testimonial', 
    );
    $testimonial = new \WP_Query( $args );
?>
<div class="content <?php echo $layout; ?>">
    <div class="container">
        <?php breadcrumbs(); ?>
        <div id="main-content" class="post-content <?php echo $row ?>" >
            <?php if($layout == 'col2-left-layout' || $layout == 'col3-layout'){ ?>
                <div class="sidebar sidebar-left col-md-3 col-sm-3">
                    <?php dynamic_sidebar('left-sidebar'); ?>
                </div>
            <?php } ?>

            <div class="<?php echo $classer ?> col-main">
                <ul class="list-blog <?php echo $blog_view; ?> clearfix">
                    <?php if( $testimonial->have_posts()) : while( $testimonial->have_posts() ) : $testimonial->the_post(); ?>
                        <?php
                            $metaName       = get_post_meta(get_the_ID(), 'testimonial-name', true);
                            $metaCompany    = get_post_meta(get_the_ID(), 'testimonial-company', true);
                            $metaEmail      = get_post_meta(get_the_ID(), 'testimonial-email', true);
                            $metaWebsite    = get_post_meta(get_the_ID(), 'testimonial-website', true);
                            $metaRating     = get_post_meta(get_the_ID(), 'testimonial-rating', true);
                            $metaStatus     = get_post_meta(get_the_ID(), 'testimonial-status', true);
                            $width          = ($metaRating * 2) * 10;
                        ?>
                        <div class='item'>
                            <span class="date"><?php echo __('Date: ', 'alothemes'); ?></span>
                            <span><?php echo get_the_date( "d M, Y", get_the_ID() )?></span>
                            <div class="customer"> <?php the_post_thumbnail('thumbnail') ?> </div>
                            <div class="name"> <?php echo $metaName ?> </div>
                            <div class="testimonial_text"> 
                                <p class="title-name"><?php the_title(); ?></p>
                                <p class="name"><?php $metaName; ?></p></div>
                                 <span class="sub-text"> 
                                    <?php the_excerpt();  ?>
                                 </span>
                                <div class="star-rating" title="Rated <?php echo $metaRating ?> out of 5">
                                    <span style="width:<?php echo $width ?>%">
                                      <strong class="rating"><?php echo $metaRating ?></strong> out of 5
                                    </span>
                                </div>

                        </div>
                    <?php endwhile ?>
                </ul> <!-- list-blog -->
                
                <?php else: ?>
                    <?php get_template_part('content', 'none'); ?>
                <?php endif; ?>
            </div><!-- end col-main-->
            
            <?php if($layout == 'col2-right-layout' || $layout == 'col3-layout'){ ?>
                <div class="sidebar sidebar-right col-md-3 col-sm-3">
                    <?php dynamic_sidebar('right-sidebar'); ?>
                </div>
            <?php } ?>
        </div><!-- End #main-content -->
    </div><!-- end container -->    
</div><!--  End .content -->

<?php get_footer(); ?>

