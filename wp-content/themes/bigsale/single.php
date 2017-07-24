<?php 
	$options 	= magiccart_options();
	$layout 	= $options['blog_layout'];
	$blog_view  = isset($options['blog_view']) ? $options['blog_view'] : 'list-view';
	$classer 	= '';
	$row        = '';
	if(is_single()){
        $layout         = $options['single_blog_layout'];
    }
    if(isset($_GET['layout'])) $layout = $_GET['layout']; //  LAYOUT DEMO
	if($layout != 'col1-layout'){
		$row        = 'row';
		$classer 	= ($layout == 'col3-layout') ? 'col-md-6 col-sm-6' : 'col-md-9 col-sm-9';
	}
 
$req = isset($req) ? $req : '';
$commenter['comment_author'] = isset($commenter['comment_author']) ? $commenter['comment_author'] : '';
$aria_req = isset($aria_req) ? $aria_req : '';
$commenter['comment_author_email'] = isset($commenter['comment_author_email']) ? $commenter['comment_author_email'] : '';
$commenter['comment_author_url'] = isset($commenter['comment_author_url']) ? $commenter['comment_author_url'] : '';
$fields =  array(
	'author' =>
		'<p class="comment-form-author"><label for="author">' . __( 'Your name <span>*</span>', 'alothemes' ) . '</label> ' .
		( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30"' . $aria_req . ' /></p>',

		'email' =>
		'<p class="comment-form-email"><label for="email">' . __( 'Your email <span>*</span>', 'alothemes' ) . '</label> ' .
		( $req ? '<span class="required">*</span>' : '' ) .
		'<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" size="30"' . $aria_req . ' /></p>',

		'url' =>
		'<p class="comment-form-url"><label for="url">' . __( 'Your website', 'alothemes' ) . '</label>' .
		'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" size="30" /></p>',
);
$args = array(
	'title_reply' => "leave a comment",
		'logged_in_as' => '',
		'comment_notes_before' => '',
		'fields' => $fields,
		'label_submit'      => __( 'Submit', 'alothemes' ),
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' 
				. __( 'Your comment <span>*</span>', 'alothemes' ) . '</label><br /><textarea id="comment" name="comment" aria-required="true"></textarea></p>',
);

if(get_post_type() == 'testimonial'){
	$argsTestimonial = array( 
		'p'			=> get_the_ID(),
        'post_type' => 'testimonial', 
    );
	$testimonial = new \WP_Query( $argsTestimonial );
}else if(get_post_type() == 'portfolio'){
	$argsPortfolio = array( 
		'p'			=> get_the_ID(),
        'post_type' => 'portfolio', 
    );
	$portfolio = new \WP_Query( $argsPortfolio );
}

?>
<?php get_header(); ?>

<div class="content <?php echo $layout; ?>">
	<div class="container">
		<?php breadcrumbs(); ?>
	    <div class="single-content <?php echo $row ?>" >
	    	<!-- sidebar -->       
	      	<?php if($layout == 'col3-layout'){ ?>
	        	<div class="sidebar sidebar-left col-md-3 col-sm-3">
	            	<?php get_sidebar('left'); ?>
	        	</div>
	      	<?php } ?>
	      	<?php $classer .= $layout == 'col2-left-layout' ? ' f-right' : ''; ?>
	      	
			<div id="single-page" class="<?php echo $classer ?> col-main">
		        <?php 
		        	if(get_post_type() != 'testimonial' && get_post_type() != 'portfolio' ){
			        	if( have_posts()) {
			        		while( have_posts() ) : the_post(); 
		        	?>
			        			<?php setPostViews(get_the_ID()); ?>
					            <?php //get_template_part('content', get_post_format()); ?>
					            <?php get_template_part('content', 'single'); ?>
					            
					            <?php comment_form($args); ?>
					        <?php endwhile ?>
			        <?php 
			    		}else{ 
		            		get_template_part('content', 'none'); 
			        	}
			        	$args = array(
			        				'post_id' => get_the_ID(),
			        			);
				        if(count(get_comments($args)) > 0){
				        	$i = 0;
				        	echo "<ul class='cmt'>";
					        	foreach(get_comments($args) as $key => $value){
					        		if($i > 5) break;
					        		 $xhtml = "<li>";
					        		 $xhtml .= "<img src='". get_avatar_url($value->comment_author_email) ."' class='avt-author' />";
					        		 $xhtml .= "<div title='{$value->comment_author_email}' class='name-author'>{$value->comment_author}</div>";
					        		 $xhtml .= "<span class='date-cmt'>{$value->comment_date}</span>";
					        		 $xhtml .= "<div class='cmt-content'>{$value->comment_content}</div>";
					        		 $xhtml .= "</li>";
					        		 echo $xhtml;
					        		 $i++;
					        	}
				        	echo "</ul>";
				        }
			        }else if(get_post_type() == 'testimonial') {
			        	if( $testimonial->have_posts()) {
			        		while( $testimonial->have_posts() ) : $testimonial->the_post(); 
			        	?>
			        			<?php setPostViews(get_the_ID()); ?>
					            <?php get_template_part('content', 'testimonial'); ?>
						    <?php endwhile ?>
				        <?php 
				    		}else{ 
			            		get_template_part('content', 'none'); 
				        	} 
			        }else if(get_post_type() == 'portfolio') {
			        	if( $portfolio->have_posts()) {
			        		while( $portfolio->have_posts() ) : $portfolio->the_post(); 
			        	?>
			        			<?php setPostViews(get_the_ID()); ?>
					            <?php get_template_part('content', 'portfolio'); ?>
						    <?php endwhile ?>
				        <?php 
				    		}else{ 
			            		get_template_part('content', 'none'); 
				        	} 
			        }

			        ?>
		        
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
	    </div><!-- End .single-content -->
    </div> <!-- End .container -->
</div><!--  End .content -->
<?php get_footer(); ?>