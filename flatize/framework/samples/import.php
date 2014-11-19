<?php
/*==========================================================================
Button Import
==========================================================================*/
if(!get_option('pgl_installed')){
	add_action( 'admin_notices', 'pgl_button_install_area_notice',1 );
}
function pgl_button_install_area_notice() {  
	$theme = wp_get_theme();
?>
	<div class="updated pgl-import">
		<p><strong>Welcome to <?php echo $theme->get('Name'); ?></strong></p>
		<p class="import-message" style="display:none;">
			<span class="spinner" style="display: inline-block;float:none"></span> 
			<span class="meassage">
				<?php _e('Loading... this could take a couple of minutes, please wait until you get completion message','flatize'); ?>
			</span>
		</p>
		<p>
			<button class="button-primary pgl-install"><?php _e('Install Sample Demo','flatize'); ?></button>
			<button class="button pgl-skip-install"><?php _e('Skip Install','flatize') ?></button>
		</p>
	</div>
	<script type="text/javascript">
		(function($){
			var $import_main = $('.pgl-import');
			var $import_button = $import_main.find('.pgl-install');
			var $import_skip = $import_button.next();
			var $import_message = $import_main.find('.import-message');

			$(document).ready(function(){

				$import_button.click(function(){
					$import_button.prop('disabled',true);
					$import_skip.prop('disabled',true);
					$import_message.show();
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {action: 'pgl_import'},
						success: function(response){
							$.ajax({
								url: ajaxurl,
								type: 'POST',
								data: {action: 'pgl_import_setconfig'},
								success: function(response){
									$import_message.html('<?php echo __('<strong>Sucessfully imported demo data! </strong> Now, please install and run <a href="' . admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=regenerate-thumbnails&amp;TB_iframe=true&amp;width=830&amp;height=472' ) . '" class="thickbox" title="Regenerate Thumbnails">Regenerate Thumbnails</a> plugin once.','flatize'); ?>');
									$import_button.parent().remove();
								}
							});
						}
					});
					return false;
				});

				$import_skip.click(function(){
					$import_main.remove();
					$.ajax({
						url: ajaxurl,
						data: {action: 'pgl_import_skip'},
					});
				});

			});

		})(jQuery);
	</script>
<?php
}

/*==========================================================================
Import Sample Data
==========================================================================*/
add_action( 'wp_ajax_pgl_import_skip','pgl_install_skip' );
add_action('pgl_install_sample_demo','pgl_install_skip');
function pgl_install_skip(){
	if(!get_option('pgl_installed'))
		update_option( 'pgl_installed',true );
	else
		add_action( 'pgl_installed',true );
	die;
}

/*==========================================================================
Import Sample Data
==========================================================================*/
add_action( 'wp_ajax_pgl_import', 'pgl_install_sample_data' );
function pgl_install_sample_data(){
    if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
		require_once ABSPATH . 'wp-admin/includes/import.php';
		$importer_error = false;

	if ( !class_exists( 'WP_Importer' ) ) {
		$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		if ( file_exists( $class_wp_importer ) ){
			require_once($class_wp_importer);
		}
		else{
			$importer_error = true;
		}
	}

	if ( !class_exists( 'WP_Import' ) ) {
		$class_wp_import = PGL_FRAMEWORK_PATH . 'samples/wordpress-importer/wordpress-importer.php';
		if ( file_exists( $class_wp_import ) ){
			require_once($class_wp_import);
		}
		else{
			$importer_error = true;
		}	  
	}

	if($importer_error){
		die("Import error! Please unninstall WP importer plugin and try again");
	}
	else{

		add_filter('intermediate_image_sizes_advanced', create_function('', 'return array();'));

		$wp_import = new WP_Import();
		$wp_import->fetch_attachments = true;
		$filexml = PGL_FRAMEWORK_PATH . 'samples/data/sample.xml';
		ob_start();
		$wp_import->import( $filexml );
		ob_end_clean();

		wp_delete_post(1);

		
	}
	die;
}

/*==========================================================================
Set Configs
==========================================================================*/
add_action( 'wp_ajax_pgl_import_setconfig', 'pgl_install_set_config' );
function pgl_install_set_config(){
	do_action( 'pgl_install_sample_demo' );
}



