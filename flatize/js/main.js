(function($){
	"use strict";

	var PGL_Parallax = function(){
		if(!Modernizr.touch){ 
		    jQuery.stellar();
		}
    }

    var PGL_FixIsotope = function(){
    	"use strict";
    	if(jQuery().isotope){
			jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
				jQuery('.isotope').isotope('reLayout');
			});
			jQuery('[id*="accordion-"]').on('shown.bs.collapse',function(e){
				jQuery('.isotope').isotope('reLayout');
			});
		}
    }

    var PGL_Carousel = function(){
		var owl = $('[data-owl="slide"]');
		var $item = owl.data('item-slide');
		owl.owlCarousel({
			navigation : true,
			pagination: false,
			items : $item,
			itemsCustom : false,
			itemsDesktop : [1199,4],
			itemsDesktopSmall : [991,3],
			itemsTablet: [768,3],
			itemsTabletSmall: [640,2],
			itemsMobile : [480,1],
			singleItem : false,
			itemsScaleUp : false,
			navigationText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]
			
		});
		
		// Custom Navigation Events
		$("#owl-product-slide .next").click(function(){
			owl.trigger('owl.next');
		})
		
		$("#owl-product-slide .prev").click(function(){
			owl.trigger('owl.prev');
		})
    }

    var PGL_ButtonSearch_Login = function(){
    	"use strict";
    	var wpsearch = jQuery('#wp-search');
    	var wplogin = jQuery('#wp-login');
		jQuery('a.search-action').toggle(function() {
			wpsearch.addClass('open');
		}, function() {
			wpsearch.removeClass('open');
		});
		jQuery('a.login-action').toggle(function() {
			wplogin.addClass('open');
		}, function() {
			wplogin.removeClass('open');
		});
    }

    var PGL_Button_Back_Top = function(){
    	var _isScrolling = false;
    	$("#scrollToTop").click(function(e) {
			e.preventDefault();
			$("body, html").animate({scrollTop : 0}, 500);
			return false;
		});

		// Show/Hide Button on Window Scroll event.
		$(window).scroll(function() {
			if(!_isScrolling) {
				_isScrolling = true;
				if($(window).scrollTop() > 150) {
					$("#scrollToTop").stop(true, true).addClass("visible");
					_isScrolling = false;
				} else {
					$("#scrollToTop").stop(true, true).removeClass("visible");
					_isScrolling = false;
				}
			}
		});
    }

    var PGL_Header_Sticky = function(){
    	var $is_sticky = jQuery('#pgl-header').hasClass('header-style3');
    	if(!$is_sticky){
    		var _is_header_sticky = $('body').hasClass('header-sticky');
	    	if(_is_header_sticky){
	    		var $menufix = $('<div class="menu-sticky"></div>');
		    	var $menu_action = $('#pgl-mainbody').offset().top;
		    	$menufix.prependTo('body')
		    		.append('<div class="container"><div class="menu-sticky-wrap"></div></div>')
		    		.find('.menu-sticky-wrap').append($('#pgl-mainnav').clone())
		    		.prepend($('.logo').clone())
		    		.find('#pgl-mainnav')
		    		.find('.off-canvas-toggle').remove();
		    	
		    	$menufix.find('#pgl-mainnav').append($('.off-canvas-toggle').clone());
		    	$menufix.find('.off-canvas-toggle').click(function(){
		    		$('.header-wrapper .off-canvas-toggle').trigger('click');
		    	});
		    	$(window).scroll(function(event) {
		    		if( $(document).scrollTop() > $menu_action ){
						$menufix.addClass('fixed');
					}else{
						$menufix.removeClass('fixed');
					}
		    	});
	    	}
    	}

    	//Remove Carttop Header 3
    	if($is_sticky){
    		$('#header-topbar .shoppingcart').remove();
    	}
    }


	$(document).ready(function() {
		PGL_Header_Sticky();
		PGL_Carousel();
		PGL_Button_Back_Top();
		PGL_Parallax();
		PGL_FixIsotope();
		PGL_ButtonSearch_Login();

		// init Animate Scroll
        if( $('body').hasClass('pgl-animate-scroll') && !Modernizr.touch ){
            new WOW().init();
        }

	});

	$(window).resize(function(){

	});

    $(window).load(function(){

    });

})(jQuery);
