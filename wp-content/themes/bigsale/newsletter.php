<div class="tnp tnp-widget-minimal">
    <form action="<?php echo esc_attr(home_url('/')) . '?na=s';  ?>" method="post" id="newsletter-validate-detail">
            <span class="title">Newsletter: </span>
            <div class="input-box">
                <input type="hidden" name="nr" value="widget-minimal"/>
                <input type="email" required name="ne" id="newsletter" value="" title="Sign up for our newsletter" placeholder="Your email" class="tnp-email">
            </div>
             <button type="submit" title="Subscribe" class="tnp-submit">Subscribe</button>
    </form>
</div>