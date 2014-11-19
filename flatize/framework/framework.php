<?php
global $theme_option;

/*==========================================================================
Required Plugins
==========================================================================*/
function pgl_theme_activation($oldname, $oldtheme=false) {
    wp_redirect('admin.php?page=_options');
}
add_action("after_switch_theme", "pgl_theme_activation", 10, 2);

/*==========================================================================
Required Plugins
==========================================================================*/
function pgl_required_plugins(){
    $config = array(
        'domain'               => 'flatize',             // Text domain - likely want to be the same as your theme.
        'default_path'         => '',                             // Default absolute path to pre-packaged plugins
        'parent_menu_slug'     => 'themes.php',                 // Default parent menu slug
        'parent_url_slug'      => 'themes.php',                 // Default parent URL slug
        'menu'                 => 'install-required-plugins',     // Menu slug
        'has_notices'          => true,                           // Show admin notices or not
        'is_automatic'         => false,                           // Automatically activate plugins after installation or not
        'message'              => '',                            // Message to output right before the plugins table
        'strings'              => array(
            'page_title'                                    => __( 'Install Required Plugins','flatize'),
            'menu_title'                                    => __( 'Install Plugins','flatize'),
            'installing'                                    => __( 'Installing Plugin: %s','flatize'), // %1$s = plugin name
            'oops'                                          => __( 'Something went wrong with the plugin API.','flatize'),
            'notice_can_install_required'                   => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'                => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_install'                         => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
            'notice_can_activate_required'                  => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'               => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                        => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                          => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
            'notice_cannot_update'                          => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
            'install_link'                                  => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                                 => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
            'return'                                        => __( 'Return to Required Plugins Installer','flatize'),
            'plugin_activated'                              => __( 'Plugin activated successfully.' ,'flatize'),
            'complete'                                      => __( 'All plugins installed and activated successfully. %s' ,'flatize'), // %1$s = dashboard link
            'nag_type'                                      => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );
    $plugins = apply_filters( 'pgl_list_plugins_required' , array() );
    tgmpa( $plugins , $config );
}
add_action( 'tgmpa_register','pgl_required_plugins' );

/*==========================================================================
Post View
==========================================================================*/
add_action('wp_head', 'PLG_Framework_SetPostViews' );
function PLG_Framework_SetPostViews() {
    global $post;
    if('post' == get_post_type() && is_single()) {
        $postID = $post->ID;
        if(!empty($postID)) {
            $count_key = 'pgl_post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    }
}

/*==========================================================================
Register Header Meta
==========================================================================*/
add_action('wp_enqueue_scripts', 'PLG_Framework_Register_Meta' ,1);
function PLG_Framework_Register_Meta(){
	global $wp_query,$theme_option;
	$seo_fields = get_post_meta($wp_query->get_queried_object_id(),'pgl_seo',true);
	if($seo_fields==""){
		$seo_fields = array('title'=>'','keywords'=>'','description'=>'');
	}
	if(isset($seo_fields['title']) && trim($seo_fields['title'])!="" && $theme_option['is-seo'] ){
		$seo_fields['title']= get_bloginfo('name').' | '.$seo_fields['title'];
	}else{
		$seo_fields['title']= get_bloginfo('name').(is_front_page() ? ((get_bloginfo('description')!="")?' | '.get_bloginfo('description'):'') :'');
	}

	if(isset($seo_fields['keywords']) && trim($seo_fields['keywords'])==""){
		$seo_fields['keywords']= $theme_option['seo-keywords'];
	}
	if(isset($seo_fields['description']) && trim($seo_fields['description'])==""){
		$seo_fields['description']= $theme_option['seo-description'];
	}
	$output='
<meta charset="'.get_bloginfo( 'charset' ).'">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
if( $theme_option['is-seo'] ){
$output.='<!-- For SEO -->
<meta name="keywords" content="'.$seo_fields['keywords'].'">
<meta name="description" content="'.$seo_fields['description'].'">
<!-- End SEO--> ';
}
$output.='<title>'.$seo_fields['title'].'</title>
<link rel="pingback" href="'.get_bloginfo( 'pingback_url' ).'">';
$link = $theme_option['favicon']['url'];
if($link!=''){
    $output.='<link rel="shortcut icon" href="'.$link.'" type="image/x-icon">';
}
ob_start();
?>
<?php if( isset($theme_option['apple_icon']['url']) && $theme_option['apple_icon']['url']!=''):?>
<link rel="apple-touch-icon" href="<?php echo $theme_option['apple_icon']['url']; ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_57']['url']) && $theme_option['apple_icon_57']['url']!=''):?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo $theme_option['apple_icon_57']['url']; ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_72']['url']) && $theme_option['apple_icon_72']['url']!=''):?>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo $theme_option['apple_icon_72']['url']; ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_114']['url']) && $theme_option['apple_icon_114']['url']!=''):?>
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo $theme_option['apple_icon_114']['url']; ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_144']['url']) && $theme_option['apple_icon_144']['url']!=''):?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo $theme_option['apple_icon_144']['url']; ?>" />
<?php endif;?>
<?php
    $output .= ob_get_clean();
	echo $output;
}

/*==========================================================================
Render Sidebar
==========================================================================*/
function pgl_layout_config_sidebar(){ ?>
    <?php if(apply_filters( 'pgl_is_sidebar_left' , false )){ ?>
        <div class="pgl-sidebar sidebar-left <?php echo apply_filters( 'pgl_sidebar_left_class', 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9' ); ?>">
            <?php $leftsidebar = apply_filters( 'pgl_sidebar_left', '' ); ?>
            <?php if(is_active_sidebar($leftsidebar)): ?>
                <div class="sidebar-inner">
                    <?php dynamic_sidebar($leftsidebar); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php } ?>

    <?php if(apply_filters( 'pgl_is_sidebar_right' , false )){ ?>
        <div class="pgl-sidebar sidebar-right <?php echo apply_filters( 'pgl_sidebar_right_class', 'col-sm-4 col-md-3' ); ?>">
            <?php $rightsidebar = apply_filters( 'pgl_sidebar_right' , '' ); ?>
            <?php if(is_active_sidebar($rightsidebar)): ?>
                <div class="sidebar-inner">
                    <?php dynamic_sidebar($rightsidebar); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php }
}
add_action('pgl_sidebar_render','pgl_layout_config_sidebar');


/*==========================================================================
Layout Config
==========================================================================*/
function pgl_layout_config(){
    global $theme_option,$wp_query;
    $layout = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $layout = $theme_option['woo-shop-layout'];
    }else if( function_exists('is_product') && is_product()){
        $layout = $theme_option['woo-single-layout'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $layout = get_post_meta( $page_id, '_pgl_page_layout', true );
    }else{
        $layout = $theme_option['blog-layout'];
    }

    add_filter( 'pgl_sidebar_right' , 'pgl_set_sidebar_right' );
    add_filter( 'pgl_sidebar_left' , 'pgl_set_sidebar_left' );

    switch ($layout) {
        // Two Sidebar
        case '4':
            add_filter( 'pgl_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'pgl_sidebar_right_class' , create_function('', 'return "col-sm-6  col-md-3";') );
            add_filter( 'pgl_main_class' , create_function('', 'return "col-md-6 col-md-push-3";') );
            add_filter( 'pgl_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'pgl_is_sidebar_right', create_function('', 'return true;') );
            break;
        //One Sidebar Right
        case '3':
            add_filter( 'pgl_sidebar_right_class' , create_function('', 'return "col-sm-4  col-md-3";') );
            add_filter( 'pgl_main_class' , create_function('', 'return "col-sm-8 col-md-9";') );
            add_filter( 'pgl_is_sidebar_right', create_function('', 'return true;') );
            break;
        // One Sidebar Left
        case '2':
            add_filter( 'pgl_sidebar_left_class' , create_function('', 'return "col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9";') );
            add_filter( 'pgl_main_class' , create_function('', 'return "col-sm-8 col-sm-push-4 col-md-9 col-md-push-3";') );
            add_filter( 'pgl_is_sidebar_left', create_function('', 'return true;') );
            break;

        case '6':
            add_filter( 'pgl_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3";') );
            add_filter( 'pgl_sidebar_right_class' , create_function('', 'return "col-sm-6 col-md-3";') );
            add_filter( 'pgl_main_class' , create_function('', 'return " col-md-6";') );
            add_filter( 'pgl_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'pgl_is_sidebar_right', create_function('', 'return true;') );
            break;

        case '5':
            add_filter( 'pgl_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'pgl_sidebar_right_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'pgl_main_class' , create_function('', 'return "col-md-6 col-md-push-6";') );
            add_filter( 'pgl_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'pgl_is_sidebar_right', create_function('', 'return true;') );
            break;

        // Fullwidth
        default:
            add_filter( 'pgl_main_class' , create_function('', 'return "col-xs-12";') );
            add_filter( 'pgl_is_sidebar_left', create_function('', 'return false;') );
            add_filter( 'pgl_is_sidebar_right', create_function('', 'return false;') );
            break;
    }
}
add_action('wp_head','pgl_layout_config');

/*==========================================================================
Layout Sidebar
==========================================================================*/
function pgl_set_sidebar_right(){
    global $theme_option,$wp_query;
    $sidebar = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        if(is_single()){
            $sidebar = $theme_option['woo-shop-sidebar'];
        }else{
            $sidebar = $theme_option['woo-shop-sidebar'];
        }
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $sidebar = get_post_meta( $page_id, '_pgl_page_right_sidebar', true );
    }else{
        $sidebar = $theme_option['blog-right-sidebar'];
    }
    return $sidebar;
}

function pgl_set_sidebar_left(){
    global $theme_option,$wp_query;
    $sidebar = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        if(is_single()){
            $sidebar = $theme_option['woo-shop-sidebar'];
        }else{
            $sidebar = $theme_option['woo-shop-sidebar'];
        }
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $sidebar = get_post_meta( $page_id, '_pgl_page_left_sidebar', true );
    }else{
        $sidebar = $theme_option['blog-left-sidebar'];
    }
    return $sidebar;
}


/*==========================================================================
Enable Effect Scroll
==========================================================================*/
if(isset($theme_option['is-effect-scroll']) && $theme_option['is-effect-scroll'] ){
    add_filter('body_class','pgl_enable_effect_scroll');
    function pgl_enable_effect_scroll($classes){
        $classes[] = 'pgl-animate-scroll';
        return $classes;
    }
}

/*==========================================================================
Back To Top
==========================================================================*/
if(isset($theme_option['is-back-to-top']) && $theme_option['is-back-to-top'] ){
    add_filter('pgl_after_wrapper','pgl_back_to_top_button');
    function pgl_back_to_top_button(){
    ?>
        <a class="scroll-to-top visible" href="#" id="scrollToTop">
            <i class="fa fa-angle-up"></i>
        </a>
    <?php
    }
}

/*==========================================================================
Ajax Url
==========================================================================*/
add_action('wp_head','pgl_framework_init_ajax_url',15);
function pgl_framework_init_ajax_url() {
?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
	</script>
	<?php
}

/*==========================================================================
Fix HTML5/Css3
==========================================================================*/
add_action('wp_head','pgl_framework_check_HTML5',100);
function  pgl_framework_check_HTML5(){
	?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
<![endif]-->
	<?php
}

/*==========================================================================
Fix Vimeo
==========================================================================*/
add_action('init','pgl_framework_add_vimeo_oembed_correctly');
function pgl_framework_add_vimeo_oembed_correctly() {
    wp_oembed_add_provider( '#http://(www\.)?vimeo\.com/.*#i', 'http://vimeo.com/api/oembed.{format}', true );
}

/*==========================================================================
Fix Embed
==========================================================================*/
add_filter( 'oembed_result', 'pgl_framework_fix_oembeb' );
function pgl_framework_fix_oembeb( $url ){
    $array = array (
        'webkitallowfullscreen'     => '',
        'mozallowfullscreen'        => '',
        'frameborder="0"'           => '',
        '</iframe>)'        => '</iframe>'
    );
    $url = strtr( $url, $array );

    if ( strpos( $url, "<embed src=" ) !== false ){
        return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $url);
    }
    elseif ( strpos ( $url, 'feature=oembed' ) !== false ){
        return str_replace( 'feature=oembed', esc_url('feature=oembed&wmode=opaque'), $url );
    }
    else{
        return $url;
    }
}

/*==========================================================================
Remove Shortcode gallery
==========================================================================*/
add_shortcode('gallery', '__return_false');

/*==========================================================================
Search Filter
==========================================================================*/
add_filter('pre_get_posts','pgl_framework_search_filter');
function pgl_framework_search_filter($query) {
    if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
        $query->is_search = true;
        $query->is_home = false;
    }
	return $query;
}

/*==========================================================================
Add Shortcode Widget Text
==========================================================================*/
add_filter('widget_text', 'do_shortcode');

/*==========================================================================
Remove Dimension Image
==========================================================================*/
add_filter( 'post_thumbnail_html', 'pgl_framework_remove_thumbnail_dimensions' , 10, 3 );
function pgl_framework_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}

function _de($value,$die = false){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    if($die) die();
}


/*==========================================================================
Set Custom CSS/JS
==========================================================================*/
function pgl_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return implode(',', $rgb); // returns an array with the rgb values
}

