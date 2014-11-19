(function($) {
	$.fn.PGL_Shortcode = function(opts) {
		// default configuration
		var config = $.extend({}, {
			lang:null,
		}, opts);

		var $this = this;

		var optionsframework_upload;
		var optionsframework_selector;

		function optionsframework_add_file(event, selector) {

		}

		function ajax_shortcode_button(){
			$('.pgl-shortcodes').undelegate( '.pgl-shorcode-button', 'click');
			$('.pgl-shortcodes').delegate( '.pgl-shorcode-button', 'click', function(e){
				$('#myModal .modal-content .spinner.top').show();
				$('#myModal .modal-content .modal-body-inner').html("");
				var $type = $(this).attr('data-name');
				$('#myModal .modal-body .modal-body-inner').load(ajaxurl+'?action=pgl_shortcode_button&type='+$type,function(){
					$('#myModal .modal-content .spinner.top').hide();
					$('#myModal .modal-body .textarea_html').each(function(){
						init_textarea_html($(this));
				    });
				});
	    	});
		}

		function ajax_shortcode_back(){
			$('#myModal .modal-content').undelegate( '.pgl-button-back', 'click');
			$('#myModal .modal-content').delegate( '.pgl-button-back', 'click', function(e){
				$('#myModal .modal-content .spinner.top').show();
				$('#myModal .pgl-widget-message').empty();
				$('#myModal .modal-content .modal-body-inner').html("");
				$('#myModal .modal-body .modal-body-inner').load(ajaxurl+'?action=pgl_list_shortcodes',function(){
					$('#myModal .modal-content .spinner.top').hide();
				});
			});
		}

		function ajax_shortcode_save(){
			$('#myModal .modal-content').undelegate('.pgl-button-save', 'click');
			$('#myModal .modal-content').delegate( '.pgl-button-save', 'click', function(e){
				var datastring = $('#myModal #pgl-shortcode-form').serialize();
				$.ajax({
					url: ajaxurl+'?action=pgl_shortcode_save',
					type: 'POST',
					dataType:'JSON',
					data: datastring,
					beforeSend:function(){
						$('#myModal .pgl-widget-message').html("");
						$('#myModal #pgl-shortcode-form').find('input,button,select,radio').prop('disabled',true);
						$('#myModal #pgl-shortcode-form .spinner-button').show();
					},
					success: function(response){
						$('#myModal .pgl-widget-message').append('<div class="alert alert-success"><strong>'+response.message+'</strong><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>');
						$('#myModal #pgl-shortcode-form').find('input,button,select,radio').prop('disabled',false);
						$('#myModal #pgl-shortcode-form .spinner-button').hide();
						if(response.type=='insert'){
							$('#myModal #pgl-shortcode-form input[name="shortcodeid"]').val(response.id);
							$('#column-form [name="inject_widget"]').append('<option value="'+response.id+'">'+response.title+'</option>');
							$('#manage-widget table').append('<tr><td>'+response.title+'</td><td>'+response.type_widget+'</td><td><a class="pgl-edit-widget" rel="edit" data-type="'+response.type_widget+'" data-id="'+response.id+'" href="#">Edit</a>|<a rel="delete" class="pgl-delete" data-id="'+response.id+'" href="#">Delete</a></td></tr>');
						}else if(response.type=='update'){
							var managetable = $('#manage-widget table tr[data-widget-id="'+response.id+'"]');
							$('#manage-widget table tr[data-widget-id="'+response.id+'"] .name').text(response.title);
							$('#column-form [name="inject_widget"] option[value="'+response.id+'"]').text(response.title);
						}
					}
				});
			});
		}

	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {
			ajax_shortcode_button();
			ajax_shortcode_back();
			ajax_shortcode_save();
		});
		return this;
	};
})(jQuery);