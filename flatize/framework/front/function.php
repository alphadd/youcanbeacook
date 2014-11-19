<?php

/*==========================================================================
Setup Theme
==========================================================================*/

function plg_theme_setup(){
    load_theme_textdomain( 'flatize', get_template_directory().'/languages' );
    register_nav_menus( array(
        'mainmenu'   => __( 'Main Menu', 'flatize' ),
    ) );

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-formats', array(
       'image', 'video', 'audio', 'gallery',
    ) );
    add_theme_support( "post-thumbnails" );
    add_image_size('blog-mini',360,360,true);

    if ( ! isset( $content_width ) ) $content_width = 900;
}
add_action( 'after_setup_theme', 'plg_theme_setup' );

/*==========================================================================
Require Plugins
==========================================================================*/
add_filter( 'pgl_list_plugins_required' , 'pgl_list_plugins_required' );
function pgl_list_plugins_required($list){
    $path = PGL_FRAMEWORK_PATH . 'plugins/';
    $list[] = array(
                'name'                     => 'WooCommerce', // The plugin name
                'slug'                     => 'woocommerce', // The plugin slug (typically the folder name)
                'required'                 => true, // If false, the plugin is only 'recommended' instead of required
            );
    
    $list[] = array(
                'name'                     => 'Codestyling Localization', // The plugin name
                'slug'                     => 'codestyling-localization', // The plugin slug (typically the folder name)
                'required'                 => true, // If false, the plugin is only 'recommended' instead of required
            );
    
    $list[] = array(
                'name'                     => 'Contact Form 7', // The plugin name
                'slug'                     => 'contact-form-7', // The plugin slug (typically the folder name)
                'required'                 => true, // If false, the plugin is only 'recommended' instead of required
            );
    $list[] = array(
                'name'                     => 'WPBakery Visual Composer', // The plugin name
                'slug'                     => 'js_composer', // The plugin slug (typically the folder name)
                'required'                 => true,
                'source'                   => $path . 'js_composer.zip', // The plugin source
            );
    $list[] = array(
                'name'                     => 'Revolution Slider', // The plugin name
                'slug'                     => 'revslider', // The plugin slug (typically the folder name)
                'required'                 => true, // If false, the plugin is only 'recommended' instead of required
                'source'                   => $path . 'revslider.zip', // The plugin source
            );
     $list[] = array(
                'name'                     => 'YITH WooCommerce Zoom Magnifier', // The plugin name
                'slug'                     => 'yith-woocommerce-zoom-magnifier', // The plugin slug (typically the folder name)
                'required'                 =>  true
            );
    return $list;
}

