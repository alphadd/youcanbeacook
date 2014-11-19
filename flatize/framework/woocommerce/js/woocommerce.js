!function ($) {
	"use strict";
	$(document).ready(function() {
		$('.quickview').click(function(){
        	var proid = $(this).data('proid');
   			var data = { action: 'pgl_quickview', product: proid};
   			var loading = $(this).prev();
   			loading.show();
   			$.post(ajaxurl, data, function(response) {
   				$.magnificPopup.open({
					items: {
						src: '<div class="product-quickview">'+response+'</div>', // can be a HTML string, jQuery object, or CSS selector
						type: 'inline'
					}
				});
				$('.quickview-slides').owlCarousel({
					navigation : false,
					pagination: true,
					items :1,
				});
				loading.hide();
   			});
			return false;
        });

		// Ajax Remove Cart
		$(document).on('click', '.pgl_product_remove', function(event) {
			var $this = $(this);
			var product_id = $this.data('product-id');
	        $.ajax({
	            type: 'POST',
	            dataType: 'json',
	            url: ajaxurl,
	            data: { action: "cart_remove_product", 
	                    product_id: product_id
	            },success: function(data){
	            	console.log(data);
	                var $cart = $this.parents('.shoppingcart');
	                $cart.find('.dropdown-toggle .badge').text(data.count);
	                var $total = $cart.find('.dropdown-menu .total');
	                $total.find('.amount').remove();
	                $total.append(data.subtotal);
	                $this.parent().remove();
	            }
	        });
	        return false;
		});
		$('.pgl_product_remove').click(function(){
			
		});

	});
}(jQuery);