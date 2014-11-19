<?php
$output = $title = $title_align = $el_class = '';
extract(shortcode_atts(array(
    'title' => __("Title", "js_composer"),
    'title_align' => 'separator_align_center',
    'el_class' => '',
    'descript' => '',
    'style' => 'style-1'
), $atts));
$el_class = $this->getExtraClass($el_class);

// $css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_text_separator wpb_content_element '.$title_align.$el_class, $this->settings['base']);
// $output .= '<div class="'.$css_class.'"><div>'.$title.'</div></div>'.$this->endBlockComment('separator')."\n";

// echo $output;
?>

<h2 class="title-section wow flipInX <?php echo $style; ?>"><span><?php echo $title; ?></span></h2>
<?php if(trim($descript)!=''){ ?>
	<div class="descript">
		<?php echo $descript; ?>
	</div>
<?php } ?>