function pgl_rgb2hex($rgb) {
    $rgb = explode(',', $rgb);
    $hex = "#";
    $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

    return $hex; 
}

function pgl_adjustColorLightenDarken($color_code,$percentage_adjuster = 0) {
    $percentage_adjuster = round($percentage_adjuster/100,2);
    if(is_array($color_code)) {
        $r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
        $g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
        $b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);

        return array("r"=> round(max(0,min(255,$r))),
            "g"=> round(max(0,min(255,$g))),
            "b"=> round(max(0,min(255,$b))));
    }
    else if(preg_match("/#/",$color_code)) {
        $hex = str_replace("#","",$color_code);
        $r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
        $g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
        $b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
        $r = round($r - ($r*$percentage_adjuster));
        $g = round($g - ($g*$percentage_adjuster));
        $b = round($b - ($b*$percentage_adjuster));

        return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);

    }
}

add_action('wp_head','pgl_framework_custom_style_css',98);
function pgl_framework_custom_style_css(){
    global $theme_option;
    echo '<style type="text/css" id="pgl-color-style">';
        get_template_part( 'css/color' );
    echo '</style>';
}

add_action('wp_head','pgl_framework_init_custom_code',99);
function pgl_framework_init_custom_code(){
	global $theme_option;
    $str = '';
	if($theme_option['custom-css']!=''){
		$str.='
		<style type="text/css">'.$theme_option['custom-css'].'</style>';
	}
	if($theme_option['custom-js']!=''){
		$str.='
		<script type="text/javascript">'.$theme_option['custom-js'].'</script>';
	}
	echo $str;
}

