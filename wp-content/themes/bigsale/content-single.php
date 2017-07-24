<?php 
if(get_the_ID() == "") return; 
if(is_front_page()){
	the_content();
} else {
?>
<div class="row item-blog">
	<div class="col-xs-12">
		<article id="post-<?php the_ID()?>"  <?php post_class('post single-post')?> >
		    <div class="entry-header">
		    	
		            <h3 class="title-post">
		            	<a href="<?php the_permalink() ?>" title="<?php the_title() ?>"><?php the_title() ?></a> 
	            	</h3>
		        
		        <?php if(!is_cart() && !is_page()) { ?>
			        <ul class="post-info clearfix">
			        	<li>
			        		<span class="date"><?php echo __('Date: ', 'alothemes'); ?></span>
			        		<span><?php echo get_the_date( "d M, Y", get_the_ID() )?></span>
			        	</li>
			        	<li>
			        		<span class="cate"><?php echo __('Categories: ', 'alothemes'); ?></span>
			        		<span><?php the_category(); ?></span>
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
				<?php if($image[0]){ ?>
					<div class="entry-thumb"><a href="<?php echo the_permalink(); ?>"><img class="img-title" src='<?php echo $image[0]; ?>' /></a></div>
				<?php } ?>
				<?php 
					if(!is_single() && !is_page()){
						the_excerpt(); 
					}else{
						the_content();
					}
				?>
				<?php (is_single() ? magiccart_entry_tag() : ''); ?>
			</div>
		</article>
	</div>
</div>
<?php  } ?>