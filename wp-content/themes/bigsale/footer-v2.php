<?php
    $js        = magiccart_options('add_js');
?>
<script type="text/javascript">
    <?php echo $js; ?>
</script>
<footer>
<div class="footer-container">
    <div id="footer-top">
        <div class="container">
            <div class="row">
            <div class="col-lg-6 col-xs-6 home-newsleter">
                <?php include("newsletter.php"); ?>
            </div>
            <div class="col-lg-6 col-xs-6 home-social">
                <h3 class="title-social">Follow us:</h3>

                <div class="footer-icon-share">
                    <a href="#"><i class="fa fa-facebook icon-share" ></i></a>
                    <a href="#"><i class="fa fa-twitter icon-share" ></i></a>
                    <a href="#"><i class="fa fa-google-plus icon-share" ></i></a>
                    <a href="#"><i class="fa fa-instagram icon-share" ></i></a>
                    <a href="#"><i class="fa fa-wifi icon-share" ></i></a>
                </div>
            </div>
            </div><!-- end row -->
            </div><!--end container-->
        </div>
    <div id="footer-bottom">
            <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <div class="collapsible mobile-collapsible">
                        <h3 class="block-title heading">contact</h3>
                        <span class="toggle-tab mobile" style="display:none"><span class="hidden">hidden</span></span>
                        <div class="block-content block-content-statick toggle-content">
                            <ul class="address">
                                <li class="number-address"><P><span class="street">911 Sounthway Street, Ethan Ellis District San Francisco, United Stated.</span></P></li>
                                <li class="contact"><p><span class="contact-name">Call us:</span><span class="contact-list">9122 4444 555</span></p></li>
                                <li class="contact"><p><span class="contact-name">Email:</span><span class="contact-list">Support@bigsale.com</span></p></li>
                                <li class="contact"><p><span class="contact-name">Opening:</span><span class="contact-list">8:00am - 9:30pm</span></p></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="collapsible mobile-collapsible">
                        <h3 class="block-title heading">My Account</h3>
                        <span class="toggle-tab mobile" style="display:none"><span class="hidden">hidden</span></span>
                        <div class="block-content block-content-statick toggle-content">
                            <ul class="bullet">
                                <li><a href="#">My Orders</a></li>
                                <li><a href="#">My Personal Info</a></li>
                                <li><a href="#">My Credit Slips</a></li>
                                <li><a href="#">My Address</a></li>
                                <li><a href="#">My History</a></li>
                                <li><a href="#">Specials</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="collapsible mobile-collapsible">
                        <h3 class="block-title heading">INFORMATION</h3>
                        <span class="toggle-tab mobile" style="display:none"><span class="hidden">hidden</span></span>
                        <div class="block-content block-content-statick toggle-content">
                            <ul class="bullet">
                                <li><a href="#">Featured</a></li>
                                <li><a href="#">New Arrivals</a></li>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Search Terms</a></li>
                                <li><a href="#">Orders & Returns</a></li>
                                <li><a href="#">Site Map</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                    <div class="collapsible mobile-collapsible">
                        <h3 class="block-title heading">CUSTOMER CARE</h3>
                        <span class="toggle-tab mobile" style="display:none"><span class="hidden">hidden</span></span>
                        <div class="block-content block-content-statick toggle-content">
                            <ul class="bullet">
                                <li><a href="#">Delivery Information</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms & Condition</a></li>
                                <li><a href="#">Buying Guide</a></li>
                                <li><a href="#">Gift Cards</a></li>
                                <li><a href="#">FAQ's&Support Online</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div> <!--end row-->
        </div> <!--end container-->
    </div>
    <div id="footer-copyright">
        <div class="container">
            <div class="license">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <address>
                            &copy;2017 Copyright. All rights reserved.Design by <a class="active" href="<?php echo home_url(); ?>">Bigsale</a>
                        </address>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12">
                        <div class="paypal">
                            <img alt="payment" title="payment" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/payment.jpg">
                        </div>
                    </div>
                </div><!-- end row -->
            </div>
        </div><!--end container-->
    </div>
    <a id="toTop"><i class="fa fa-angle-up"></i></a>