/*==========================================================================
Add Scripts Admin
==========================================================================*/
add_filter( 'pgl_style_layout','pgl_framework_style_layout' );
function pgl_framework_style_layout(){
    global $theme_option,$wp_query;
    if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $layout = get_post_meta( $page_id, '_pgl_layout_style',true );
        if( $layout=='boxed' ){
            return ' container';
        }
    }
    
    if(isset($theme_option['style_layout']) && $theme_option['style_layout']=='boxed'){
        return ' container';
    }
    return '';
}

/*==========================================================================
Header Sticky
==========================================================================*/
add_filter( 'body_class', 'pgl_header_sticky' );
function pgl_header_sticky($classes){
    global $theme_option,$wp_query;
    $page_id = $wp_query->get_queried_object_id();
    $layout = get_post_meta( $page_id, '_pgl_layout_style',true );
    if( ($layout=='' || $layout == 'global') && isset($theme_option['style_layout']) ){
        $classes[] = $theme_option['style_layout'];
    }else{
         $classes[] = $layout;
    }
    if( isset($theme_option['header-is-sticky']) && $theme_option['header-is-sticky'] ){
        $classes[] = 'header-sticky';
    }
    
    return $classes;
}


/*==========================================================================
Add Scripts Admin
==========================================================================*/
add_action( 'admin_enqueue_scripts', 'pgl_framework_init_script' ,10 );
function pgl_framework_init_script(){
    wp_enqueue_script( 'pgl_framework_js', PGL_FRAMEWORK_URI . 'admin/js/main.js' );
    wp_enqueue_style( 'pgl_framework_js' , PGL_FRAMEWORK_URI . 'admin/css/main.css' );
}

