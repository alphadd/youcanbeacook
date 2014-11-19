
<?php pgl_get_header( ); ?>

<?php //get_template_part( 'templates/breadcrumb' ); ?>

<div id="pgl-mainbody" class="container pgl-mainbody">
	<div class="row">
		<!-- MAIN CONTENT -->
		<div id="pgl-content" class="pgl-content <?php echo apply_filters( 'pgl_main_class', '' ); ?>">
			<?php while ( have_posts() ) : the_post(); global $post; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('single-container'); ?>>
					<div class="post-name">
						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2>
					</div>
					
					<?php do_action('pgl_post_before_content'); ?>
					
					<div class="post-content">
						<?php the_content(); ?>
						<?php wp_link_pages(); ?>
					</div>

					<?php do_action('pgl_post_after_content') ?>
					

					<?php comments_template(); ?>
				</article>
			<?php endwhile; ?>
		</div>
		<!-- //MAIN CONTENT -->
		
		<?php do_action('pgl_sidebar_render'); ?>

	</div>
</div>

<?php get_footer(); ?>

