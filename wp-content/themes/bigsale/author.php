<?php get_header(); ?>
<div class="content">
    <div id="main-content">
        <div class="author-box">
            <?php get_template_part('author-bio'); ?>
        </div>
        <?php if( have_posts()) : while( have_posts() ) : the_post(); ?>
            <?php get_template_part('content', get_post_format()); ?>
        <?php endwhile ?>
        <?php magiccart_pagination(); ?>
        <?php else: ?>
            <?php get_template_part('content', 'none'); ?>
        <?php endif; ?>
    </div><!-- End #main-content -->
    <div id="sidebar">
        <?php get_sidebar(); ?>
    </div>
</div><!--  End .content -->
<?php get_footer(); ?>

