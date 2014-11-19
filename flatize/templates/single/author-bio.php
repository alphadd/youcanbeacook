
<div class="title">
	<h4 class="heading">
		<?php echo __( 'About the Author :', 'flatize' ); ?>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
			<?php echo get_the_author(); ?>
		</a>
	</h4>
</div>

<div class="author-about-container clearfix">
	<div class="avatar-img">
		<?php echo get_avatar( get_the_author_meta( 'user_email' ),72 ); ?>
	</div>
	<!-- .author-avatar -->
	<div class="description">
		<?php the_author_meta( 'description' ); ?>
	</div>
</div>
