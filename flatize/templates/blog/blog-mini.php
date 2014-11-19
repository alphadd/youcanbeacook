
<article class="blog-container post post-medium">
	<div class="row">
		<div class="col-md-4">
			<?php pgl_set_post_thumbnail(); ?>
		</div>
		<div class="col-md-8">
			<h3>
				<a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
				</a>
			</h2>
			
			<?php pgl_set_post_meta(); ?>

			<div class="blog-content">
				<?php echo pgl_get_excerpt(30); ?>
			</div>

			<div class="readmore">
				<a href="<?php the_permalink(); ?>" class="btn btn-transparent btn-sm"><?php echo __( 'Read More','flatize' ); ?></a>
			</div>
		</div>
	</div>
</article>