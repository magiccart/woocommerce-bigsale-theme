<ul class="mc-sidebar">
<?php 
    if(is_active_sidebar('left-sidebar-shop')){
        dynamic_sidebar('left-sidebar-shop');
    }else if(is_active_sidebar('right-sidebar-shop')){
        dynamic_sidebar('right-sidebar-shop');
    }else if(is_active_sidebar('left-sidebar-detail')){
        dynamic_sidebar('left-sidebar-detail');
    }else if(is_active_sidebar('right-sidebar-detail')){
        dynamic_sidebar('right-sidebar-detail');
    }else if(is_active_sidebar('left-sidebar')){
        dynamic_sidebar('left-sidebar');
    }else if(is_active_sidebar('right-sidebar')){
        dynamic_sidebar('right-sidebar');
    }else{
        _e('This is sidebar, you have to add some widgets', 'alothemes');
    }

?>
</ul>
