<?php

/*==========================================================================
Init Megamenu
==========================================================================*/
define( 'PGL_MEGAMENU_PATH', PGL_FRAMEWORK_PATH.'megamenu/' );

define( 'PGL_MEGAMENU_URL', PGL_FRAMEWORK_URI.'megamenu/' );

define( 'PGL_MEGAMENU_WIDGET', PGL_MEGAMENU_PATH .'widgets' );

define( 'PGL_MEGAMENU_TEMPLATE', PGL_MEGAMENU_PATH.'widget_templates' );

require_once ( PGL_MEGAMENU_PATH . 'includes/params.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-sub.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-offcanvas.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-widget.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/shortcodebase.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/shortcodes.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-setting.php' );


if(!class_exists('PGL_MegamenuEditor')){
	class PGL_MegamenuEditor{

		public static function getInstance(){
			static $_instance;
			if( !$_instance ){
				$_instance = new PGL_MegamenuEditor();
			}
			return $_instance;
		}

		public function __construct(){
			
			add_action('admin_menu', array( $this, 'adminLoadMenu') );
			add_action( 'admin_enqueue_scripts',array($this,'initScripts') );
			add_action( 'wp_enqueue_scripts',array($this,'initFrontScripts') );
			add_action( 'admin_init', array( $this,'register_megamenu_setting') );
			add_action('wp_update_nav_menu_item', array($this,'fields_nav_update'),10, 3);
			add_filter( 'wp_setup_nav_menu_item',array($this,'fields_nav_item') );


			$this->initAjaxMegamenu();
		}

		public function adminLoadMenu(){
			add_theme_page( 'flatize' .' | Megamenu', $this->l("Megamenu Editor"), 'switch_themes', 'pgl_megamenu', array($this,'megaMenuPage') );
		}

		public function megaMenuPage(){
  			$wpos = PGL_Shortcodes::getInstance();
  			$widgets = PGL_Megamenu_Widget::getInstance()->getWidgets();
			require( PGL_MEGAMENU_PATH. 'template/editor.php' );
		}

		/*
		 * Saves new field to postmeta for navigation
		 */
		public function fields_nav_update($menu_id, $menu_item_db_id, $args ) {
			$configs = apply_filters( 'pgl_menu_custom_configs',array() );
			foreach ($configs as $config) {
				if ( is_array($_REQUEST['menu-item-'.$config['value']]) ) {
			        $value = $_REQUEST['menu-item-'.$config['value']][$menu_item_db_id];
			        update_post_meta( $menu_item_db_id, '_menu_item_'.$config['value'], $value );
			    }
			}
		}

		/*
		 * Adds value of new field to $item object that will be passed to     Walker_Nav_Menu_Edit_Custom
		 */
		public function fields_nav_item($menu_item) {
			$configs = apply_filters( 'pgl_menu_custom_configs',array() );
			foreach ($configs as $config) {
				$menu_item->$config['value'] = get_post_meta( $menu_item->ID, '_menu_item_'.$config['value'], true );
			}
		    return $menu_item;
		}

		public function initAjaxMegamenu(){
			add_action( 'wp_ajax_pgl_shortcode_button', array($this,'ajax_shortcode_button') );
			add_action( 'wp_ajax_pgl_shortcode_save', array($this,'ajax_shortcode_save') );
			add_action( 'wp_ajax_pgl_shortcode_delete', array($this,'ajax_shortcode_delete') );
			add_action( 'wp_ajax_pgl_list_shortcodes', array($this,'showListShortCodes') );
			add_action( 'wp_ajax_pgl_post_embed', array($this,'initAjaxPostEmbed') );
		}

		public function initAjaxPostEmbed(){
			if ( !$_REQUEST['oembed_url'] )
				die();
			// sanitize our search string
			global $wp_embed;
			$oembed_string = sanitize_text_field( $_REQUEST['oembed_url'] );
			$oembed_url = esc_url( $oembed_string );
			$check_embed = wp_oembed_get(  $oembed_url  );
			if($check_embed==false){
				$check = false;
				$result ='not found';
			}else{
				$check = true;
				$result = $check_embed;
			}
			echo json_encode( array( 'check' => $check,'video'=>$result ) );
			die();
		}

		public function initScripts(){
			if( isset($_GET['page']) && $_GET['page']=='pgl_megamenu' ){
				wp_enqueue_style('megamenu_bootstrap_css',PGL_MEGAMENU_URL.'assets/css/bootstrap.min.css');
				wp_enqueue_script('base_bootstrap_js',PGL_MEGAMENU_URL.'assets/js/bootstrap.min.js');
		 		wp_enqueue_script('media-models');
				wp_enqueue_script('media-upload');
				wp_enqueue_script('pgl_megamenu_js',PGL_MEGAMENU_URL.'assets/js/megamenu.js',array());
				wp_enqueue_style( 'pgl_megamenu_css',PGL_MEGAMENU_URL.'assets/css/megamenu.css');
				wp_enqueue_style( 'pgl_shortcode_css',PGL_MEGAMENU_URL.'assets/css/shortcode.css');
				wp_enqueue_script('pgl_shortcode_js',PGL_MEGAMENU_URL.'assets/js/shortcode.js',array());
			}
		}

		public function register_megamenu_setting() {
			if( isset($_GET['page']) && $_GET['page'] == 'pgl_megamenu' && isset($_POST) ){
				if( isset($_GET['renderwidget']) && $_GET['renderwidget'] ){
				// 	var_dump( $_POST, 1 );die;

					if( isset($_POST['widgets']) ){

						$widgets =$_POST['widgets'];
						$widgets = explode( '|wid-', '|'.$widgets );
						if( !empty($widgets) ){
							$dwidgets = PGL_Megamenu_Widget::getInstance()->loadWidgets();
							$shortcode =   PGL_Shortcodes::getInstance();
							unset( $widgets[0] );
							$output = '';
							foreach( $widgets as $wid ){
								$o = $dwidgets->getWidgetById( $wid );
								if( $o ){
									$output .= '<div class="pgl-widget" id="wid-'.$wid.'">';
									$output .= $shortcode->getButtonByType( $o->type, $o );
									$output .= '</div>';
								}
							}
							echo $output;
						}
					}
					exit();
				}
				if( isset($_POST['params']) && !empty($_POST['params']) ) {
					$params =  $_POST['params'];
					$params = str_replace( "/","",stripslashes(trim(html_entity_decode( $params ))) );
					if( $params ){
						$a = json_decode(($params));
						$output = array();
						foreach( $a as $d ){
							$output[$d->id] = $d;
						}
						$a = serialize( $output );
						update_option( "PGL_MEGAMENU_DATA", $a );
					}
					exit();
				}
				if( isset($_POST['reset']) && $_POST['reset'] ){
					update_option( "PGL_MEGAMENU_DATA", null );
					exit();
				}
			}
		}


		public function ajax_shortcode_delete(){
			if(isset($_POST['id']) && $_POST['id']!=''){
				$obj = PGL_Megamenu_Widget::getInstance();
				$obj->delete($_POST['id']);
				echo $_POST['id'];
			}else{
				echo false;
			}
			exit();
		}

		public function ajax_shortcode_button(){
			$obj = PGL_Shortcodes::getInstance();
			if(isset($_GET['id'])){
				$obj->getShortcode($_REQUEST['type'])->renderForm($_REQUEST['type'],$_GET['id']);
			}else{
				$obj->getShortcode($_REQUEST['type'])->renderForm($_REQUEST['type']);
			}
			exit();
		}

		public function ajax_shortcode_save(){
			$id = (int)$_POST['shortcodeid'];
			$obj = PGL_Shortcodes::getInstance();
			$type = $_POST['shortcodetype'];
			$name = $_POST['shortcode_name'];
			$inputs = serialize($_POST['pgl_input']);
			$response = array();
			if($id==0){
				$response['type']='insert';
				$response['id']= $this->insertMegaMenuTable($name,$type,$inputs);
				$response['title']=$name;
				$response['message'] = $this->l('Widgets published');
				$response['type_widget'] = $type;
			}else{
				$response['type']='update';
				$response['message'] = $this->l('Widgets updated');
				$response['title']=$name;
				$response['id']=$id;
				$this->updateMegaMenuTable($id,$name,$type,$inputs);
			}
			echo json_encode($response);
			exit();
		}

		public function updateMegaMenuTable($id,$name,$type,$shortcode){
			global $wpdb;
			$table_name = $wpdb->prefix . "megamenu_widgets";
			$wpdb->update(
				$table_name,
				array(
	                'name' => $name,
					'type' => $type,
					'params' => $shortcode,
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s'
				),
				array( '%d' )
			);
		}

		public function insertMegaMenuTable($name,$type,$shortcode){
			global $wpdb;
			$table_name = $wpdb->prefix . "megamenu_widgets";
			$wpdb->replace(
				$table_name,
				array(
	                'name' => $name,
					'type' => $type,
					'params' => $shortcode,
				),
				array(
			        '%s',
					'%s',
					'%s'
				)
			);
			return $wpdb->insert_id;
		}

		public function showListShortCodes(){
			$obj =   PGL_Shortcodes::getInstance();
			$shortcodes =$obj->getButtons();
			require( PGL_MEGAMENU_PATH. 'template/shortcodes.php' );
		 	exit();
		}

		public function initFrontScripts(){
			wp_enqueue_script('plg_megamenu',PGL_MEGAMENU_URL.'assets/js/megamenu-front.js',array(),PGL_THEME_VERSION,true);
		}
		
		/**
		 * Translate Languages Follow Actived Theme
		 */
		public function l($text){
			return __($text,'flatize');
		}
	}
	global $pgl_megamenu;
	$pgl_megamenu = new PGL_MegamenuEditor();
}