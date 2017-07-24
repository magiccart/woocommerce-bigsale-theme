<?php 
if(get_the_ID() == "") return; 

if(is_front_page()){
	the_content();
} else {
?>
<?php 
	$metaSkillNeeded = get_post_meta(get_the_ID(), 'portfolio-skill-needed', true);
	$metaUrl = get_post_meta(get_the_ID(), 'portfolio-url', true);
	$metaCopyright = get_post_meta(get_the_ID(), 'portfolio-copyright', true);
	$terms = get_the_terms(get_the_ID(), "portfolio_category");
?>
<article id="post-<?php the_ID()?>"  <?php post_class('post single-post')?> >
    <div class="entry-header">
    	<div class="post-title">
            <h2 class=title-port><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title();?></a> </h2>
        </div>
     </div>
    
    <?php 
    	$idImage    = get_post_thumbnail_id(get_the_ID());
    	$image 		= wp_get_attachment_image_src($idImage, 'medium');
    ?>
    <div class="entry-content">
    	<div class="port-portfolio row">
		<?php if($image[0]){ ?>
			<div class="entry-thumb col-md-7 col-sm-7 col-xs-12"><a href="<?php echo get_post_permalink(get_the_ID()) ?>"><img class="img-title" src='<?php echo $image[0]; ?>' /></a></div>
		<?php } ?>
		<div class="portfolio-content col-md-5 col-sm-5 col-xs-12">
			<div class="description">
				<p><?php echo __('Project description', 'alothemes'); ?></p>
				<span><?php the_content(); ?></span>
			</div>
			<div class="detail">
				<p><?php echo __('Project Details', 'alothemes'); ?></p>
				<?php 
					if($metaSkillNeeded){
						echo '<span class="skill_needed_wrapper">'. __("Skill needed:") 
								.'<span class="skill_needed">'. $metaSkillNeeded .'</span>
							</span>';
					} 
					if(count($terms)){
						$category = "";
						foreach ($terms as $value) {
							$category .= "$value->name ";
						}
						echo '<span class="category_wrapper">'. __("Category:") 
								.'<span class="category">'. $category .'</span>
							</span>';
					} 
					if($metaUrl){
						echo '<span class="url_wrapper">'. __("URL:") 
								.'<span class="url">'. $metaUrl .'</span>
							</span>';
					} 
					if($metaCopyright){
						echo '<span class="copyright_wrapper">'. __("Copyright:") 
								.'<span class="copyright">'. $metaCopyright .'</span>
							</span>';
					} 
				?>
					<span class="date_wrapper"><?php echo __("Date:")  ?>
						<span class="date"> <?php the_date("j,F Y") ?></span>
					</span>
	
				
				

				<!-- ==================== START SOCIAL SHARE ===================== -->
			<div class="addit">
		         <div class="alo-social-links clearfix">
		            <div class="so-facebook so-social-share">
		                <div id="fb-root"></div>
		                <div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="20" data-show-faces="false"></div>
		            </div>
		            <div class="so-twitter so-social-share">
		                <a href="https://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-dnt="true">Tweet</a>
		            </div>
		            <div class="so-plusone so-social-share">
		                <div class="g-plusone" data-size="medium" data-width="20px"></div>
		                <script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		            </div>
		            <?php echo get_simple_likes_button( get_the_ID() ); ?>
		        </div>
		    </div>
	    	<script type="text/javascript">
	    		(function(d, s, id) {
				    var js, fjs = d.getElementsByTagName(s)[0];
				    if (d.getElementById(id)) return;
				    js = d.createElement(s);
				    js.id = id;
				    js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=115245961994281";
				    fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				!function(d,s,id){
				    var js,fjs=d.getElementsByTagName(s)[0];
				    if(!d.getElementById(id)){
				        js=d.createElement(s);
				        js.id=id;
				        js.src="//platform.twitter.com/widgets.js";
				        fjs.parentNode.insertBefore(js,fjs);
				    }
				}(document,"script","twitter-wjs");
	    	</script>
	    	<!-- ==================== END SOCIAL SHARE ===================== -->
	    	
			</div>
		</div>
		</div>
		<div class="related-project">
			<h3> Related Project </h3>
			<?php echo do_shortcode('[magiccart_portfolio portfolio_collection="all" number="99" timer="no" slide="yes" vertical="false" infinite="true" autoplay="true" arrows="false" dots="false" rows="1" speed="300" autoplay-speed="3000" padding="15" mobile="1" portrait="1" landscape="1" tablet="2" notebook="3" desktop="4" visible="4"]'); ?>
		</div>
	</div>
</article>
<?php  } ?>