/*==========================================================================
set Options
==========================================================================*/
add_action('pgl_install_sample_demo','pgl_install_set_options');
function pgl_install_set_options(){
	$path = PGL_FRAMEWORK_PATH . 'samples/options/themeoption.json';
	if(is_file($path)){
		$option = file_get_contents( $path );
	    $all = json_decode($option, true);
	    if(is_array($all)){
	        update_option('theme_option', $all);
	    }
	}
}

/*==========================================================================
set Revslider
==========================================================================*/
if(in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )){
	require_once(ABSPATH .'wp-content/plugins/revslider/revslider_admin.php');
	add_action('pgl_install_sample_demo','pgl_install_set_revslider');
	function pgl_install_set_revslider(){
		$path = PGL_FRAMEWORK_PATH . 'samples/revslider';
		if ($handle = opendir( $path )) {
		    while (false !== ($entry = readdir($handle))) {
		        if ($entry != "." && $entry != "..") {
		            $_FILES['import_file']['tmp_name']= $path . '/' . $entry;
		            $slider = new RevSlider();
					$response = $slider->importSliderFromPost(true, true);
		        }
		    }
		    closedir($handle);
		}
	}
}

/*==========================================================================
Set widget
==========================================================================*/
add_action('pgl_install_sample_demo','pgl_install_set_widget');
function pgl_install_set_widget(){
	global $wp_registered_sidebars;

	$widgets_json = PGL_FRAMEWORK_URI . 'samples/widget/widget_data.json'; // widgets data file
	$widgets_json = wp_remote_get( $widgets_json );

	$json_data = $widgets_json['body'];

	$json_data = json_decode( $json_data, true );
	$sidebars_data = $json_data[0];
	$widget_data = $json_data[1];

	foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

		foreach ( $import_widgets as $import_widget ) :
			//if the sidebar exists
			if ( isset( $wp_registered_sidebars[$import_sidebar] ) ) :
				$title = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
				$index = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
				$current_widget_data = get_option( 'widget_' . $title );
				$new_widget_name = pgl_new_widget_name( $title, $index );
				$new_index = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );

				if ( !empty( $new_widgets[ $title ] ) && is_array( $new_widgets[$title] ) ) {
					while ( array_key_exists( $new_index, $new_widgets[$title] ) ) {
						$new_index++;
					}
				}
				$current_sidebars[$import_sidebar][] = $title . '-' . $new_index;
				if ( array_key_exists( $title, $new_widgets ) ) {
					$new_widgets[$title][$new_index] = $widget_data[$title][$index];
					$multiwidget = $new_widgets[$title]['_multiwidget'];
					unset( $new_widgets[$title]['_multiwidget'] );
					$new_widgets[$title]['_multiwidget'] = $multiwidget;
				} else {
					$current_widget_data[$new_index] = $widget_data[$title][$index];
					$current_multiwidget = $current_widget_data['_multiwidget'];
					$new_multiwidget = isset($widget_data[$title]['_multiwidget']) ? $widget_data[$title]['_multiwidget'] : false;
					$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
					unset( $current_widget_data['_multiwidget'] );
					$current_widget_data['_multiwidget'] = $multiwidget;
					$new_widgets[$title] = $current_widget_data;
				}

			endif;
		endforeach;
	endforeach;
	if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
		update_option( 'sidebars_widgets', $current_sidebars );

		foreach ( $new_widgets as $title => $content )
			update_option( 'widget_' . $title, $content );

		return true;
	}
	return false;
}

function pgl_new_widget_name($widget_name, $widget_index){
	$current_sidebars = get_option( 'sidebars_widgets' );
	$all_widget_array = array( );
	foreach ( $current_sidebars as $sidebar => $widgets ) {
		if ( !empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
			foreach ( $widgets as $widget ) {
				$all_widget_array[] = $widget;
			}
		}
	}
	while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
		$widget_index++;
	}
	$new_widget_name = $widget_name . '-' . $widget_index;
	return $new_widget_name;
}

