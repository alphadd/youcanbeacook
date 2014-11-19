<?php
/*==========================================================================
Init Pagebuilder
==========================================================================*/

define( 'PGL_PAGEBUILDER_PATH', PGL_FRAMEWORK_PATH.'pagebuilder/' );
define( 'PGL_PAGEBUILDER_URI', PGL_FRAMEWORK_URI.'pagebuilder/' );

/*==========================================================================
init Admin Scripts
==========================================================================*/
add_action( 'admin_enqueue_scripts', 'pgl_vc_admin_scripts' );
function pgl_vc_admin_scripts(){
	wp_enqueue_script('pgl_googlemap_admin_js', 'http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places' );
	wp_enqueue_script('pgl_googlemap_geocomplete_js', PGL_PAGEBUILDER_URI.'js/jquery.geocomplete.min.js');
}

/*==========================================================================
init front Scripts
==========================================================================*/
add_action( 'wp_enqueue_scripts', 'pgl_vc_front_scripts' ,1);
function pgl_vc_front_scripts(){
	wp_enqueue_style( 'js_composer_front' );
	// wp_deregister_script('wpb_composer_front_js');
	//wp_enqueue_script( 'wpb_composer_front_js' );
	//wp_enqueue_style('js_composer_custom_css');
}

// add_action('init','pgl_vc_init',100);
// function pgl_vc_init(){
	
// }


