<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <?php wp_head(); ?>
</head>

<?php global $theme_option; ?>
<body <?php body_class(); ?>>

    <?php do_action('pgl_before_wrapper'); ?>

    <!-- START Wrapper -->
	<div class="pgl-wrapper<?php echo apply_filters('pgl_style_layout',''); ?>">
        <div class="wrapper-inner">
    		<!-- HEADER -->
    		<header id="pgl-header" class="pgl-header header-style2">
                <div id="header-topbar">
                    <div class="container">
                        <div class="pull-left hidden-xs text-intro">
                            <?php echo $theme_option['header_text']; ?>
                        </div>
                        <ul class="nav nav-pills nav-top navbar-right">
                            <?php do_action('pgl_topbar_right'); ?>
                        </ul>
                    </div>
                </div>

    			<div class="header-wrapper">
                    <div class="header-wrap container clearfix">
                        <!-- LOGO -->
                        <div class="logo text-center">
                           <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <img src="<?php echo $theme_option['logo']['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                        
                        <!-- MENU -->
                        <nav id="pgl-mainnav" 
                            data-duration="<?php echo $theme_option['megamenu-duration']; ?>" 
                            class="pgl-megamenu <?php echo $theme_option['megamenu-animation']; ?> animate navbar navbar-main" 
                            role="navigation">
                            <?php global $woocommerce; ?>
                            <div class="pull-right">
                                <?php do_action('plg_main_menu_action'); ?>
                            </div>
                            <?php
                                $args = array(  'theme_location' => 'mainmenu',
                                                'container_class' => 'collapse navbar-collapse navbar-ex1-collapse',
                                                'menu_class' => 'nav navbar-nav megamenu',
                                                'fallback_cb' => '',
                                                'menu_id' => 'main-menu',
                                                'walker' => new PGL_Megamenu());
                                wp_nav_menu($args);
                            ?>
                        </nav>
                        <!-- //MENU -->
                        
                    </div>
    			</div>
                <?php do_action('pgl_after_header'); ?>
    		</header>
            
    		<!-- //HEADER -->




