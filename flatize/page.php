<?php

// Meta Configuration
$post_id = $post->ID;

$is_breadcrumb = get_post_meta( $post_id, '_pgl_show_breadcrumb', true );
$is_breadcrumb = ($is_breadcrumb == '') ? true: $is_breadcrumb;

?>

<?php pgl_get_header( ); ?>
<div id="pgl-mainbody" class="container pgl-mainbody">
	<div class="row">
		<!-- MAIN CONTENT -->
		<div id="pgl-content" class="pgl-content <?php echo apply_filters( 'pgl_main_class', '' ); ?>">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('content'); ?>>
					<?php the_content(); ?>
				</article><!-- #post -->
				<?php //comments_template(); ?>
			<?php endwhile; ?>
		</div>

		<?php do_action('pgl_sidebar_render'); ?>

	</div>
</div>
<?php get_footer(); ?>