/*==========================================================================
						Function Define
==========================================================================*/

function pgl_getAgo($timestamp){
	// return $timestamp;
	$timestamp = strtotime($timestamp);
	$difference = time() - $timestamp;

    if ($difference < 60) {
        return $difference.__(" seconds ago",'flatize');
    } else {
        $difference = round($difference / 60);
    }

    if ($difference < 60) {
        return $difference.__(" minutes ago",'flatize');
    } else {
        $difference = round($difference / 60);
    }

    if ($difference < 24) {
        return $difference.__(" hours ago",'flatize');
    }
    else {
        $difference = round($difference / 24);
    }

    if ($difference < 7) {
        return $difference.__(" days ago",'flatize');
    } else {
        $difference = round($difference / 7);
        return $difference.__(" weeks ago",'flatize');
    }
}

function pgl_get_excerpt($limit,$afterlimit='[...]') {
	$excerpt = get_the_excerpt();
    if($excerpt != ''){
	   $excerpt = explode(' ', strip_tags($excerpt), $limit);
    }else{
        $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
    }
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).' '.$afterlimit;
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return strip_shortcodes( $excerpt );
}

function pgl_list_comments($comment, $args, $depth){
    $path = PGL_THEME_DIR . '/templates/list_comments.php';
    if( is_file($path) ) require ($path);
}

