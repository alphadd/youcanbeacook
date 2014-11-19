<?php 
extract(shortcode_atts(array(
    'title' => '',
    'desc' => '',
    'css' => '',
), $atts));

?>

<div class="banner-element <?php echo vc_shortcode_custom_css_class($css, ' '); ?>">
	<h2><?php echo $title; ?></h2>
	<p><?php echo $desc; ?></p>
</div>