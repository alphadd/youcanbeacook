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
    		<header id="pgl-header" class="pgl-header header-style3">
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
                    	<div class="row">
                    		<div class="col-xs-4 header-action button-offcanvas">
	                        	<div class="header-action-wrap">
	                        		<?php pgl_button_off_canvas(); ?>
	                        	</div>
	                        </div>
	                        <div class="logo text-center col-xs-4">
	                           <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
	                                <img src="<?php echo $theme_option['logo']['url']; ?>" alt="<?php bloginfo( 'name' ); ?>">
	                            </a>
	                        </div>
	                        <div class="header-action col-sm-4 col-xs-8">
	                        	<div class="header-action-wrap">
	                        		<?php do_action('plg_main_menu_action'); ?>
	                        	</div>
	                        </div>
                    	</div>
                    </div>
    			</div>
                <?php do_action('pgl_after_header'); ?>
    		</header>
            
    		<!-- //HEADER -->




