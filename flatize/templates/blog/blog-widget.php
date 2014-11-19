<?php if($loop->have_posts()): ?>
	<div class="post-widget">
	<?php
		while($loop->have_posts()):$loop->the_post();
	?>
		<article class="item-post clearfix">
			<?php
				if(has_post_thumbnail()){
			?>
			<a href="<?php the_permalink(); ?>">
				<?php the_post_thumbnail( 'widget' ); ?>
			</a>
			<?php } ?>
			<h6>
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h6>
			<p class="post-date">
				<i class="fa fa-eye"></i>
				<?php echo pgl_get_post_views(get_the_ID()); ?> Views
			</p>
		</article>
	<?php endwhile; ?>
	</div>
<?php endif; ?>
<?php wp_reset_query(); ?>