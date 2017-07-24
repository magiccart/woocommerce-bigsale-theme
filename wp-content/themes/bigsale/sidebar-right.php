<ul class="mc-sidebar-right">
<?php 

    if((is_shop() || is_product_category()) && is_active_sidebar('right-sidebar-shop')){
        dynamic_sidebar('right-sidebar-shop');
    }else if(is_product() && is_active_sidebar('right-sidebar-detail')){
        dynamic_sidebar('right-sidebar-detail');
    }else if(!is_front_page()){
        dynamic_sidebar('right-sidebar');
    }

?>
</ul>
