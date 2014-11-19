<?php
/*
*Template Name: Blog
*
*/

// Meta Configuration
$post_id = $post->ID;
$post_per_page = get_post_meta( $post_id, '_pgl_blog_count', true );
$is_breadcrumb = get_post_meta( $post_id, '_pgl_show_breadcrumb', true );
$blog_skin = get_post_meta( $post_id, '_pgl_blog_skin', true );

if($blog_skin=='mini'){
	add_filter( 'pgl_gallery_image_size' , create_function('', 'return "blog-mini";') );
	add_filter( 'pgl_single_image_size' , create_function('', 'return "blog-mini";') );
}

if(is_front_page()) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$args = array(
	'post_type' => 'post',
	'paged' => $paged,
	'posts_per_page'=>$post_per_page
);
$blog = new WP_Query($args);

?>

<?php pgl_get_header( ); ?>

<?php if($is_breadcrumb) get_template_part( 'templates/breadcrumb' ); ?>

<div id="pgl-mainbody" class="container pgl-mainbody">
	<div class="row">
		<!-- MAIN CONTENT -->
		<div id="pgl-content" class="pgl-content clearfix <?php echo apply_filters( 'pgl_main_class', '' ); ?>">
			<?php if ( $blog->have_posts() ) : ?>
				<?php /* The loop */ ?>
				<?php while ( $blog->have_posts() ) : $blog->the_post(); ?>
					<?php get_template_part( 'templates/blog/blog', $blog_skin); ?>
				<?php endwhile; ?>
			<?php else : ?>
				<?php get_template_part( 'templates/none' ); ?>
			<?php endif; ?>
			<?php pgl_pagination($prev = '&laquo;', $next = '&raquo;', $pages=$blog->max_num_pages); ?>
		</div>
		<!-- //END MAINCONTENT -->
		
		<?php do_action('pgl_sidebar_render'); ?>

  </div>
</div>

<?php get_footer(); ?>