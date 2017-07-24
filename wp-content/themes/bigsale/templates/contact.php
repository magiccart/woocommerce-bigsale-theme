<?php 
/* 
 * Template Name: Contact  
 * */
?>
<?php
    $options        = magiccart_options();
    $layout         = $options['default_layout'];
    $contact        = isset($options['shortcode_contact']) ? $options['shortcode_contact'] : '';
    $classer    = '';
    $row        = '';
    if($layout != 'col1-layout'){
        $row        = 'row';
        $classer    = ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';
    }
?>

<?php get_header(); ?>
<div class="content <?php echo $layout; ?>">
    <div class="container">
        <?php breadcrumbs(); ?>
        <div class="page-content <?php echo $row ?>" >
            <?php  if($layout == 'col2-left-layout' || $layout == 'col3-layout'){ ?> 
                <div class="sidebar-left col-md-3 col-sm-3">
                    <?php dynamic_sidebar('left-sidebar'); ?>
                </div>
            <?php  } ?>
            <div class="<?php echo $classer ?> col-main">
                <div class="contact-form">
                    <?php 
                    echo do_shortcode($contact);
                       // the_content();
                     ?>
                </div>
            </div>
            <?php  if($layout == 'col2-right-layout' || $layout == 'col3-layout'){ ?> 
                <div class="sidebar-right col-md-3 col-sm-3">
                    <?php dynamic_sidebar('right-sidebar'); ?>
                </div>
            <?php  } ?>
        </div><!-- End .page-content -->    
    </div><!--  End .container -->
</div><!--  End .content -->

<?php get_footer(); ?>



