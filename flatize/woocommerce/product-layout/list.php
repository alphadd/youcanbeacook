<div class="product_list_widget">
	<?php $_delay = 200; ?>
	<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
		<?php wc_get_template( 'content-widget-product.php', array( 'show_rating' => false, 'show_category'=> true , 'is_animate'=>true , 'delay' => $_delay ) ); ?>
		<?php $_delay+=300; ?>
	<?php endwhile; ?>
</div>