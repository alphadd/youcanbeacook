
<?php pgl_get_header(); ?>

<div id="pgl-mainbody" class="container pgl-mainbody">
    <div class="row">
        <!-- MAIN CONTENT -->
        <div id="pgl-content" class="pgl-content clearfix <?php echo apply_filters( 'pgl_main_class', '' ); ?>">
            <?php  if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'templates/blog/blog'); ?>
                    <?php endwhile; ?>
                    <?php pgl_pagination($prev = '&laquo;', $next = '&raquo;'); ?>
            <?php else : ?>
                <?php get_template_part( 'templates/none' ); ?>
            <?php endif; ?>
        </div>
        <!-- //END MAINCONTENT -->

        <?php do_action('pgl_sidebar_render'); ?>

    </div>
</div>

<?php get_footer(); ?>