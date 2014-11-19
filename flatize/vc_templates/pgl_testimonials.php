<?php

extract( shortcode_atts( array(
	'title'=>'Testimonials',
	'el_class' => '',
	'skin'=>'skin-1'
), $atts ) );

$_id = pgl_make_id();
$_count = 0;
$args = array(
	'post_type' => 'testimonial',
	'posts_per_page' => -1,
	'post_status' => 'publish'
);

$query = new WP_Query($args);
?>

<div class="box pgl-testimonial <?php echo $skin; ?> white text-center">
	<?php if($query->have_posts()){ ?>
		<div id="carousel-<?php echo $_id; ?>" class="inner-content post-widget media-post-carousel carousel slide" data-ride="carousel">
        <img src="../../../uploads/2014/09/tami-360x360.jpg" class="img-responsive img-circle" alt=""/>

        <div class="carousel-inner testimonial-carousel">
			<?php while($query->have_posts()):$query->the_post(); ?>
				<!-- Wrapper for slides -->
				<div class="item<?php echo (($_count==0)?" active":"") ?>">
					<blockquote>
						<?php the_content(); ?>
						<footer>by <cite title="<?php the_title(); ?>"><?php the_title(); ?></cite></footer>
					</blockquote>
				</div>
				<?php $_count++; ?>
			<?php endwhile; ?>
			</div>
		</div>
	<?php } ?>
</div>
<?php wp_reset_query(); ?>