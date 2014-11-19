<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'fullwidth'       => '0',
    'parallax'        => '0',
    'css'             => '',
    'rowsm'           => false
), $atts));

$_is_container = ($fullwidth=='1' && $parallax=='1')?true:false;
$row_sm = ($rowsm) ? ' row-sm' : '';
//wp_enqueue_style( 'js_composer_front' );
//wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$is_parallax = ($parallax!='0')?' data-stellar-background-ratio="0.6"':'';
$el_class = $this->getExtraClass($el_class);
$parallax = ($parallax!='0') ? ' parallax' : '';
$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_row '.get_row_css_class().$el_class, $this->settings['base']);
$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);

$output='<section class="section-element'.$el_class.$parallax.vc_shortcode_custom_css_class($css, ' ').'" '.$style.$is_parallax.'>';
    $output .= ($fullwidth!='0') ? '' : '<div class="container">';
    $output .= ($_is_container)?'<div class="container">':'';
        $output .= '<div class="row'.$row_sm.'">';
    		$output .= wpb_js_remove_wpautop($content);
        $output .= '</div>'.$this->endBlockComment('row');
    $output .= ($fullwidth!='0') ? '' : '</div>';
    $output .= ($_is_container)?'</div>':'';
$output.='</section>';

echo $output;