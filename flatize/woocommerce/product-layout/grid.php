<?php 
	$_delay = 200;
	$_count = 1;
?>
<div class="row">
<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
	<?php
        $class_fix = '';
        // Store loop count we're currently on
        if ( 0 == ( $_count - 1 ) % $columns_count || 1 == $columns_count )
            $class_fix .= ' first';
        if ( 0 == $_count % $columns_count )
            $class_fix .= ' last';
    ?>
	<!-- Product Item -->
	<div class="<?php echo $class_column.$class_fix; ?> product-col wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo $_delay; ?>ms">
		<?php wc_get_template_part( 'content', 'product-inner' ); ?>
	</div>
	<?php $_delay+=300; ?>
	<!-- End Product Item -->
	<?php
		if($_count==$columns_count){
			$_count=0;$_delay=200;
		}
		$_count++;
	?>
<?php endwhile; ?>
</div>