/*==========================================================================
Set Image Size active theme
==========================================================================*/
add_action('pgl_install_sample_demo','pgl_install_woocommerce_config');
function pgl_install_woocommerce_config() {
	$catalog = array(
		'width' 	=> '270',	// px
		'height'	=> '351',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '500',	// px
		'height'	=> '650',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '80',	// px
		'height'	=> '104',	// px
		'crop'		=> 1 		// true
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog );		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs

	if(PLG_WOOCOMMERCE_ACTIVED){
		// Set pages
        $woopages = array(
            'woocommerce_shop_page_id' => 'Shop',
            'woocommerce_cart_page_id' => 'Cart',
            'woocommerce_checkout_page_id' => 'Checkout',
            'woocommerce_pay_page_id' => 'Checkout &#8594; Pay',
            'woocommerce_thanks_page_id' => 'Order Received',
            'woocommerce_myaccount_page_id' => 'My Account',
            'woocommerce_edit_address_page_id' => 'Edit My Address',
            'woocommerce_view_order_page_id' => 'View Order',
            'woocommerce_change_password_page_id' => 'Change Password',
            'woocommerce_logout_page_id' => 'Logout',
            'woocommerce_lost_password_page_id' => 'Lost Password'
        );
        foreach($woopages as $woo_page_name => $woo_page_title) {
            $woopage = get_page_by_title( $woo_page_title );
            if(isset( $woopage->ID ) && $woopage->ID) {
                update_option($woo_page_name, $woopage->ID); // Front Page
            }
        }

        // We no longer need to install pages
        delete_option( '_wc_needs_pages' );
        delete_transient( '_wc_activation_redirect' );

        // Flush rules after install
        flush_rewrite_rules();
	}
}

add_action('pgl_install_sample_demo','pgl_install_set_reading_pptions');
function pgl_install_set_reading_pptions(){
    $homepage = get_page_by_title( 'Home' );
    //$posts_page = get_page_by_title( 'Blog Large' );
    if( isset( $homepage ) && $homepage->ID ) {
        update_option('show_on_front', 'page');
        @update_option('page_on_front', $homepage->ID); // Front Page
        //@update_option('page_for_posts', $posts_page->ID); // Blog Page
    }
}


/*==========================================================================
Set set menu
==========================================================================*/
add_action('pgl_install_sample_demo','pgl_install_set_menu');
function pgl_install_set_menu(){
	global $wpdb;
	$table_db_name = $wpdb->prefix . "terms";
	$rows = $wpdb->get_results("SELECT * FROM $table_db_name where  name='Megamenu' or name='Account' or name='Menu-topbar'",ARRAY_A);
	$menu_ids = array();
	foreach($rows as $row) {
		$menu_ids[$row["name"]] = $row["term_id"] ;
	}

	if ( !has_nav_menu( 'mainmenu' ) ) {
		set_theme_mod( 'nav_menu_locations', array_map( 'absint', array( 
			'mainmenu' =>$menu_ids['Megamenu'] ,
		) ) );
	}

	// Set Menu Megamenu
	$options = get_option( 'theme_option' );
	$options['megamenu-menu'] = $menu_ids['Megamenu'];
	$options['header_topbar_menu'] = $menu_ids['Menu-topbar'];
	update_option( 'theme_option' , $options );
}

/*==========================================================================
Set set menu
==========================================================================*/
add_action('pgl_install_sample_demo','pgl_install_config_megamenu');
function pgl_install_config_megamenu(){
	$megamenu_json = PGL_FRAMEWORK_URI . 'samples/megamenu/megamenu.json'; // widgets data file
	$megamenu_json = wp_remote_get( $megamenu_json );

	$megamenu_json = json_decode($megamenu_json['body']);

	global $pgl_megamenu;
	$megamenu_widgets = $megamenu_json->widgets;

	if(count($megamenu_widgets)>0){
		foreach ($megamenu_widgets as $key => $value) {
			$pgl_megamenu->insertMegaMenuTable( $value['name'], $value['type'], $value['params'] );
		}
	}

	// // widget
	// if(get_option('PGL_MEGAMENU_DATA')){
	// 	update_option( 'PGL_MEGAMENU_DATA', $megamenu_json->data );
	// }else{
	// 	add_option( 'PGL_MEGAMENU_DATA', $megamenu_json->data );
	// }
}
