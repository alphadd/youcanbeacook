<?php

define( 'PGL_THEME_DIR', get_template_directory() );
define( 'PGL_THEME_URI', get_template_directory_uri() );

define( 'PGL_FRAMEWORK_PATH', PGL_THEME_DIR . '/framework/' );
define( 'PGL_FRAMEWORK_URI', PGL_THEME_URI . '/framework/' );

//define( ''flatize'', PGL_THEME_NAME );

define( 'PLG_REDUX_FRAMEWORK_ACTIVED', in_array( 'redux-framework/redux-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
define( 'PLG_WOOCOMMERCE_ACTIVED', in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
define( 'PLG_VISUAL_COMPOSER_ACTIVED', in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );

if(!PLG_REDUX_FRAMEWORK_ACTIVED){
	get_template_part( 'framework/redux-framework/redux-framework' );
}

get_template_part( 'framework/admin/metabox' );

get_template_part( 'framework/metabox/meta-item' );
get_template_part( 'framework/admin/options' );
get_template_part( 'framework/admin/multiple_sidebars' );
get_template_part( 'framework/admin/plugin-activation' );

get_template_part( 'framework/framework' );

get_template_part( 'framework/front/function' );
get_template_part( 'framework/front/shortcode' );

// Widgets
get_template_part( 'framework/widgets/widget-tabs' );
get_template_part( 'framework/widgets/widget-flickr' );

// Post type
get_template_part( 'framework/post-type/testimonial' );

get_template_part( 'framework/megamenu/megamenu' );

get_template_part( 'framework/samples/import' );

/*==========================================================================
Visual Composer
==========================================================================*/
if(PLG_VISUAL_COMPOSER_ACTIVED){
	get_template_part( 'framework/pagebuilder/vc' );
	$_path = PGL_FRAMEWORK_PATH.'pagebuilder/class/';
	$files = glob($_path.'*.php');
	foreach ($files as $key => $file) {
		if(is_file($file)){
			require_once($file);
		}
	}
}

/*==========================================================================
Woocommerce
==========================================================================*/
if(PLG_WOOCOMMERCE_ACTIVED){
	get_template_part( 'framework/woocommerce/woocommerce' );
}
