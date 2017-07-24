<?php 
/* 
 * Template Name: Full Width  
 * */
?>

<?php get_header(); ?>

<div class="content page-fullwidth">
    <div class="container">
        <?php
            if(!is_front_page()){
                breadcrumbs();
            }
        ?>
    </div>
        <div class="page-content" >
            <?php if( have_posts()) : while( have_posts() ) : the_post(); ?>
                <?php get_template_part('content', get_post_format()); ?>
            <?php endwhile ?>
            <?php else: ?>
                <?php get_template_part('content', 'none'); ?>
                <?php //the_content(); ?>
            <?php endif; ?>
        </div><!-- End .page-content -->

</div><!--  End .content -->

<?php get_footer(); ?>


