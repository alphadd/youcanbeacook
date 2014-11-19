<?php

/*====================================================================================
Add Style & Script
====================================================================================*/
add_action( 'admin_enqueue_scripts', 'pgl_metabox_init_script' ,10 );
function pgl_metabox_init_script(){
    wp_enqueue_script( 'pgl_metabox_js', CMB_META_BOX_URL . 'js/meta.custom.js' );
    wp_enqueue_script( 'pgl_select_chosen_js', CMB_META_BOX_URL . 'js/chosen.jquery.min.js' );
    wp_enqueue_style( 'pgl_metabox_css' , CMB_META_BOX_URL . 'css/meta.custom.css' );
    wp_enqueue_style( 'pgl_select_chosen_css' , CMB_META_BOX_URL . 'css/chosen.min.css' );
}

/*====================================================================================
Add Layout Field
====================================================================================*/
add_action( 'cmb_render_layout', 'pgl_metabox_layout_field', 10, 5 );
function pgl_metabox_layout_field( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
?>
   	<div class="layout-image">
   		<img src="<?php echo CMB_META_BOX_URL.'images/1col.png' ?>" data-value="1" class="<?php pgl_metabox_check_active($escaped_value,1); ?>">
   		<img src="<?php echo CMB_META_BOX_URL.'images/2cl.png' ?>" data-value="2" class="<?php pgl_metabox_check_active($escaped_value,2); ?>">
   		<img src="<?php echo CMB_META_BOX_URL.'images/2cr.png' ?>" data-value="3" class="<?php pgl_metabox_check_active($escaped_value,3); ?>">
   		<img src="<?php echo CMB_META_BOX_URL.'images/3c.png' ?>" data-value="4" class="<?php pgl_metabox_check_active($escaped_value,4); ?>">
   		<img src="<?php echo CMB_META_BOX_URL.'images/3c-l-l.png' ?>" data-value="5" class="<?php pgl_metabox_check_active($escaped_value,5); ?>">
   		<img src="<?php echo CMB_META_BOX_URL.'images/3c-r-r.png' ?>" data-value="6" class="<?php pgl_metabox_check_active($escaped_value,6); ?>">
   	</div>
<?php
	echo $field_type_object->input( array('type'=>'hidden') );
}

function pgl_metabox_check_active($value,$default){
	if($value==$default)
		echo ' active';
}

/*====================================================================================
Add Sidebar Field
====================================================================================*/
add_action( 'cmb_render_sidebar', 'pgl_metabox_sidebar_field', 10, 5 );
function pgl_metabox_sidebar_field( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
	global $wp_registered_sidebars;
	$options = array('none'=>'---Select Sidebar---');
	foreach ($wp_registered_sidebars as $key => $value) {
		$options[$value['id']] = $value['name'];
	}
	$field_type_object->field->args['options'] = $options;
	echo $field_type_object->select();
}

/*====================================================================================
Add Button Radio
====================================================================================*/
add_action( 'cmb_render_button_radio', 'pgl_metabox_button_radio_field', 10, 5 );
function pgl_metabox_button_radio_field( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
	if( count($field_args['options'])<=0 ){
?>
	<div class="btn-group" data-toggle="buttons">
		<label class="btn btn-no<?php pgl_metabox_check_active($escaped_value,0); ?>">
			<input type="radio" name="<?php echo $field_args['_name']; ?>" value="0" <?php checked($escaped_value,0); ?> > No
		</label>
		<label class="btn btn-yes<?php pgl_metabox_check_active($escaped_value,1); ?>">
			<input type="radio" name="<?php echo $field_args['_name']; ?>" value="1" <?php checked($escaped_value,1); ?> > Yes
		</label>
	</div>
<?php
	}else{
		echo '<div class="btn-group" data-toggle="buttons">';
		foreach ($field_args['options'] as $key => $value) {
	?>
		<label class="btn btn-yes<?php pgl_metabox_check_active($escaped_value,$key); ?>">
			<input type="radio" name="<?php echo $field_args['_name']; ?>" value="<?php echo $key; ?>" <?php checked($escaped_value,$key); ?> > <?php echo $value;  ?>
		</label>
	<?php
		}
		echo '</div>';
	}
}

/*====================================================================================
Add Number Field
====================================================================================*/
add_action( 'cmb_render_text_number', 'pgl_metabox_text_number_field', 10, 5 );
function pgl_metabox_text_number_field( $field_args, $escaped_value, $object_id, $object_type, $field_type_object ) {
  	echo $field_type_object->input( array( 'type' => 'number','class'=>'cmb_text_small' ) );
}

add_action( 'cmb_validate_text_number' , 'pgl_metabox_validate_text_number_field',10,2 );
function pgl_metabox_validate_text_number_field( $override_value, $value ){
    if ( ! is_numeric($value) ) {
        $value = '6';
    }   
    return $value;
}


























