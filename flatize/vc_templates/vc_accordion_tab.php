<?php
global $pgl_accordion_item;
$output = $title = '';

extract(shortcode_atts(array(
	'title' => __("Section", "js_composer")
), $atts));
$pgl_accordion_item[]=array('title'=>$title,'content'=>wpb_js_remove_wpautop($content));

