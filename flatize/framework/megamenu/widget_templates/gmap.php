<?php

$_id = pgl_make_id();

?>

<div id="map_<?php echo $_id; ?>" class="map_canvas" style="width:100%;height:<?php echo $atts['height']; ?>px;"></div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var stmapdefault = '<?php echo $atts['location']; ?>';
		var marker = {position:stmapdefault}
		jQuery('#map_<?php echo $_id; ?>').gmap({
			'scrollwheel':false,
			'zoom': <?php echo $zoom;  ?>  ,
			'center': stmapdefault,
			'mapTypeId':google.maps.MapTypeId.<?php echo $type; ?>,
			'panControl': <?php echo $pancontrol; ?>
		});
	});
</script>