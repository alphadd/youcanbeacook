var PGL_megamenu = window.PGL_megamenu || {};
(function($) {
	
	"use strict";
	$.extend(PGL_megamenu, {
	    params_Embed : function (input_id,parent_id){
	    	var input = jQuery(input_id);
	    	if(input.length>0){
		    	var oembed_url = input.val();
		    	if(oembed_url!="" && oembed_url.length>6){
		    		jQuery(parent_id+' .spinner').css('display','block');
		    		PGL_megamenu.param_start_ajax_embed(oembed_url,parent_id);
		    	}
		        input.on('keyup', function (event) {
					PGL_megamenu.param_ajax_Embed(jQuery(this), event,parent_id,input_id);
				});
			}
	    },

	    param_ajax_Embed : function (obj, e,parent_id,input_id) {
			// get typed value
			var oembed_url = obj.val();
			// only proceed if the field contains more than 6 characters
			if (oembed_url.length < 6)
				return;
			// only proceed if the user has pasted, pressed a number, letter, or whitelisted characters
			if (e === 'paste' || e.which <= 90 && e.which >= 48 || e.which >= 96 && e.which <= 111 || e.which == 8 || e.which == 9 || e.which == 187 || e.which == 190) {
				jQuery(parent_id+' .spinner').css('display','block');
				// clear out previous results
				jQuery(parent_id+' .result').html('');
				// and run our ajax function
				setTimeout(function () {
					// if they haven't typed in 500 ms
					if (jQuery(input_id+':focus').val() == oembed_url) {
						PGL_megamenu.param_start_ajax_embed(oembed_url,parent_id);
					}
				}, 500);
			}
		},
		param_start_ajax_embed : function (oembed_url,parent_id){
		    jQuery.ajax({
				type : 'post',
				dataType : 'json',
				url : window.ajaxurl,
				data : {
					'action': 'pgl_post_embed',
					'oembed_url': oembed_url
				},
				success: function (response) {
					jQuery(parent_id+' .spinner').css('display','none');
					// if we have a response id
					if(response.check){
	                    jQuery(parent_id+' .pgl_embed_view .result').addClass('active').append(response.video);
	                    jQuery(parent_id+' .pgl_embed_view .result').append('<a class="remove-embed"></a>');
	                    jQuery(parent_id+' .result a.remove-embed').click(function(){
	                    	jQuery(parent_id).find('input').val("");
	                    	jQuery(parent_id+' .result').html("");
	                    	jQuery(parent_id+' .result').removeClass('active');
	                    });
	                }else{
	                	jQuery(parent_id+' .pgl_embed_view .result').append(response.video);
	                }
				}
			});
		},
	});

	$.fn.PGLMegamenuEditor = function(opts) {
		// default configuration
		var config = $.extend({}, {
			action:null,
			action_menu:null,
			text_warning_select:'Please select One to remove?',
			text_confirm_remove:'Are you sure to remove footer row?',
			JSON:null
		}, opts);

		/**
		 * active menu
		 */
		var activeMenu = null;

		/**
	 	 * fill data values for  top level menu when clicked menu.
	 	 */

		function processMenu( item , _parent, _megamenu ){

			$("#admin-menu-action>div").hide();
		    $("#menu-form").show();
			$.each( $("#menu-form form").serializeArray(), function(i, input ){
				var val = '';
				if( $(_parent).data( input.name.replace("menu_","")) ){
					val = $(_parent).data( input.name.replace("menu_",""));
				}
				 $('[name='+input.name+']',"#menu-form").val(  val );
			});

			if( activeMenu.data("align") ){
				$(".button-alignments button").removeClass("active");
				$( '[data-option="'+activeMenu.data("align") +'"]').addClass("active");

			}
		}

		/**
	 	 * fill data values for  top level menu when clicked Sub menu.
	 	 */
		function processSubMenu( item , _parent, _megamenu ){

			var pos =  $(item).offset();
		    $('#submenu-form').css('left',pos.left  - 30 );
			$('#submenu-form').css('top',pos.top - $('#submenu-form').height() );
	 		$("#submenu-form").show();

			$.each( $("#submenu-form form").serializeArray(), function(i, input ){
				 $('[name='+input.name+']',"#submenu-form").val( $(_parent).data( input.name.replace("submenu_",""))  );
			} ) ;

		}

		/**
	 	 * menu form handler
	 	 */
		function menuForm(){
			$("input, select","#menu-form").change( function (){

			 	if( activeMenu ){
			 		if( $(this).hasClass('menu_submenu')   ) {
					 	var item = $("a",activeMenu);

				 		if( $(this).val()  && !$(item).hasClass( 'dropdown-toggle' ) ) {
				 			$(item).addClass( 'dropdown-toggle' );
				 			$(item).attr( 'data-toggle', 'pgl-dropdown' );

				 		 	var div = '<div class="dropdown-menu"><div class="dropdown-menu-inner"><div class="row active"></div></div></div>';
				 		 	$(activeMenu).addClass('parent').addClass('dropdown');
				 		 	$(activeMenu).append( div );
				 		 	$(activeMenu).removeClass('disable-menu');
				 		} else if(  $(this).val() == 1 ) {
			 				$(activeMenu).removeClass('disable-menu');
				 		}else {
			 				//$(activeMenu).addClass('disable-menu');
			 				$(activeMenu).removeClass('parent').find('.dropdown-menu').remove();
				 		}
				 		$(activeMenu).data('submenu', $(this).val() );
				 	}else if( $(this).hasClass('menu_subwidth') ){
				 		var width = parseInt( $(this).val() );
				 		if( width > 200 ){
				 			$(".dropdown-menu", activeMenu ).width( width );
 							$(activeMenu ).children('.dropdown-menu').width( width );
			 				$(activeMenu ).children('.dropdown-mega').width( width );
				 		}
				 	}
			 	}
		 	} );

			$("input.menu_subwidth","#menu-form").keypress( function( event ){

				if ( event.which == 13 ) {
				    event.preventDefault();
				}
				var $this = this;
				 setTimeout( function(){
			 		var width = parseInt( $($this).val() );
				 	if( width > 199 ){
			 			$(activeMenu ).children('.dropdown-menu').width( width );
			 			$(activeMenu ).children('.dropdown-mega').width( width );
			 			$(activeMenu).data('subwidth', width );
			 		}

				 }, 300 );
			} );
		}

		/**
	 	 * submenu handler.
	 	 */
		function submenuForm(){
			$("select, input", '#submenu-form').change( function(){
			 	 if( activeMenu ){
			 	 	if( $(this).attr('name') == 'submenu_group' ){
			 	 		if( $(this).val() == 1 ){
		 	 				$(activeMenu).addClass('mega-group');
					 		$(activeMenu).children(".dropdown-menu").addClass('dropdown-mega').removeClass('dropdown-menu');

			 	 		}else {
					 		$(activeMenu).removeClass('mega-group');
					 		$(activeMenu).children(".dropdown-mega").addClass('dropdown-menu').removeClass('dropdown-mega');
					 	}
					 	$( activeMenu ).data('group', $(this).val() );
			 	 	}
			 	 }
			} );
		}

		/**
	 	 * listen Events to operator Elements of MegaMenu such as link, colum, row and Process Events of buttons of setting forms.
	 	 */
		function listenEvents( $megamenu ){

			/**
			 *  Link Action Event Handler.
			 */
			$('.form-setting').hide();
			$( 'a', $megamenu ).click( function(event){

				var $this = this;
				var  $parent = $(this).parent();
				/* remove all current row and column are actived */
				$(".row", $megamenu).removeClass('active');
				$(".pgl-col", $megamenu).removeClass('active');


 				activeMenu = $parent;

			 	if( $parent.hasClass('dropdown-submenu') ){
			 		 $( ".dropdown-submenu", $parent.parent() ).removeClass( 'open' );
			 		 $parent.addClass('open');
			 		 processSubMenu( $this, $parent, $megamenu );
			 	}else {
			 		if( $parent.parent().hasClass('megamenu') ){
	                	 $("ul.navbar-nav > li" ).removeClass('open');
	             	}
	                $parent.addClass('open');

                 	processMenu ( $this, $parent, $megamenu );

	             }
	            if($parent.hasClass('parent')){
 					$('select.menu_submenu option[value="1"]').prop('selected', true);
 				}else{
 					$('select.menu_submenu option[value="0"]').prop('selected', true);
 				}

		         event.stopPropagation();
		         return false;
			});


			/**
			 * Row action Events Handler
			 */
			 $("#menu-form .add-row").click( function(){
			 	var row = $( '<div class="row"></div>'  );
			 	var child = $(activeMenu).children('.dropdown-menu').children('.dropdown-menu-inner');
			 	child.append( row );
			 	child.children(".row").removeClass('active');
			 	row.addClass('active');

			 });

			  $("#menu-form .remove-row").click( function(){
			  	if( activeMenu ){
			  		 var hasMenuType = false;
			  		 $(".row.active", activeMenu).children('.pgl-col').each( function(){
			  		 	if( $(this).data('type') == 'menu' ){
			  		 		hasMenuType = true;
			  		 	}
			  		 });

			  		if( hasMenuType == false ){
		  				$(".row.active", activeMenu).remove();
		  			}else {
		  				alert( 'You can remove Row having Menu Item(s) Inside Columns' );
		  				return true;
		  			}
		  			removeRowActive();
			  	}

			 });

			 $($megamenu).delegate( '.row', 'click', function(e){
		 		$(".row",$megamenu).removeClass('active');
		 		$(this).addClass('active');
		 		$('#admin-menu-action>div').hide();
		 		$('#menu-form').show();
		 		e.stopPropagation();
	    	 });

			 /**
			  * Column action Events Handler
			  */
			 $("#menu-form .add-col").click( function(){
		 		if ( activeMenu ){
		 			var num = 6;
		 			var col = $( '<div class="col-md-'+num+' pgl-col active"><div></div></div>'  );
		 			$(".pgl-col",activeMenu).removeClass('active');
					$( ".row.active", activeMenu ).append( col );
					col.data( 'colwidth', num );
					var cols = $(".dropdown-menu .pgl-col", activeMenu ).length;
					$(activeMenu).data('cols', cols);
		 		}

		 		recalculateColsWidth();
			 } );

			 $(".remove-col").click( function(){
			 	if( activeMenu ){
			 		if( $(".pgl-col.active", activeMenu).data('type') == 'menu' ) {
			 			alert('You could not remove this column having menu item(s)');
			 			return true;
			 		}else {
			 			$(".pgl-col.active", activeMenu).remove();
			 		}
			 	}

			 	removeColumnActive();
			 	recalculateColsWidth();
			 } );


		 	$($megamenu).delegate( '.pgl-col > div', 'click', function(e){

		 		$(".pgl-col",$megamenu).removeClass('active');

		 		$('#admin-menu-action>div').hide();
		 		var colactive = $(this).parent();
	 		 	var pos =  $(colactive).offset();
	 		 	$(colactive).addClass('active');

		 		$("#column-form").show();

		 		$(".row",$megamenu).removeClass('active');

		 		$(colactive).parent().addClass('active');
		 		$("#submenu-form").hide();
		 		$.each( $(colactive).data(), function( i, val ){
	 				$('[name='+i+']','#column-form').val( val );
	 			} );

		 		e.stopPropagation();
		 	} );


		 	/**
		 	 * Column Form Action Event Handler
		 	 */
		 	$('input, select', '#column-form').change( function(){
		 		if( activeMenu ) {
		 			var col = $( ".pgl-col.active", activeMenu );
		 			if( $(this).hasClass('colwidth') ){
		 				var cls = $(col).attr('class').replace(/col-md-\d+/,'');
		 				$(col).attr('class', cls + ' col-md-' + $(this).val() );
		 			}
		 			$(col).data( $(this).attr('name') ,$(this).val() );
		 		}
	 		} );

		 	$(".form-setting").each( function(){
		 		var $p = $(this);
		 		$(".popover-title span",this).click( function(){
		 			if( $p.attr('id') == 'menu-form' ){
		 				removeMenuActive();
		 			}else if( $p.attr('id') == 'column-form' ){
		 				removeColumnActive();
		 			}else {
		 				$('#submenu-form').hide();
		 			}
		 		} );
		 	} );

 			/**
 			 * inject widgets
 			 */
 			 $("#btn-inject-widget").click( function(){
 			 	var wid = $('select', $(this).parent() ).val();
 				if( wid > 0 ){
 					var col = $( ".pgl-col.active", activeMenu );
 					var a =  $(col).data( 'widgets') ;

 					if( $(col).data( 'widgets') ){
 						if( $(col).data( 'widgets').indexOf("wid-"+wid ) == -1 ) {
 							$(col).data( 'widgets', a +"|wid-"+wid );
 						}
 					}else {
 						$(col).data( 'widgets', "wid-"+wid );
 				 	}
		 			$(col).children('div').html('<div class="loading">Loading....</div>');
 				 	$.ajax({
						url: config.action_widget,
						data:'widgets='+$(col).data( 'widgets'),
						type:'POST',
						}).done(function( data ) {
				 		$(col).children('div').html( data );
				   });

 				}else {
 					alert( 'Please select a widget to inject' );
 				}
 			 } );


 			 /**
 			  * unset mega menu setting
 			  */
 			  $("#unset-data-menu").click( function(){
 				 if( confirm('Are you sure to reset megamenu configuration') ){
 				    $.ajax({
						url: config.action,
						data: 'reset=1',
						type:'POST',
						}).done(function( data ) {
					 		 location.reload();
				    });
				}
				return false;
 			  } );


 			$($megamenu).delegate( '.pgl-widget', 'hover', function(){
	    	 	 var w = $(this);
	    	 	 	var col = $(this).parent().parent();
	    	 	 if( $(this).find('.w-setting').length<= 0 ){
	    	 	 	var _s = $('<span class="w-setting"></span>');
	    	 	 	$(w).append(_s);
	    	 	 	_s.click( function(){

	    	 	 		var dws = col.data('widgets')+"|";
	    	 	 	 	var dws = dws.replace( $(w).attr('id')+"|",'' ).replace(/\|$/,'');
	    	 	 		col.data('widgets',dws);
	    	 	 		$(w).remove();
	    	 	 	} );
	    	 	 }
	    	 });


 			$(".button-alignments button").click( function(){
 				if( activeMenu ){
	 				$(".button-alignments button").removeClass( "active");
	 				$(this).addClass( 'active' );

	 				$(activeMenu).data( 'align', $(this).data("option") );
	 			 	var cls = $( activeMenu ).attr("class").replace(/aligned-\w+/,"");
	 			  	$( activeMenu ).attr( 'class', cls );
	 				$( activeMenu ).addClass( $(this).data("option") );
 				}
 			} );
		}

		function recalculateColsWidth(){
			if( activeMenu ){
				var childnum = $( "#mainmenutop .row.active" ).children(".pgl-col").length;

				var dcol = Math.floor( 12/childnum );
				var a = 12%childnum;
				$( "#mainmenutop .row.active" ).children(".pgl-col").each( function(i, col ) {
					if( a > 0 && (i == childnum-1) ){
			 			dcol = dcol+a;
					}
		 			var cls = $(this).attr('class').replace(/col-md-\d+/,'');
		 			$(this).attr('class', cls + ' col-md-' + dcol );
					$(this).data( 'colwidth', dcol );
				});
			}
		}

	 	/**
	 	 * remove active status for current row.
	 	 */
	 	function removeRowActive(){
	 		$('#column-form').hide();
 			$( "#mainmenutop .row.active" ).removeClass('active');
	 	}

	 	/**
	 	 * remove column active and hidden column form.
	 	 */
	 	function removeColumnActive(){
	 		$('#column-form').hide();
	 		$( "#mainmenutop .pgl-col.active" ).removeClass('active');
	 	}

	 	/**
	 	 * remove active status for current menu, row and column and hidden all setting forms.
	 	 */
	 	function removeMenuActive(){
	 		$('.form-setting').hide();
	 		$( "#mainmenutop .open" ).removeClass('open');
	 		$( "#mainmenutop .row.active" ).removeClass('active');
 			$( "#mainmenutop .pgl-col.active" ).removeClass('active');
 			if( activeMenu ) {
		 		activeMenu = null;
	 		}
	 	}

	 	/**
	 	 * process saving menu data using ajax request. Data Post is json string
	 	 */
	 	function saveMenuData(){
	 	 	var output = new Array();
	 	 	 $("#megamenu-content #mainmenutop li.parent").each( function() {
				 	var data = $(this).data();
				 	data.rows = new Array();

				 	$(this).children('.dropdown-menu').children('div').children('.row').each( function(){
				 		var row =  new Object();
				 		row.cols = new Array();
			 			$(this).children(".pgl-col" ).each( function(){
			 				row.cols.push( $(this).data() );
			 			} );
			 			data.rows.push(row);
				 	} );

				 	output.push( data );
	 	 	 }  );
 	 	 	var j = JSON.stringify( output );
 	 	 	var params = 'params='+j;

 	 	 	$.ajax({
				url: config.action_menu,
				data:params,
				type:'POST',
				}).done(function( data ) {
		 		 location.reload();
		   });
	 	}

	 	/**
	 	 * Make Ajax request to fill widget content into column
	 	 */
	 	function loadWidgets(){
	 		$("#pgl-progress").hide();
	 		var ajaxCols = new Array();
	 		$("#megamenu-content #mainmenutop .pgl-col").each( function() {
	 		 	var col = $(this);

	 		 	if( $(col).data( 'widgets') && $(col).data("type") != "menu" ){
	 		 		ajaxCols.push( col );
				}
	 		});

	 		var cnt = 0;
	 		if( ajaxCols.length > 0 ){
	 			$("#pgl-progress").show();
	 			$("#megamenu-content").hide();
	 		}
	 		$.each( ajaxCols, function (i, col) {
	 			$.ajax({
					url: config.action_widget,
					data:'widgets='+$(col).data( 'widgets'),
					type:'POST',
					}).done(function( data ) {
			 		col.children('div').html( data );
			 		cnt++;
			 		$("#pgl-progress .progress-bar").css("width", (cnt*100)/ajaxCols.length+"%" );
			 		if( ajaxCols.length == cnt ){
			 			$("#pgl-progress").delay(600).fadeOut();
			 			$("#megamenu-content").delay(1000).fadeIn();
			 		}
		 			$( "a", col ).attr( 'href', '#megamenu-content' );
			   });
	 		});
	 	}

	 	/**
	 	 * reload menu data using in ajax complete and add healders to process events.
	 	 */
	 	function reloadMegamenu(){
			var megamenu = $("#megamenu-content #mainmenutop");
			$( "a", megamenu ).attr( 'href', '#' );
			$( '[data-toggle="dropdown"]', megamenu ).attr('data-toggle','pgl-dropdown');
			listenEvents( megamenu );
			submenuForm();
			menuForm();
		 	loadWidgets();
	 	}

	 	/**
	 	 * initialize every element
	 	 */
		this.each(function() {
			var megamenu = this;

			$("#form-setting").hide();
			reloadMegamenu(  );

			$("#save-data-menu").click( function(){
	 			saveMenuData();
			} );

	 	// 	saveMenuData();
			/*
			$.ajax({
				url: config.action,
				}).done(function( data ) {
			 		$("#megamenu-content").html( data );
			 		reloadMegamenu(  );
			 		$("#save-data-menu").click( function(){
			 			saveMenuData();
			 		} );
		   }); */
			addModalBox();
			editWidget();
			removeWidget();
		});

		function removeWidget(){
			$('.tab-content').delegate('.pgl-delete','click',function(){
				if(confirm('Are you sure?')){
					var $tr = $(this).parent().parent();
					$.ajax({
						url: ajaxurl+'?action=pgl_shortcode_delete',
						type: 'POST',
						data: {id: $(this).attr('data-id')},
						success:function(response){
							if(response){
								$tr.fadeOut(200);
								setTimeout(function(){
									$tr.remove();
									$('.dropdown-menu-inner #wid-'+response).remove();
									$('#column-form [name="inject_widget"] option[value="'+response+'"]').remove();
								},250);
							}
						}
					});
				}
				return false;
			});
		}

		function editWidget(){
			$('.megamenu-pages').undelegate('.pgl-edit-widget', 'click');
			$('.megamenu-pages').delegate('.pgl-edit-widget', 'click',function(){
				$('#myModal .modal-content .spinner.top').show();
				$('#myModal .modal-dialog').css('width',980);
				var $type = $(this).attr('data-type');
				var $id = $(this).attr('data-id');
				$('#myModal .modal-body .modal-body-inner').html("");
				$('#myModal .modal-body .modal-body-inner').load(ajaxurl+'?action=pgl_shortcode_button&type='+$type+'&id='+$id,function(){
					$('#myModal .modal-content .spinner.top').hide();
					$('#myModal .modal-body .modal-body-inner .pgl-button-back').remove();
					$('#myModal .modal-body .textarea_html').each(function(){
						init_textarea_html($(this));
				    });
				});
				$('#myModal').modal();
				return false;
			});
			$('#myModal').undelegate('.pgl-button-save', 'click');
			$('#myModal').delegate('.pgl-button-save', 'click', function(event) {
				var datastring = $('#pgl-shortcode-form').serialize();
				$.ajax({
					url: ajaxurl+'?action=pgl_shortcode_save',
					type: 'POST',
					dataType :'JSON',
					data: datastring,
					beforeSend:function(){
						$('#myModal .pgl-widget-message').html("");
						$('#myModal #pgl-shortcode-form').find('input,button,radio,select,textarea').prop('disabled',true);
						$('#myModal #pgl-shortcode-form .spinner-button').show();
					},
					success:function(response){
						$('#myModal #pgl-shortcode-form').find('input,button,radio,select,textarea').prop('disabled',false);
						$('#myModal .pgl-widget-message').append('<div class="alert alert-success"><strong>'+response.message+'</strong><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a></div>');
						$('#myModal #pgl-shortcode-form .spinner-button').hide();
						$('#manage-widget table tr[data-widget-id="'+response.id+'"] .name').text(response.title);
						$('#column-form [name="inject_widget"] option[value="'+response.id+'"]').text(response.title);
					}
				});
			});

			$('#myModal').on('hidden.bs.modal', function () {
				$('#myModal .pgl-widget-message').html("");
			});
		}

		function addModalBox(){
			$(".btn-modal").click( function(){
				$('#myModal .modal-content .spinner.top').show();
				$('#myModal .modal-dialog').css('width',980);
				$('#myModal .modal-body .modal-body-inner').html("");
				$('#myModal .modal-body .modal-body-inner').load($(this).attr('href'),function(){
					$('#myModal .modal-body .spinner.top').hide();
				});
				$('#myModal').modal();
				$('#myModal').attr('rel', $(this).attr('rel') );
				return false;
			} );
		}
		//disable submit form with Enter key
		$(".form-setting input").keypress(function(event) {
			if (event.which == 13) {
				event.preventDefault();
				return false;
			}
		});
		return this;
	};

})(jQuery);
