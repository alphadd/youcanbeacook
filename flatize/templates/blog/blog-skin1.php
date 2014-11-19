<?php global $post,$_config; ?>


<div class="col-md-<?php echo $_config['column']; ?> col-sm-<?php echo $_config['column']; ?> wow fadeInUp item-grid" data-wow-delay="<?php echo $_config['delay']; ?>ms">
   
    <div class="post-thumb">
        <?php
            if ( has_post_format( 'video' )) {
            ?>
                <div class="video-responsive">
                    <?php pgl_embed(); ?>
                </div>
            <?php
            }
            else if ( has_post_format( 'audio' )) {
            ?>
                <div class="audio-thumb audio-responsive">
                    <?php pgl_embed(); ?>
                </div>
            <?php
            }
            else if ( has_post_format( 'gallery' )) {
                $_imgs = pgl_gallery();
            ?>
                <div id="post-slide-<?php the_ID(); ?>" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($_imgs as $key => $_img) {
                            echo '<div class="item '.(($key==0)?'active':'').'">';
                                echo '<img src="'.$_img.'" alt="">';
                            echo '</div>';
                        } ?>
                    </div>
                    <a class="left carousel-control" href="#post-slide-<?php the_ID(); ?>" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#post-slide-<?php the_ID(); ?>" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
            <?php
            }
            else if (has_post_thumbnail()) {
            ?>
            <a href="<?php the_permalink(); ?>" class="post-img-1">
                <?php the_post_thumbnail('blog-thumbnail');?>
            </a>
            <?php }
        ?>
    </div>
    <div class="title">
        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_title() ); ?>"><?php the_title(); ?></a>
    </div>
    <div class="date"><?php the_time( 'd M Y' ); ?></div>
</div>