function pgl_make_id($length = 5){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function pgl_comment_form($arg,$class='btn-primary',$id='submit'){
	ob_start();
	comment_form($arg);
	$form = ob_get_clean();
	echo str_replace('id="submit"','id="'.$id.'" class="btn '.$class.'"', $form);
}

function pgl_get_post_views($postID){
    $count_key = 'pgl_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}

function pgl_share_box( $layout='',$args=array() ){
	$default = array(
		'position' => 'top',
		'animation' => 'true'
		);
	$args = wp_parse_args( (array) $args, $default );
}

function pgl_embed() {
    $link = get_post_meta(get_the_ID(),'_pgl_post_video',true);
    echo  wp_oembed_get($link);
}

function pgl_gallery($size='full'){
    $output = array();
    $galleries = get_post_gallery( get_the_ID(), false );
    if(isset($galleries['ids'])){
        $img_ids = explode(",",$galleries['ids']);
        foreach ($img_ids as $key => $id){
            $img_src = wp_get_attachment_image_src($id,$size);
            $output[] = $img_src[0];
        }
    }
    return $output;
}

//page navegation
function pgl_pagination($prev = 'Prev', $next = 'Next', $pages='' ,$args=array('class'=>'')) {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    if($pages==''){
        global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
    }
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $pages,
        'current' => $current,
        'prev_text' => __($prev,'flatize'),
        'next_text' => __($next,'flatize'),
        'type' => 'array'
    );
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
    if(paginate_links( $pagination )!=''){
        $paginations = paginate_links( $pagination );
        echo '<ul class="pagination '.$args["class"].'">';
            foreach ($paginations as $key => $pg) {
                echo '<li>'.$pg.'</li>';
            }
        echo '</ul>';
    }
}


function pgl_string_limit_words($string, $word_limit){
    $words = explode(' ', $string, ($word_limit + 1));

    if(count($words) > $word_limit) {
        array_pop($words);
    }

    return implode(' ', $words);
}