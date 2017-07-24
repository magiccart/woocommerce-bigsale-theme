<body <?php body_class('woocommerce'); ?> >
    <div id="container-main">
	    <div class="header">
	        <!--======== Settings ========-->
	        <div class="header-top">
	            <div class="container">
		            <div class="wellcome"><?php  echo __('Default wellcome!', 'alothemes'); ?></div>
	                <div class="language-currency top-mobile">
		                <div class="language-link switches">
							<select id="language-link">
								<option value="">English</option>
								<option value="">German</option>
								<option value="">French</option>
								<option value="">Spanish</option>
							</select>
						</div>
						<div class="currency-link switches">
							<select id="currency-link">
								<option value="">USD</option>
								<option value="">EUR</option>
							</select>
						</div>
                    </div>
		            <div class="account-link top-mobile">
		                <ul>
		                    <?php
		                    echo '<li class="menu-item first"><a class="support" href="'. $support .'" title=""><span class="pe-7s-support"></span>'. "Support" .'</a></li>';
		                    if (is_user_logged_in()){
		                        echo '<li class="menu-item "><a class="My-account" href="'. get_permalink( get_option('woocommerce_myaccount_page_id') ) .'" title="'.esc_html__( 'My Account', 'alothemes' ).'"><span class="pe-7s-user"></span>'.esc_html__('My Account','alothemes').'</a></li>';
		                        echo '<li class="menu-item last"><a class="nav-top-link" href="'.wp_logout_url().'" title="'.esc_html__( 'Log Out', 'alothemes' ).'"><span class="pe-7s-unlock"></span>'.esc_html__('Log Out','alothemes').'</a></li>';
		                    }
		                    elseif (!is_user_logged_in()) {
		                        
		                        magiccart_register("<li>", "</li>", true, 'Register');
		                        echo '<li class="menu-item "><a href="'. wp_registration_url() .'" title="'.esc_html__( 'Register', 'alothemes' ).'"><span class="pe-7s-user"></span>'.esc_html__('Register','alothemes').'</a></li>';
		                        echo '<li class="menu-item"><a href="'.get_permalink( get_option('woocommerce_myaccount_page_id') ).'" title="">'.esc_html__('Login','alothemes').'</a></li>';
		                    }?>
		                </ul>
		             </div><!-- End .account-link -->
	             </div> 
	        </div><!-- End .header-top -->
	            <!--======== logo - search - cart ========-->
	        <div class="header-2 header-content">
	            <div class="container">
	            	<div class="row">
	            		<div class="block-support col-lg-4 col-md-4 col-sm-4">
		            		<div class="support">
		            			<div class="support-content">
		            				<p class="support-phone"><?php echo __('support:', 'alothemes'); ?><span><?php echo __('(00)9100 1009', 'alothemes'); ?></span></p>
		            				<p class="support-clock"><?php echo __('Mon - Sat: 8h30am - 5h30pm', 'alothemes'); ?></p>
		            			</div>
		            		</div>
	            		</div>
			            <div class='site-branding col-lg-4 col-md-4 col-sm-4'>
			                <a class="site-logo" href="<?php echo home_url(); ?>" title="<?php echo get_bloginfo('description'); ?>"><?php echo $logo; ?></a>
			            </div><!-- End .site-name -->
			            <div class="tool-header col-lg-4 col-md-4 col-sm-4">
			            	<div class="content-cart">
					            <div class="edit-class-cart cart-toggler tool-minicart tool-icon">
			            			<div class="block-minicart">
			            				<div class="toggle-tab">
							            	<span class="cart-items">
						                	    <span class="your-cart"><?php echo __('Your Cart', 'alothemes'); ?></span>
						                	    <span class="cart-quantitys">
						                			<?php echo WC()->cart->get_cart_contents_count() ?>
						                		</span>
						                	</span>
						                	<i class="fa fa-shopping-basket shopping-basket"></i>
						                	
							            	<div class="mg-minicart toggle-content">
							            		<div class=" widget_shopping_cart_content ">
							            			<?php //include_once 'woocommerce/cart/mini-cart.php'; ?>
							            			<?php woocommerce_mini_cart() ?>
						            			</div>
											</div>
										</div>
									</div><!-- block-minicart dropdown -->
			            		</div> <!-- End .cart-toggler -->
			            		<div class="tool-wishlist tool-icon">
			            			<a href="#" title="My wishlist" class="wishlist icon fa fa-heart-o"></a>
			            		</div>
			            		<div class="tool-search tool-icon">
			            			<div class="toggle-tab-mobile search-dropdown">
						            	<span class="toggle-tab icon mobile"><i class="fa fa-search icons"></i></span>
						            	<div class="toggle-content">
							                <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							                    <input type="hidden" name="post_type" value="product" />
							                    <input name="s" type="text" placeholder="Search everything"/>
							                    <select name="product_cat">
							                        <option value=""><?php  echo __('All Categories', 'alothemes'); ?></option>
							                        <?php 
							                            foreach (all_categories() as $key => $value){
							                                echo "<option value='{$key}'>{$value}</option>";
							                            }
							                        ?>
							                    </select>
							                    <button type="submit"></button>
							                </form>
						                </div>
				            		</div><!-- End .search-dropdown -->
			            		</div>
		            		</div>
	            		</div>
		            </div><!-- end row -->
	            </div>
	        </div><!-- End .header-content -->
	        <!--======== Menu ========-->
	        <div class="header-bottom header-sticker menu">
	            <div class="container">
	            	<div class="vmagicmenu clearfix">
	            		<div class="block-title block-title-vmagicmenu v-title">
	            			<strong>
	            				<span class="fa fa-bars"></span>
	            				<span class="vmagicmenu-subtitle"><?php echo __('Categories', 'alothemes'); ?></span>
	            			</strong>
	            		</div>
		            	<?php
		            		global $outputmobile;
		            		$outputmobile = ''; 
		            		if ( has_nav_menu( 'vertical-menu' ) ) {
			            		wp_nav_menu(array(
										'theme_location'    => 'vertical-menu',
										'items_wrap'        => '<ul id="%1$s" class="%2$s nav-desktop sticker">%3$s
																	<li class="all-cat" style="display:none;"><span>All Categories</span><span style="display: none;">Close</span></li>
																</ul>',
										'mobile'			=> "outputmobile"  // name variable global $outputmobile
								)); 
							} 
						 ?>
					</div>

					 <div class="magicmenu clearfix">                                   
						<?php  
							if ( has_nav_menu( 'top-menu' ) ) {
								wp_nav_menu(array(
										'theme_location'    => 'top-menu',
										'items_wrap'        => '<ul id="%1$s" class="%2$s nav-desktop sticker">%3$s</ul>',
										'mobile'			=> "outputmobile" // name variable global $outputmobile
								));  
							}
						?>	
					 </div>

					<div id="mobileSidenav" class="sidenav menu-mobile">
						<a href="javascript:void(0)" class="closebtn">&times;</a>
						<div class="nav-mobile navigation-mobile clearfix">
							<?php  
								// wp_nav_menu(array(
								// 		'theme_location'    => 'mobile-menu',
								// 		'items_wrap'        => '<ul id="%1$s" class="%2$s">%3$s</ul>'
								// ));  
							?>
							<ul class="menu" ><?php echo $outputmobile ?></ul>
						</div>
					</div>
				</div>
	        </div><!-- End .menu.header-bottom --> 
	    </div>

<?php
	include("newsletter-popup.php");
?>