</div> <!--  footer-container -->

</footer>

<?php wp_footer(); ?>

</div> <!-- xczx end-container -->
</body>
</html>


<?php

class Template_Hints {

    public $_included_files = array();

    public $_templates = array();

    public function __construct()
    {
        $this->_included_files = get_included_files(); //get_required_files() - Alias von get_included_files   
        $this->setTemplates();
    }

    // public function addConditon($data){
    //     if(is_array($data)) $this->_condition = array_merge($this->_condition, $data);
    // }

    public function getIncludeFiles($condition=''){
        $total= 0;
        if(!$condition){
            $total = count($this->_included_files);
            foreach ($this->_included_files as $filename) {
                $this->getTemplateHints($filename);
            }      
        } else {
            foreach ($this->_included_files as $filename) {
                if(strpos($filename, $condition)){
                    $this->getTemplateHints($filename);
                    $total++;
                }
            }  
        }

        echo '<h3 style="color:red;background:black;">' .$total. ' Files <b style="color:#fff;">' .$condition. '</b> included.</h3><br/>'; 
    }


    public function getShowTemplateHints(){
        return true;
    }

    public function getTemplateHints($fileName)
    {
        $html ='';
        if ($this->getShowTemplateHints()) {
            $html = '<div style="position:relative; border:1px dotted red; margin:6px 2px; padding:18px 2px 2px 2px; zoom:1;"><div style="position:absolute; left:0; top:0; padding:2px 5px; background:red; color:white; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="'.$fileName.'">'.$fileName.'</div>';
            // $thisClass = (is_object($this)) ? get_class($this) : '';
            // if($thisClass) {
            //     $html .= '<div style="position:absolute; right:0; top:0; padding:2px 5px; background:red; color:blue; font:normal 11px Arial; text-align:left !important; z-index:998;" onmouseover="this.style.zIndex=999" onmouseout="this.style.zIndex=998" title="' .$thisClass. '">' .$thisClass. '</div>';

            // }
            
            // $html .= '</div>';
   
        }

        echo $html;
    }

    public function setTemplates(){
        $included_files = $this->_included_files;
        $filter = DIRECTORY_SEPARATOR . 'themes' .DIRECTORY_SEPARATOR;
        foreach ($included_files as $key => $filename) {
            if(!strpos($filename, $filter)) unset($included_files[$key]);
        }
        $this->_templates = $included_files;

    }

    public function getTemplates($condition=''){
        $total= 0;
        if(!$condition){
            $total = count($this->_templates);
            foreach ($this->_templates as $filename) {
                $this->getTemplateHints($filename);
            }      
        } else {
            foreach ($this->_templates as $filename) {
                if(strpos($filename, $condition)){
                    $this->getTemplateHints($filename);
                    $total++;
                }
            }  
        }

        echo '<h3 style="color:red;background:black;">' .$total. ' Template <b style="color:#fff;">'.$condition.'</b> included.</h3><br/>'; 
    }

    public function getWoocommerceTemplates(){
        $this->getTemplates('woocommerce');
    }

   public function getWoocommercePlugins(){
        $filter = 'plugins' .DIRECTORY_SEPARATOR . 'woocommerce';
        $this->getIncludeFiles($filter);
    }

}

$tmp = new Template_Hints;

//////////// get files

//$tmp->getIncludeFiles(); // Show all files included
//$tmp->getIncludeFiles('woocommerce'); // Show all files woocommerce included
//$tmp->getWoocommercePlugins(); // Show all files in directory woocommerce included

//////////// get Template
// $tmp->getTemplates(); // Show all file in directory themes
// $tmp->getWoocommerceTemplates(); // Show all files in directory themes and of plugin woocommerce included



?>
