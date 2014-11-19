<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {
	global $theme_option;

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_pgl_';

	$meta_boxes['page_config'] = array(
		'id'         => 'page_config',
		'title'      => __( 'Page Config', 'flatize' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Layout', 'flatize' ),
				'desc' => __( 'Select Layout', 'flatize' ),
				'id'   => $prefix . 'page_layout',
				'type' => 'layout',
				'default' => '1'
			),
			array(
				'name' => __( 'Left Sidebar', 'flatize' ),
				'id'   => $prefix . 'page_left_sidebar',
				'type' => 'sidebar',
			),
			array(
				'name' => __( 'Right Sidebar', 'flatize' ),
				'id'   => $prefix . 'page_right_sidebar',
				'type' => 'sidebar',
			),
			array(
				'name' => __( 'Show Breadcrumb', 'flatize' ),
				'id'   => $prefix . 'show_breadcrumb',
				'type' => 'button_radio',
			),
			array(
				'name' => __( 'Blog pages show at most', 'flatize' ),
				'id'   => $prefix . 'blog_count',
				'type' => 'text_number',
				'std'  => 6
			),
			array(
				'name'    => __( 'Blog Skin', 'flatize' ),
				'id'      => $prefix . 'blog_skin',
				'type'    => 'select',
				'options' => array(
					'default' => 'Blog default',
					'mini' 	  => 'Blog mini sidebar'
				),
				'std' => 'global'
			),
			array(
				'name' => __( 'Override Theme Options', 'flatize' ),
				'id'   => $prefix . 'override_options',
				'type' => 'title',
			),
			array(
				'name' => __( 'Layout Style', 'flatize' ),
				'id'   => $prefix . 'layout_style',
				'type' => 'button_radio',
				'options' => array(
						'global' => __('Global','flatize'),
						'boxed' => __('Boxed','flatize'),
						'wide' => __('Wide','flatize'),
					),
				'std' => 'global'
			),
			array(
				'name'    => __( 'Header Style', 'flatize' ),
				'id'      => $prefix . 'header_style',
				'type'    => 'select',
				'options' => array(
					'global' => __( 'Use Global', 'flatize' ),
					''   => __( 'Style 1', 'flatize' ),
					'style2'     => __( 'Style 2', 'flatize' ),
					'style3'     => __( 'Style 3', 'flatize' ),
				),
				'std' => 'global'
			),
			array(
				'name'    => __( 'Footer Style', 'flatize' ),
				'id'      => $prefix . 'footer_style',
				'type'    => 'select',
				'options' => array(
					'global' => __( 'Use Global', 'flatize' ),
					'style1' => __( 'Style 1', 'flatize' ),
					'style2' => __( 'Style 2', 'flatize' ),
				),
				'std' => 'global'
			),
		)
	);

	$meta_boxes['post_config'] = array(
		'id'         => 'post_config',
		'title'      => __( 'Post Config', 'flatize' ),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Link Video or Audio', 'flatize' ),
				'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'flatize' ),
				'id'   => $prefix . 'post_video',
				'type' => 'oembed',
			),
			array(
			    'name' => 'Gallery Images',
			    'desc' => '',
			    'id' => $prefix . 'post_gallery',
			    'type' => 'file_list',
			    // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			),
		)
	);

	if( $theme_option['is-seo'] ){
		$meta_boxes['seo_meta'] = array(
			'id'         => 'seo_meta',
			'title'      => __( 'Seo Options', 'flatize' ),
			'pages'      => array( 'page','post' ), // Post type
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true, // Show field names on the left
			// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
			'fields'     => array(
				array(
					'name'       => __( 'Title', 'flatize' ),
					'id'         => $prefix . 'seo_title',
					'type'       => 'text',
					'show_on_cb' => 'cmb_test_text_show_on_cb', // function should return a bool value
					
				),
				array(
					'name'       => __( 'Keywords', 'flatize' ),
					'id'         => $prefix . 'seo_keywords',
					'type'       => 'text',
				),
				array(
					'name' => __( 'Description', 'flatize' ),
					'id'   => $prefix . 'seo_description',
					'type' => 'textarea',
				),
			)
		);
	}

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) ){
		get_template_part( 'framework/metabox/init' );
		get_template_part( 'framework/metabox/meta-custom' );
	}
}
