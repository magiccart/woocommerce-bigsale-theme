<?php
	$options 			= magiccart_options();
	$widthPopup 		= isset($options['popup-maxwidth']) ? $options['popup-maxwidth'] : 400;
	$heightPopup 		= isset($options['popup-maxheight']) ? $options['popup-maxheight'] : 300;
	$popupBackground 	= isset($options['popup-background']['url']) ? $options['popup-background']['url'] : '';
?>

<?php  if($options['popup-action'] && is_front_page()) {  ?>
	<ul id="inline-popups" data-popup-cookie="<?php echo $options['popup-cookie'] ?>" data-popup-delay="<?php echo $options['popup-delay'] ?>">
		<li><a href="#test-popup" data-effect="mfp-3d-unfold">3d unfold Popup</a></li>
	</ul>
	<div id="test-popup" style="max-width: <?php echo $widthPopup; ?>px;
							  max-height: <?php echo $heightPopup; ?>px;
							  background-image: url(<?php echo $popupBackground; ?>);" class="newsletter-popup mfp-with-anim mfp-hide">
		<?php if(isset($options['popup-content']) && $options['popup-content'] != "") { ?>
			<div class="popup-content">
				<?php print_r($options['popup-content']); ?>
			</div>
		<?php } ?>
		<div class="popup-newsleter">
			<h2 class="newsleter-title"><?php echo __("subscirbe now to get started with our best offers at all your time", 'alothemes'); ?></h2>
	        <div class="tnp tnp-widget-minimal">
			    <form action="<?php echo esc_attr(home_url('/')) . '?na=s';  ?>" method="post" id="newsletter-validate-detail">

		            <span class="title"><?php echo __("Newsletter", 'alothemes'); ?>: </span>
		            <div class="form-subscribe clearfix">
			            <div class="input-box">
			                <input type="hidden" name="nr" value="widget-minimal"/>
			                <input type="email" required name="ne" id="newsletter" value="" title="Sign up for our newsletter" placeholder="Your email" class="tnp-email">
			            </div>
			            <div class="action">
			            	<button type="submit" title="Subscribe" class="tnp-submit"><span><?php echo __("Subscribe", 'alothemes'); ?></span></button>
			            </div>
	            	</div>
			    </form>
			</div>
	    </div>
	    <div class="social-checkbox clearfix">
		    <div class="socials block-social">
		    	<div class="block-title"><?php echo __("Or connect with", 'alothemes'); ?>:</div>
		    	<div class="icon-share">
					<a href="#" class="social-link">
						<span class="fa fa-facebook">
							<span class="hidden">hidden</span>
						</span>
					</a>
					<a href="#" class="social-link">
						<span class="fa fa-twitter">
							<span class="hidden">hidden</span>
						</span>
					</a>
					<a href="#" class="social-link">
						<span class="fa fa-pinterest">
							<span class="hidden">hidden</span>
						</span>
					</a>
					<a href="#" class="social-link">
						<span class="fa fa-youtube-play">
							<span class="hidden">hidden</span>
						</span>
					</a>
					<a href="#" class="social-link">
						<span class="fa fa-instagram">
							<span class="hidden">hidden</span>
						</span>
					</a>
		    	</div>
		    </div>
		    <div class="checkbox btn-checkbox">
		    	<label>
                    <input class="disabled_popup_by_user" value="disabled_popup" type="checkbox">
                    <span><?php echo __("Dont show this popup again", 'alothemes'); ?></span>
                </label>
		    </div>
	    </div>
	</div>
<?php } ?>
