<?php
	$_delay = 200;
?>
<div class="row">
	<div data-owl="slide" data-item-slide="<?php echo $columns_count; ?>" class="owl-carousel product-slide">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
			<div class="col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo $_delay; ?>ms">
				<?php wc_get_template_part( 'content', 'product-inner' ); ?>
			</div>
			<?php $_delay+=300 ?>
		<?php endwhile; ?>
	</div>
</div>
