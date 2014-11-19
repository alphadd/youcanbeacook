<?php
/*
*Template Name: Visual Composer Template
*
*/
$post_id = $post->ID;
$is_breadcrumb = get_post_meta( $post_id, '_pgl_show_breadcrumb', true );
?>
<?php pgl_get_header(); ?>
<?php if($is_breadcrumb) get_template_part( 'templates/breadcrumb' ); ?>
<div id="pgl-mainbody" class="pgl-mainbody visual-composer">
	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="pgl-content" <?php post_class( 'pgl-content visual-layout' ); ?>>
			<?php the_content(); ?>
		</div>
		<?php //comments_template(); ?>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>