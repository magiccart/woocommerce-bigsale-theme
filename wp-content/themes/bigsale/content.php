<?php 
$options 	= magiccart_options();
$blogHeader = $options['blog_header_text'];
$layout 	= $options['blog_layout'];
$blog_view  = isset($options['blog_view']) ? $options['blog_view'] : 'list-view';
$row 		= ($blog_view == 'list-view') ? 'row' : '';
$col 		= ($blog_view == 'list-view') ? 'col-xs-12' : 'col-grid';
$clssImg 	= ($blog_view == 'list-view') ? 'col-xs-12 col-sm-5' : '';
$clssExcerpt 	= ($blog_view == 'list-view') ? 'col-xs-12 col-sm-7' : '';
if(get_the_ID() == "") return; 
if(is_front_page() || ( !is_blog() && !is_category() && !is_search()) ){
	the_content();
} else {
?>
<li class="<?php echo $row; ?> content-default">
	<div class="<?php echo $col; ?>">
		<article id="post-<?php the_ID()?>"  <?php post_class('post')?> >
		    <div class="entry-header">
		    	
			        <h3 class="title-post">
			            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title();?></a> 
			        </h3>
		        
		        <?php if(!is_cart() && !is_page()) { ?>
			        <ul class="post-info clearfix">
			        	<li>
			        		<span class="date"><?php echo __('Date: ', 'alothemes'); ?></span>
			        		<span><?php echo get_the_date( "d M, Y", get_the_ID() )?></span>
			        	</li>
			        	<li>
			        		<span class="cate"><?php echo __('Categories: ', 'alothemes'); ?></span>
			        		<?php the_category(); ?>
			        	</li>
			        	<li>
			        		<?php echo __('By: ', 'alothemes'); ?>
			        		<span><?php the_author(); ?></span>
			        	</li>
			        	<li>
			        		<?php echo __('Commet(s): ', 'alothemes'); ?>
			        		<span><?php echo get_post()->comment_count; ?></span>
			        	</li>
			        	<li>
			        		<?php echo __('Viewed: ', 'alothemes'); ?>
			        		<span><?php echo getPostViews(get_the_ID()); ?></span>
			        	</li>
			        </ul>
			    <?php  } ?>
		     </div>
		    
		    <?php 
		    	$idImage    = get_post_thumbnail_id(get_the_ID());
		    	$image 		= wp_get_attachment_image_src($idImage, 'large');
		    ?>
		    <div class="entry-content">
				<div class="<?php echo $row; ?>">
					<?php if($image[0]){ ?>
						<div class="<?php echo $clssImg; ?>"><div class="entry-thumb"><a href="<?php echo the_permalink(); ?>"><img class="image" src='<?php echo $image[0]; ?>' alt="<?php the_title(); ?>" /></a></div></div>
					<?php } ?>
					<?php 
						if(!is_single() && !is_page()){
							echo "<div class='{$clssExcerpt}'>";
								the_excerpt();
							echo "</div>";
						}else{
							the_content();
						}
					?>
					<?php (is_single() ? magiccart_entry_tag() : ''); ?>
				</div> <!-- end row -->
			</div>
		</article>
	</div>
</li>
<?php  } ?>