/*==========================================================================
Styles & Scripts
==========================================================================*/
function init_styles_scripts(){
	$protocol = is_ssl() ? 'https:' : 'http:';

    wp_enqueue_style( 'flatize'.'-style', get_stylesheet_uri() );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
  		wp_enqueue_script( 'comment-reply' );
	}
	wp_enqueue_script("jquery");

	// Add Google Font
	wp_enqueue_style('theme-roboto-slab-font',$protocol.'//fonts.googleapis.com/css?family=Roboto+Slab:400,300,700');
	wp_enqueue_style('theme-raleway-font',$protocol.'//fonts.googleapis.com/css?family=Raleway:400,600,700,300');

	// Css 
	wp_enqueue_style('theme-bootstrap',PGL_THEME_URI.'/css/bootstrap.css',array(),PGL_THEME_VERSION);
	wp_enqueue_style('theme-font-awesome',PGL_THEME_URI.'/css/font-awesome.min.css',array(),PGL_THEME_VERSION);
	wp_enqueue_style('theme-animate',PGL_THEME_URI.'/css/animate.css',array(),PGL_THEME_VERSION);
    wp_enqueue_style('theme-magnific',PGL_THEME_URI.'/css/magnific-popup.css',array(),PGL_THEME_VERSION);
	wp_enqueue_style('theme-css',PGL_THEME_URI.'/css/template.css',array(),PGL_THEME_VERSION);
    wp_enqueue_style('custom-css',PGL_THEME_URI.'/css/custom.php',array(),PGL_THEME_VERSION);

    //Owl Carousel Assets
    wp_enqueue_style('owl-carousel-base',PGL_THEME_URI.'/owl-carousel/owl.carousel.css',array(),PGL_THEME_VERSION);
    wp_enqueue_style('owl-carousel-theme',PGL_THEME_URI.'/owl-carousel/owl.theme.css',array(),PGL_THEME_VERSION);
    wp_enqueue_style('owl-carousel-transitions',PGL_THEME_URI.'/owl-carousel/owl.transitions.css',array(),PGL_THEME_VERSION);
   
	// Scripts
    wp_enqueue_script('theme-gmap-core', $protocol .'//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places' );
    wp_enqueue_script('theme-gmap-api',PGL_THEME_URI.'/js/gmaps.js',array(),PGL_THEME_VERSION);
	wp_enqueue_script('theme-bootstrap',PGL_THEME_URI.'/js/bootstrap.min.js',array(),PGL_THEME_VERSION);
	wp_enqueue_script('theme-scroll_animate',PGL_THEME_URI.'/js/smooth-scrollbar.js',array(),PGL_THEME_VERSION,true);
    wp_enqueue_script('theme-magnific-popup',PGL_THEME_URI.'/js/jquery.magnific-popup.js',array(),PGL_THEME_VERSION,true);
    wp_enqueue_script('owl-carousel_js',PGL_THEME_URI.'/owl-carousel/owl.carousel.js',array(),PGL_THEME_VERSION);
	wp_enqueue_script('theme-magnific_js',PGL_THEME_URI.'/js/jquery.parallax-1.1.3.js',array(),PGL_THEME_VERSION,true);
	wp_enqueue_script('theme-wow_js',PGL_THEME_URI.'/js/jquery.wow.min.js',array(),PGL_THEME_VERSION,true);
	wp_enqueue_script('theme-modernizr_js',PGL_THEME_URI.'/js/modernizr.custom.js',array(),PGL_THEME_VERSION,true);
    wp_enqueue_script('theme-uk_js',PGL_THEME_URI.'/js/uikit.min.js',array(),PGL_THEME_VERSION,true);
	wp_enqueue_script('theme-main_js',PGL_THEME_URI.'/js/main.js',array(),PGL_THEME_VERSION,true);
	
}
add_action( 'wp_enqueue_scripts','init_styles_scripts' );


/*==========================================================================
Single Post
==========================================================================*/
add_action('pgl_post_before_content','pgl_set_post_meta',5);
add_action('pgl_post_before_content','pgl_set_post_thumbnail',10);

add_action('pgl_post_after_content','pgl_single_sharebox',10);
add_action('pgl_post_after_content','pgl_single_related_post',15);
add_action('pgl_post_after_content','pgl_single_author_bio',20);

function pgl_set_post_meta(){
    get_template_part( 'templates/single/meta' );
}

function pgl_set_post_thumbnail(){
    global $post;
    $postid = $post->ID;
    $link_embed = get_post_meta($postid,'_pgl_post_video',true);
    $gallery = get_post_meta( $postid,'_pgl_post_gallery', true );
    $is_thumb = false;
    $content = $output = $start = $end = '';
    
    if( has_post_format( 'video' ) && $link_embed!='' ){
        $content ='<div class="video-responsive">'.wp_oembed_get($link_embed).'</div>';
        $is_thumb = true;
    }else if ( has_post_format( 'audio' ) ){
        $content ='<div class="audio-responsive">'.wp_oembed_get($link_embed).'</div>';
        $is_thumb = true;
    }else if ( has_post_format( 'gallery' ) && $gallery != '' ){
        $count = 0;
        $content =  '<div id="post-slide-'.$postid.'" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">';
        foreach ($gallery as $key => $id){
            $img_src = wp_get_attachment_image_src($key, apply_filters( 'pgl_gallery_image_size','full' ));
            $content.='<div class="item '.(($count==0)?'active':'').'">
                        <img src="'.$img_src[0].'">
                    </div>';
            $count++;
        }
        $content.='</div>
            <a class="left carousel-control" href="#post-slide-'.$postid.'" data-slide="prev"></a>
            <a class="right carousel-control" href="#post-slide-'.$postid.'" data-slide="next"></a>
        </div>';
        $is_thumb = true;
    }else if( has_post_thumbnail() ){
        $content = get_the_post_thumbnail( $postid, apply_filters( 'pgl_single_image_size','full' ) );
        $is_thumb = true;
    }
    

    if( $is_thumb ){
        $start = '<div class="post-thumb">';
        $end = '</div>';
    }

    $output = $start.$content.$end;
    echo $output;
}

