
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
    		<header id="pgl-header" class="pgl- </div>

    			<div class="header-wrapper">
                    <div class="header-wrap container clearfix">
                        <!-- LOGO -->
                        <div class="logo pull-left">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img  width="120" class="img-responsive"  src="<?php echo $theme_option['logo']['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
                            </a>
                        </div>
                        <div class="button-item-action button-menu pull-right hidden-md hidden-lg">
                            <?php pgl_button_off_canvas(); ?>
                        </div>
                        <?php if( isset($theme_option['header-is-search']) && $theme_option['header-is-search'] ): ?>
                        <div class="button-item-action button-search pull-right">
                            <a href="#" class="search-action"><i class="fa fa-search"></i></a>
                        </div>
                        <?php endif; ?>
                        <?php if( isset($theme_option['header-is-login']) && $theme_option['header-is-login'] ): ?>
                        <?php endif; ?>
                        <!-- MENU -->


                        <nav id="pgl-mainnav" data-duration="<?php echo $theme_option['megamenu-duration']; ?>" class="pgl-megamenu hidden-sm <?php echo $theme_option['megamenu-animation']; ?> animate navbar navbar-main" role="navigation">
                            <?php if( isset($theme_option['header-is-login']) && $theme_option['header-is-login'] ): ?>
                            <div class="button-item-action button-login pull-right">
                                <a href="#" class="login-action"><i class="fa fa-user"></i></a>
                            </div>
                            <?php endif; ?>
                            <?php
                                $args = array(  'theme_location' => 'mainmenu',
                                                'container_class' => 'collapse navbar-collapse navbar-ex1-collapse',
                                                'menu_class' => 'nav navbar-nav megamenu pull-right',
                                                'fallback_cb' => '',
                                                'menu_id' => 'main-menu',
                                                'walker' => new PGL_Megamenu()
                                                );
                                wp_nav_menu($args);

                            ?>
                        </nav>
                        <!-- //MENU -->

                    </div>
    			</div>
                <?php do_action('pgl_after_header'); ?>
    		</header>

    		<!-- //HEADER -->




