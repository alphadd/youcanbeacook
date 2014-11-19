<?php

$tag_ids = array();
$tags = get_the_tags();
if(!$tags)
    return;
foreach ($tags as $key => $value) {
    $tag_ids[] = $value->term_id;
}

$args = array(
    'tag__in'=>$tag_ids,
    'posts_per_page'=>3,
    'post__not_in'=>array(get_the_ID()),
    'orderby' =>'rand',
);

$relates = new WP_Query( $args );
if($relates->have_posts()):

?>
<div class="related-post-content">
    <h4 class="heading">
        <span><?php echo __('Related post','flatize')?></span>
    </h4>
    <div class="row related-post-inner">
        <?php while($relates->have_posts() ): $relates->the_post(); ?>
           <div class="col-md-4 col-sm-4">
                <div class="post-thumb">
                   <?php if ( has_post_thumbnail() ) {?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('wg-list-lager');?>
                            </a>
                        <?php }
                        else {?>
                            <a href="<?php the_permalink(); ?>">
                                <?php echo '<img src="' . get_stylesheet_directory_uri( ) . '/images/thumbnail-default.jpg"/>';?>
                            </a>
                        <?php } ?>
                </div>
                <div class="post-content">

                    <h5 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h5>
                </div>
       </div>
        <?php endwhile; ?>
    </div>
</div>
<?php endif; ?>
<?php wp_reset_query(); ?>