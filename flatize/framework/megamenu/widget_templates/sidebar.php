<?php

$class = trim($atts['class']);
$output = '';
if($class!=""){
	$output.='<div class="'.$class.'">';
}
	ob_start();
	dynamic_sidebar($atts['sidebar']);
	$output.=ob_get_clean();
if($class!=""){
	$output.='</div>';
}
return $output;