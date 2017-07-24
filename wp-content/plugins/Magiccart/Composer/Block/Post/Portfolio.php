<?php
namespace Magiccart\Composer\Block\Post;
use Magiccart\Composer\Block\Shortcode;

class Portfolio extends Shortcode{
    // **********************************************************************//
    // alothemes Portfolio
    // **********************************************************************//
   public function initShortcode( $atts, $content = null ){
        $this->addData($atts);

        if($this->getData('portfolio_collection')){
            $portfolioID = explode(',', $this->getData('portfolio_collection'));
            
            $this->addData(array('portfolioId' => $portfolioID));
            foreach ($portfolioID as  $value) {
                $query = array();
                if(is_numeric($value)){
                    $query = array( 
                        'post_type' => 'portfolio', 
                        'posts_per_page'    => $this->getData('number'), 
                        'tax_query' => array(
                                        array(
                                            'taxonomy' => 'portfolio_category',
                                            'field'    => 'id',
                                            'terms'    => $value,

                                        )
                                    ),
                    );
                }else{
                    $query = array( 
                        'post_type' => 'portfolio', 
                        'posts_per_page'    => $this->getData('number'), 
                    );
                }
                
                $portfolio = new \WP_Query( $query );

                $this->_portfolio[$value] =  $portfolio;
            }
            return $this->toHtml();
        }
        return __("Please select !", 'alothemes');
    }
}