function pgl_single_sharebox(){
    ?>
    <div class="post-share">
        <div class="row">
            <div class="col-sm-4">
                <h4 class="heading"><?php echo __( 'Share this Post!','flatize' ); ?></h4>
            </div>
            <div class="col-sm-8">
                <?php get_template_part( 'templates/sharebox' ); ?>
            </div>
        </div>
    </div>
    <?php
}
function pgl_single_related_post(){
    get_template_part('templates/single/related');
}
function pgl_single_author_bio(){
    ?>
    <div class="author-about">
        <?php get_template_part('templates/single/author-bio'); ?>
    </div>
    <?php
}

/*==========================================================================
Sidebar
==========================================================================*/
add_action( 'widgets_init' , 'pgl_sidebar_setup' );
function pgl_sidebar_setup(){
    register_sidebar(array(
        'name'          => __( 'Shop Sidebar','flatize' ),
        'id'            => 'sidebar-left',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Blog Sidebar','flatize' ),
        'id'            => 'sidebar-right',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Footer 1','flatize' ),
        'id'            => 'footer-1',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Footer 1','flatize' ),
        'id'            => 'footer-1',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => __( 'Footer 2','flatize' ),
        'id'            => 'footer-2',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => __( 'Footer 3','flatize' ),
        'id'            => 'footer-3',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => __( 'Footer 4','flatize' ),
        'id'            => 'footer-4',
        'description'   => __( 'Appears on posts and pages in the sidebar.','flatize'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

}

/*==========================================================================
Footer Layout
==========================================================================*/
add_action( 'pgl_footer_layout_style', 'pgl_func_footer_layout_style' );
function pgl_func_footer_layout_style(){
    global $theme_option,$wp_query;
    $pageid = $wp_query->get_queried_object_id();

    $footer = get_post_meta( $pageid , '_pgl_footer_style' , true );
    if($footer=='' || $footer=='global'){
        $footer = $theme_option['footer_layout'];
    }

    get_template_part( 'templates/footer/'.$footer );
}


/*==========================================================================
Header Config
==========================================================================*/
function pgl_get_header(){
	global $theme_option,$wp_query;
    $template = $theme_option['header'];

    if(is_page()){
        $header = get_post_meta( $wp_query->get_queried_object_id(), '_pgl_header_style',true );
        if($header!='global') $template = $header;
    }
    
    get_header($template);
}

/*==========================================================================
Action Theme
==========================================================================*/

add_action( 'pgl_before_wrapper' , 'pgl_menu_offcanvas' );

add_action( 'plg_main_menu_action' , 'pgl_search_login_button' , 10 );

add_action( 'plg_main_menu_action_mobile' , 'pgl_button_off_canvas' , 5 );

add_action( 'plg_main_menu_action_mobile' , 'pgl_search_login_button_mobile' , 15 );

add_action( 'pgl_after_header', 'pgl_search_form', 10 );
add_action( 'pgl_after_header', 'pgl_login_form', 15 );

add_action( 'init', 'pgl_setup_topbar' );

function pgl_setup_topbar(){
    global $theme_option;
    $enable = $theme_option['header_topbar_order']['enabled'];
    unset($enable['placebo']);
    if($enable){
        $enable_priority = 20;
        foreach ($enable as $key => $value) {
            add_action( 'pgl_topbar_right', 'pgl_topbar_widget_'.$key , $enable_priority );
            $enable_priority-=5;
        }
    }
}

function pgl_menu_offcanvas(){
?>
    <div id="pgl-off-canvas" class="uk-offcanvas">
        <?php
            $args = array(  'theme_location' => 'mainmenu',
                'container_class' => 'uk-offcanvas-bar',
                'menu_class' => 'uk-nav uk-nav-offcanvas uk-nav-parent-icon',
                'fallback_cb' => '',
                'menu_id' => 'main-menu-offcanvas',
                'items_wrap' => '<ul id="%1$s" class="%2$s" data-uk-nav>%3$s</ul>',
                'walker' => new PGL_Megamenu_Offcanvas()
            );
            wp_nav_menu($args);
        ?>
    </div>
<?php
}


function pgl_topbar_widget_text(){
    global $theme_option;
    echo '<li class="dropdown pull-right">';
        echo do_shortcode($theme_option['header_topbar_text']);
    echo '</li>';
}

function pgl_topbar_widget_menu(){
    global $theme_option;
    if(isset($theme_option['header_topbar_menu'])){
        $nav_menu =  ($theme_option['header_topbar_menu']!='') ? wp_get_nav_menu_object( $theme_option['header_topbar_menu'] ) : false;
        if($nav_menu){
        ?>
            <li class="dropdown menu-topbar pull-right">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle inner"><?php echo $theme_option['header_topbar_menu_heading']; ?> <b class="caret"></b></a>
                <div class="dropdown-menu">
                    <?php
                        $args = array( 'menu' => $nav_menu );  
                        wp_nav_menu($args);
                    ?>
                </div>
            </li>
        <?php
        }
    }
}


function pgl_button_off_canvas(){
?>
	<a href="javascript:;" class="navbar-toggle off-canvas-toggle" data-uk-offcanvas="{target:'#pgl-off-canvas'}">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
    </a>
<?php
}

function pgl_search_login_button(){
    global $theme_option;
?>
    <?php if( isset($theme_option['header-is-login']) && $theme_option['header-is-login'] ): ?>
	<div class="icon-action mobile-search pull-right"> 
        <a href="#" class="login-action"><i class="fa fa-user"></i></a>
    </div>
    <?php endif; ?>
    <?php if( isset($theme_option['header-is-search']) && $theme_option['header-is-search'] ): ?>
    <div class="icon-action mobile-search pull-right"> 
        <a href="#" class="search-action"><i class="fa fa-search"></i></a>
    </div>
    <?php endif; ?>
    <div class="icon-action mobile-menu-button hidden-md hidden-lg pull-left"> 
        <?php pgl_button_off_canvas(); ?>
    </div>
<?php
}

function pgl_search_login_button_mobile(){
?>
    <?php if( isset($theme_option['header-is-login']) && $theme_option['header-is-login'] ): ?>
	   <a href="#" class="navbar-toggle login-action"><i class="fa fa-user"></i></a>
    <?php endif; ?>
    <?php if( isset($theme_option['header-is-login']) && $theme_option['header-is-login'] ): ?>
        <a href="#" class="navbar-toggle search-action"><i class="fa fa-search"></i></a>
    <?php endif; ?>
<?php
}



function pgl_search_form(){
?>
	<div id="wp-search" class="search-wrapper">
        <div class="container">
            <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                <div class="container-inline">
                    <div class="form-item form-type-textfield form-item-search-block-form">
                        <input class="form-text" type="text" name="s" placeholder="Keywords">
                    </div>
                    <div class="form-actions form-wrapper">
                        <input type="submit" id="searchsubmit" value="Search" class="form-submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php
}

function pgl_login_form(){
    if(PLG_WOOCOMMERCE_ACTIVED){
?>
	<div id="wp-login" class="login-wrapper">
        <h4><?php _e( 'Login', 'woocommerce' ); ?></h4>

        <form method="post" class="pgl_login">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <p class="form-row form-row-wide">
                <label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                <input type="text" class="form-control" name="username" id="username" />
            </p>
            <p class="form-row form-row-wide">
                <label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                <input class="form-control" type="password" name="password" id="password" />
            </p>

            <?php do_action( 'woocommerce_login_form' ); ?>
            <p class="form-row">
                <label for="rememberme" class="inline">
                    <input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
                </label>
            </p>
            <p class="form-row">
                <?php wp_nonce_field( 'woocommerce-login' ); ?>
                <input type="submit" class="btn btn-white btn-sm" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />
            </p>
            <p class="lost_password">
                <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
            </p>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

        </form>
    </div>
<?php
    }
}

