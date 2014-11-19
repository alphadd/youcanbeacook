<?php

$nav_menu = ! empty( $atts['menu'] ) ? wp_get_nav_menu_object( $atts['menu'] ) : false;
if ( !$nav_menu )
	return;

if($atts['title']!=''){
	echo '<h3 class="title">'.$atts["title"].'</h3>';
}

$args = array(	'menu' => $nav_menu ,
	            'menu_class' => 'megamenu-items',
	            'walker' => new PGL_Megamenu_Sub()
            );
	wp_nav_menu($args);