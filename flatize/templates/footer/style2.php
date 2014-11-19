<div class="footer-top container text-center footer-style2">
    <?php
    	global $theme_option; 
        $menuid = $theme_option['footer_menu'];
        $args = array( 'menu' => $menuid );  
        wp_nav_menu($args);
    ?>
</div>