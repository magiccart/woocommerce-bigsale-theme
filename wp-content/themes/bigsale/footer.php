<?php
    $file = magiccart_options("file-footer");
    if(is_string($file)){
        include(get_template_directory() . "/" . $file);
    }
?>