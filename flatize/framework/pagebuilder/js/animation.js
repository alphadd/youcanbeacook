!function($) {
	var $input_animation = $('#pgl_animation');
	var $input_effect = $('#pgl_effect');
	var $input_duration = $('#pgl_duration');
	var $input_delay = $('#pgl_delay');

	if($input_animation.length>0){
		//set Event
		$('#pgl_effect,#pgl_duration,#pgl_delay').change(function(event) {
			$input_animation.val($input_effect.val()+'|'+$input_duration.val()+'|'+$input_delay.val());
		}).keyup(function(event) {
			$input_animation.val($input_effect.val()+'|'+$input_duration.val()+'|'+$input_delay.val());
		});;

		// Set Value Default
		var $value = $input_animation.val().split('|');
		$input_effect.val($value[0]);
		$input_duration.val($value[1]);
		$input_delay.val($value[2]);
	}
}(window.jQuery);