/*==========================================================================
	Element Banner
	==========================================================================*/
	vc_map( array(
	    "name" => __("PGL Banner", 'flatize'),
	    "base" => "pgl_banner",
	    "class" => "",
	    "category" => __('PGL Widgets','flatize'),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"heading" => __("Title", 'flatize'),
				"param_name" => "title"
			),
			array(
		        'type' => 'textarea',
		        'heading' => __( 'Description', 'js_composer' ),
		        'param_name' => 'desc',
			),
			array(
				"type" => "textfield",
				"heading" => __("Link", 'flatize'),
				"param_name" => "link"
			),
			array(
				'type' => 'css_editor',
				'heading' => __( 'Css', 'js_composer' ),
				'param_name' => 'css',
				// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
				'group' => __( 'Design options', 'js_composer' )
	   		)
		)
	));

	/*==========================================================================
	Product Collection
	==========================================================================*/
	vc_map( array(
	    "name" => __("PGL Collection", 'flatize'),
	    "base" => "pgl_product_collection",
	    "class" => "",
	    "category" => __('PGL Widgets','flatize'),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"heading" => __("Title", 'flatize'),
				"param_name" => "title"
			),
			array(
		        'type' => 'attach_image',
		        'heading' => __( 'Image', 'js_composer' ),
		        'param_name' => 'image',
		        'value' => '',
		        'description' => __( 'Select image from media library.', 'js_composer' )
			),
			array(
				"type" => "textfield",
				"heading" => __("Link", 'flatize'),
				"param_name" => "link",
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'flatize'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'flatize')
			)
	   	)
	));

	/*==========================================================================
	Element Brands
	==========================================================================*/
	vc_map( array(
	    "name" => __("PGL Brands",'flatize'),
	    "base" => "pgl_brands",
	    "class" => "",
	    "category" => __('PGL Widgets','flatize'),
	    "params" => array(
	    	array(
				"type" => "textfield",
				"heading" => __("Title", 'flatize'),
				"param_name" => "title"
			),
			array(
		        'type' => 'attach_images',
		        'heading' => __( 'Images', 'js_composer' ),
		        'param_name' => 'images',
		        'value' => '',
		        'description' => __( 'Select images from media library.', 'js_composer' )
			),
			array(
		        'type' => 'exploded_textarea',
		        'heading' => __( 'Custom links', 'js_composer' ),
		        'param_name' => 'custom_links',
		        'description' => __( 'Enter links for each slide here. Divide links with linebreaks (Enter) . ', 'js_composer' ),
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'flatize'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'flatize')
			)
	   	)
	));

	/*==========================================================================
	Element Testimonials
	==========================================================================*/
	vc_map( array(
	    "name" => __("PGL Testimonials",'flatize'),
	    "base" => "pgl_testimonials",
	    "class" => "",
	    "category" => __('PGL Widgets','flatize'),
	    "params" => array(
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'flatize'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'flatize')
			)
	   	)
	));

	/*==========================================================================
	Element Products
	==========================================================================*/
	vc_map( array(
	    "name" => __("PGL Products", 'flatize'),
	    "base" => "pgl_products",
	    "class" => "",
	    "category" => __('PGL Widgets','flatize'),
	    "params" => array(
	    	array(
				"type" => "dropdown",
				"heading" => __("Type", 'flatize'),
				"param_name" => "type",
				"value" => array('Best Selling'=>'best_selling','Featured Products'=>'featured_product','Top Rate'=>'top_rate','Recent Products'=>'recent_product','On Sale'=>'on_sale','Recent Review' => 'recent_review' ),
				"admin_label" => true,
				"description" => __("Select columns count.", 'flatize')
			),
			array(
				"type" => "dropdown",
				"heading" => __("Style", 'flatize'),
				"param_name" => "style",
				"value" => array('Grid'=>'grid','List'=>'list','Carousel'=>'carousel')
			),
			array(
				"type" => "textfield",
				"heading" => __("Number of products to show", 'flatize'),
				"param_name" => "number",
				"value" => '4'
			),
			array(
				"type" => "dropdown",
				"heading" => __("Columns count", 'flatize'),
				"param_name" => "columns_count",
				"value" => array(4, 3, 2, 1),
				"admin_label" => true,
				"description" => __("Select columns count.", 'flatize')
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon", 'flatize'),
				"param_name" => "icon"
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'flatize'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'flatize')
			)
	   	)
	));


	/*==========================================================================
	Element Products
	==========================================================================*/

	global $wpdb;
	$sql = "SELECT a.name,a.slug,a.term_id FROM $wpdb->terms a JOIN  $wpdb->term_taxonomy b ON (a.term_id= b.term_id ) where b.taxonomy = 'product_cat'";
	$results = $wpdb->get_results($sql);
	$value = array();
	foreach ($results as $vl) {
		$value[$vl->name] = $vl->slug;
	}
	vc_map( array(
	    "name" => __("PGL Product Category", 'flatize'),
	    "base" => "pgl_productcategory",
	    "class" => "",
	    "category" => __('PGL Widgets','flatize'),
	    "params" => array(
	    	array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __('Category','flatize'),
				"param_name" => "category",
				"value" =>$value,
				"admin_label" => true
			),
			array(
				"type" => "dropdown",
				"heading" => __("Style", 'flatize'),
				"param_name" => "style",
				"value" => array('Grid'=>'grid','List'=>'list','Carousel'=>'carousel')
			),
			array(
				"type" => "textfield",
				"heading" => __("Number of products to show", 'flatize'),
				"param_name" => "number",
				"value" => '4'
			),
			array(
				"type" => "dropdown",
				"heading" => __("Columns count", 'flatize'),
				"param_name" => "columns_count",
				"value" => array(4, 3, 2, 1),
				"admin_label" => true,
				"description" => __("Select columns count.", 'flatize')
			),
			array(
				"type" => "textfield",
				"heading" => __("Icon", 'flatize'),
				"param_name" => "icon"
			),
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", 'flatize'),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'flatize')
			)
	   	)
	));

	/*==========================================================================
	Override Class column
	==========================================================================*/
	add_filter( 'vc_shortcodes_css_class', 'pgl_vc_custom_column_builder', 10,2);
	function pgl_vc_custom_column_builder($class_string,$tag){
		if ($tag=='vc_row' || $tag=='vc_row_inner') {
			$class_string = str_replace('vc_row-fluid', 'row', $class_string);
			$class_string = str_replace('wpb_row ', '', $class_string);
		}
		if ($tag=='vc_column' || $tag=='vc_column_inner') {
			$class_string = preg_replace('/vc_span(\d{1,2})/', 'col-md-$1', $class_string);
			$class_string = preg_replace('/vc_col-(\w)/', 'col-$1', $class_string);
			$class_string = str_replace(' wpb_column column_container', '', $class_string);
		}
		return $class_string;
	}

	/*==========================================================================
	Add New Parram Google Map
	==========================================================================*/
	add_shortcode_param('googlemap','pgl_vc_add_parram_googlemap',PGL_PAGEBUILDER_URI.'js/googlemap.js');
	function pgl_vc_add_parram_googlemap($settings, $value) {
	    $dependency = vc_generate_dependencies_attributes($settings);
			return '
			<div id="pgl-element-map">
				<div class="map_canvas" style="height:200px;"></div>

				<div class="vc_row-fluid googlefind">
					<input id="geocomplete" type="text" class="pgl-location" placeholder="Type in an address" size="90" />
					<button class="button-primary find">'.__("Find",'flatize').'</button>
				</div>

				<div class="row-fluid mapdetail">
					<div class="span6">
						<div class="wpb_element_label">'.__('Latitude','flatize').'</div>
						<input name="lat" class="pgl-latgmap" type="text" value="">
					</div>
					
					<div class="span6">
						<div class="wpb_element_label">'.__('Longitude','flatize').'</div>
						<input name="lng" class="pgl-lnggmap" type="text" value="">
					</div>
				</div>
			</div>
			';
	}

	/*==========================================================================
	Add New Parram input hidden
	==========================================================================*/
	add_shortcode_param('hidden', 'pgl_vc_add_parram_inputhidden' );
	function pgl_vc_add_parram_inputhidden($settings, $value) {
	    $dependency = vc_generate_dependencies_attributes($settings);
	    return '<input name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wpb-textinput '
				.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				.$value.'" ' . $dependency . '/>';
	}

	/*==========================================================================
	Add New Parram Animation
	==========================================================================*/
	add_shortcode_param('animation', 'pgl_vc_add_parram_animation',PGL_PAGEBUILDER_URI.'js/animation.js');
	function pgl_vc_add_parram_animation($settings, $value) {
		$value = ($value=='') ? 'none|1000|200' : $value;
	    $dependency = vc_generate_dependencies_attributes($settings);
	    $options = array(
	    				'none' => 'none',
						'bounce' => 'bounce',
						'flash' => 'flash',
						'pulse' => 'pulse',
						'rubberBand' => 'rubberBand',
						'shake' => 'shake',
						'swing' => 'swing',
						'tada' => 'tada',
						'wobble' => 'wobble',
						'bounceIn' => 'bounceIn',
						'fadeIn' => 'fadeIn',
						'fadeInDown' => 'fadeInDown',
						'fadeInDownBig' => 'fadeInDownBig',
						'fadeInLeft' => 'fadeInLeft',
						'fadeInLeftBig' => 'fadeInLeftBig',
						'fadeInRight' => 'fadeInRight',
						'fadeInRightBig' => 'fadeInRightBig',
						'fadeInUp' => 'fadeInUp',
						'fadeInUpBig' => 'fadeInUpBig',
						'flip' => 'flip',
						'flipInX' => 'flipInX',
						'flipInY' => 'flipInY',
						'lightSpeedIn' => 'lightSpeedIn',
						'rotateInrotateIn' => 'rotateIn',
						'rotateInDownLeft' => 'rotateInDownLeft',
						'rotateInDownRight' => 'rotateInDownRight',
						'rotateInUpLeft' => 'rotateInUpLeft',
						'rotateInUpRight' => 'rotateInUpRight',
						'slideInDown' => 'slideInDown',
						'slideInLeft' => 'slideInLeft',
						'slideInRight' => 'slideInRight',
						'rollIn' => 'rollIn'
					);
	    ob_start();
	    echo '<input id="'.$settings['param_name'].'" 
	    		name="'.$settings['param_name']
				.'" class="wpb_vc_param_value wpb-textinput '
				.$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'
				.$value.'" ' . $dependency . '/>';
		?>
		<div class="vc_row">
			<div class="vc_col-sm-4">
				<div class="wpb_element_label">Effect</div>
				<select id="pgl_effect">
					<?php foreach ($options as $key => $value) {
						echo '<option value="'.$key.'">'.$value.'</option>';
					} ?>
				</select>
			</div>
			<div class="vc_col-sm-4">
				<div class="wpb_element_label">Duration</div>
				<input type="text" value="" id="pgl_duration">
			</div>
			<div class="vc_col-sm-4">
				<div class="wpb_element_label">Delay</div>
				<input type="text" id="pgl_delay">
			</div>
		</div>
		<?php
	    return ob_get_clean();
	}

	/*==========================================================================
	Modifined Element Base
	==========================================================================*/
	add_action( 'init', 'pgl_vc_edit_element_base',100 );
	function pgl_vc_edit_element_base(){
		//Element Title
		pgl_vc_delete_params('vc_text_separator',array(
	    		'title_align',
	    		'color',
	    		'accent_color',
	    		'el_width'
	    	));
		vc_add_param( 'vc_text_separator', array(
	         "type" => "textarea",
	         "heading" => __("Description",'flatize'),
	         "param_name" => "descript",
	         "value" => ''
	    ));
	    vc_add_param( 'vc_text_separator', array(
	        "type" => "dropdown",
			"heading" => __("Style", 'flatize'),
			"param_name" => "style",
			"value" => array( 'Style 1'=>'style-1','Style 2'=>'style-2' )
	    ));

	    //Element Row
	    vc_add_param( 'vc_row', array(
	         "type" => "checkbox",
	         "heading" => __("Row Small",'flatize'),
	         "param_name" => "rowsm",
	         "value" => array(
	         				'Yes, please' => true
	         			)
	    ));

	    vc_add_param( 'vc_row', array(
	         "type" => "checkbox",
	         "heading" => __("Full Width",'flatize'),
	         "param_name" => "fullwidth",
	         "value" => array(
	         				'Yes, please' => true
	         			)
	    ));

	    vc_add_param( 'vc_row', array(
	         "type" => "checkbox",
	         "heading" => __("Parallax",'flatize'),
	         "param_name" => "parallax",
	         "value" => array(
	         				'Yes, please' => true
	         			)
	    ));

	    // Column
	    vc_add_param( 'vc_column', array(
	         "type" => "animation",
	         "heading" => __("CSS Animation",'flatize'),
	         "param_name" => "pgl_animation",
	    ));
	    // Element Gmap
	    
	    $param = WPBMap::getParam('vc_gmaps', 'title');
		$param['type'] = 'googlemap';
		$param['heading']='Position';
		$param['description']='';
		WPBMap::mutateParam('vc_gmaps', $param);

		$param = WPBMap::getParam('vc_gmaps', 'link');
		$param['type']='hidden';
		$param['value']='21.0173222,105.78405279999993';
		WPBMap::mutateParam('vc_gmaps', $param);

		$param = WPBMap::getParam('vc_gmaps', 'size');
		$param['value']=300;
		$param['description']='Enter map height in pixels. Example: 300.';
		WPBMap::mutateParam('vc_gmaps', $param);

		vc_add_param( 'vc_gmaps', array(
			"type" => "dropdown",
			"heading" => __("Map Type", 'flatize'),
			"param_name" => "type",
			"value" => array(
						'roadmap'=>'ROADMAP',
						'hybrid'=>'HYBRID',
						'satellite'=>'SATELLITE',
						'terrain'=>'TERRAIN'
					),
			"admin_label" => true,
			"description" => __("Select Map Type.", 'flatize')
			)	
		);

		$classparam = WPBMap::getParam('vc_gmaps', 'el_class');
		pgl_vc_delete_params('vc_gmaps','el_class');

		vc_add_param( 'vc_gmaps', array(
	         "type" => "checkbox",
	         "heading" => __("Remove Pan Control",'flatize'),
	         "param_name" => "pancontrol",
	         "value" => array(
	         				 'Yes, please' => true
	         			)
	    ));

	    vc_add_param( 'vc_gmaps', array(
	         "type" => "checkbox",
	         "heading" => __("Remove Zoom Control",'flatize'),
	         "param_name" => "zoomcontrol",
	         "value" => array(
	         				 'Yes, please' => true
	         			)
	    ));

	    vc_add_param( 'vc_gmaps', array(
	         "type" => "checkbox",
	         "heading" => __("Remove Maptype Control",'flatize'),
	         "param_name" => "maptypecontrol",
	         "value" => array(
	         				'Yes, please' => true
	         			)
	    ));

	    vc_add_param( 'vc_gmaps', array(
	         "type" => "checkbox",
	         "heading" => __("Remove Streets Control",'flatize'),
	         "param_name" => "streetscontrol",
	         "value" => array(
	         				'Yes, please' => true
	         			)
	    ));

	    WPBMap::mutateParam('vc_gmaps', $classparam);

	    //Element Tabs
	    vc_add_param( 'vc_tab', array(
	         "type" => "textfield",
	         "heading" => __("Icon",'flatize'),
	         "param_name" => "tabicon",
	         "value" => ''
	    ));

	    //Single Image
	    $param = WPBMap::getParam( 'vc_single_image' , 'css_animation');
			$param['heading'] = 'Effect' ;
			$param['value']=array(
					'None' => 'effct-none',
					'Effect Border' => 'effect-border',
					'Effect Full' => 'effect-full',
					'Effect Bottom' => 'effect-bottom',
					'Effect Top' => 'effect-top',
					'Effect Right' => 'effect-right',
					'Effect Left' => 'effect-left',
					'Effect Rotate' => 'effect-rotate',
					'Effect In to out' => 'effect-in-to-out',
					'Effect Out to in' => 'effect-out-to-in',
					'Effect Top to bottom' => 'effect-top-to-bottom',
				);
			$param['description']='';
			$param['admin_label']=true;
			WPBMap::mutateParam('vc_single_image', $param);

	    // Button
		$param = WPBMap::getParam('vc_button', 'color');
		$param['value'] = array(
							'Default'=>'btn-default',
							'Primary'=>'btn-success',
							'Success'=>'btn-success',
							'Info'=>'btn-warning',
							'Danger'=>'btn-danger',
							'Link'=>'btn-link'
						);
		$param['heading']='Type';
		WPBMap::mutateParam('vc_button', $param);

		// icon
		$param = WPBMap::getParam('vc_button', 'icon');
		$param['type']='textfield';
		$param['value']='';
		WPBMap::mutateParam('vc_button', $param);

		// size
		$param = WPBMap::getParam('vc_button', 'size');
		$param['value']= array(
							'Default'=>'',
							'Large'=>'btn-lg',
							'Small'=>'btn-sm',
							'Extra small'=>'btn-xs'
						);
		WPBMap::mutateParam('vc_button', $param);


		// Post Grid
		$param = WPBMap::getParam('vc_posts_grid', 'grid_layout');
		$param['type']='dropdown';
		$param['heading']='Skin Layout';
		$param['value']=array(
							'skin 1'=>'skin1',
							'Skin 2'=>'skin2'
						);
		WPBMap::mutateParam('vc_posts_grid', $param);

	}

	function pgl_vc_delete_params( $name, $element ){
		if(is_array($element)){
			foreach ($element as $value) {
				vc_remove_param($name,$value);
			}
		}else{
			vc_remove_param($name,$element);
		}
	}



