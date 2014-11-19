<?php
    global $post,$_config;
?>
<div class="blog-style2 text-center wow fadeInUp col-sm-<?php echo $_config['column']; ?>" data-wow-delay="<?php echo $_config['delay']; ?>ms">
    <div class="post-thumb">
         <a href="<?php the_permalink(); ?>" title="">
            <?php the_post_thumbnail('blog-thumbnail');?>
        </a>
    </div>
    <div class="title">
        <a href="<?php the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php the_title(); ?></a>
    </div>
    <div class="content">
        <?php echo pgl_get_excerpt(15,''); ?>
    </div>
    <div class="readmore">
        <a href="<?php the_permalink(); ?>" class="btn btn-transparent btn-lg"><?php _e('Read More','flatize'); ?></a>
    </div>
</div>