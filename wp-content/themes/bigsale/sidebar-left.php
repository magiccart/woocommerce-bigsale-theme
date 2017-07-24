<ul class="mc-sidebar-left">
<?php 

    if((is_shop() || is_product_category()) && is_active_sidebar('left-sidebar-shop') ){
        dynamic_sidebar('left-sidebar-shop');
    }else if(is_product() && is_active_sidebar('left-sidebar-detail')){
        dynamic_sidebar('left-sidebar-detail');
    }else if(!is_front_page()){
        dynamic_sidebar('left-sidebar');
    }

?>
</ul>
