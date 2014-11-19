
<div class="page-found clearfix">
	<h2 class="entry-title"><?php echo __( 'Nothing Found', 'flatize' ); ?></h2>
</div>
<article class="wrapper">
	<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

	<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'flatize' ), admin_url( 'post-new.php' ) ); ?></p>

	<?php elseif ( is_search() ) : ?>

	<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'flatize' ); ?></p>
	<?php get_search_form(); ?>

	<?php else : ?>

	<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'flatize' ); ?></p>
	<?php get_search_form(); ?>

	<?php endif; ?>
</article>