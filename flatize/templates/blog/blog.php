
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container'); ?>>
	
	<h2 class="blog-title">
		<a href="<?php the_permalink(); ?>">
			<?php the_title(); ?>
		</a>
	</h2>

	<?php do_action('pgl_post_before_content'); ?>

	<div class="blog-content">
		<?php echo pgl_get_excerpt(120); ?>
	</div>

	<div class="readmore">
		<a href="<?php the_permalink(); ?>" class="learn_more_btn"><?php echo __( 'Read More','flatize' ); ?></a>
	</div>

</article>