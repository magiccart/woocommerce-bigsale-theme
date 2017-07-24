<?php
    $options        = magiccart_options();
    $layout         = $options['default_layout'];
    $classer    = '';
    $row        = '';
    if(isset($_GET['layout'])) $layout = $_GET['layout']; //  LAYOUT DEMO
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
            <!-- sidebar -->       
            <?php if($layout == 'col3-layout'){ ?>
                <div class="sidebar sidebar-left col-md-3 col-sm-3">
                    <?php get_sidebar('left'); ?>
                </div>
            <?php } ?>
            <?php $classer .= $layout == 'col2-left-layout' ? ' f-right' : ''; ?>
            
            <div class="<?php echo $classer ?> col-main">
                <?php 
		            _e("<h2>OOPS! THAT PAGE CAN'T BE FOUND. </h2>", 'alothemes');
		           
		            _e('<p>It looks like nothing was found at this location. Maybe try a search?</p>', 'alothemes');
		            get_search_form();
		        ?>
            </div>
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
        </div><!-- End .page-content -->    
    </div><!--  End .container -->
</div><!--  End .content -->

<?php get_footer(); ?>



