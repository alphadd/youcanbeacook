<?php

class PGL_Tabs_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pgl_tabs_widget',
            // Widget name will appear in UI
            __('PGL Tabs Widget', 'flatize'),
            // Widget description
            array( 'description' => __( 'Popular posts, recent post and comments.', 'flatize' ), )
        );
        $this->widgetName = 'tabs';
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $posts = $instance['posts'];
        $comments = $instance['comments'];
        $tags_count = $instance['tags'];
        $show_popular_posts = isset($instance['show_popular_posts']) ? 'true' : 'false';
        $show_recent_posts = isset($instance['show_recent_posts']) ? 'true' : 'false';
        $show_comments = isset($instance['show_comments']) ? 'true' : 'false';

        echo $before_widget;
        ?>
            <ul class="nav nav-tabs tab-widget">
                <?php if($show_popular_posts == 'true'): ?>
                    <li class="active">
                        <a href="#tab-popular" data-toggle="tab"><?php echo __('Popular', 'flatize' ); ?></a>
                    </li>
                <?php endif; ?>
                <?php if($show_recent_posts == 'true'): ?>
                    <li <?php if($show_popular_posts != 'true') echo 'class="active"'; ?>>
                        <a href="#tab-recent" data-toggle="tab"><?php echo __('Recent', 'flatize' ); ?></a>
                    </li>
                <?php endif; ?>
                <?php if($show_comments == 'true'): ?>
                    <li <?php if($show_popular_posts != 'true' && $show_recent_posts != 'true' ) echo 'class="active"'; ?>>
                        <a href="#tab-comments" data-toggle="tab"><?php echo __('Comments', 'flatize' ); ?></a>
                    </li>
                <?php endif; ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <?php if($show_popular_posts == 'true'): ?>
                    <div class="tab-pane active" id="tab-popular">
                        <?php $popular_posts = new WP_Query('showposts='.$posts.'&meta_key=pgl_post_views_count&orderby=meta_value_num&order=DESC'); ?>
                        <?php if($popular_posts->have_posts()): ?>
                            <div class="post-widget">
                            <?php
                                while($popular_posts->have_posts()):$popular_posts->the_post();
                            ?>
                                <article class="item-post clearfix">
                                    <?php
                                        if(has_post_thumbnail()){
                                    ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'widget' ); ?>
                                    </a>
                                    <?php } ?>
                                    <h6>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h6>
                                    <p class="post-date">
                                        <i class="fa fa-eye"></i>
                                        <?php echo pgl_get_post_views(get_the_ID()).__(' View(s)','flatize'); ?>
                                    </p>
                                </article>
                            <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                <?php endif; ?>
                <?php if($show_recent_posts == 'true'): ?>
                    <div class="tab-pane" id="tab-recent">
                        <?php $recent_posts = new WP_Query('showposts='.$tags_count); ?>
                        <?php if($recent_posts->have_posts()): ?>
                            <div class="post-widget">
                            <?php
                                while($recent_posts->have_posts()):$recent_posts->the_post();
                            ?>
                                <article class="item-post clearfix">
                                    <?php
                                        if(has_post_thumbnail()){
                                    ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'widget' ); ?>
                                    </a>
                                    <?php } ?>
                                    <h6>
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h6>
                                    <p class="post-date">
                                        <i class="fa fa-eye"></i>
                                        <?php echo pgl_get_post_views(get_the_ID()).__(' View(s)','flatize'); ?>
                                    </p>
                                </article>
                            <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        <?php wp_reset_query(); ?>
                    </div>
                <?php endif; ?>
                <?php if($show_comments == 'true'): ?>
                    <div class="tab-pane" id="tab-comments">
                        <div class="post-widget">
                            <?php
                            $number = $instance['comments'];
                            global $wpdb;
                            $recent_comments = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,110) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number";
                            $the_comments = $wpdb->get_results($recent_comments);
                            foreach($the_comments as $comment) { ?>
                            <article class="clearfix">
                                <?php echo get_avatar($comment, '52'); ?>
                                <h6>
                                    <?php echo strip_tags($comment->comment_author); ?> <?php __('says', 'flatize' ); ?>:<br>
                                    <a class="comment-text-side" href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo $comment->post_title; ?>">
                                        <?php echo pgl_string_limit_words(strip_tags($comment->com_excerpt), 12); ?>...
                                    </a>
                                </h6>
                            </article>
                            <?php } ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php
        echo $after_widget;
    }
// Widget Backend
    public function form( $instance ) {
        $defaults = array(  'posts' => 3,
                            'comments' => '3', 
                            'tags' => '3', 
                            'show_popular_posts' => true, 
                            'show_recent_posts' => true, 
                            'show_comments' => true, 
                        );
        $instance = wp_parse_args((array) $instance, $defaults);
        // Widget admin form
        ?>
        
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>">Popular Posts Order By:</label>
            <select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" class="widefat" style="width:100%;">
                <option <?php if ('Highest Comments' == $instance['orderby']) echo 'selected="selected"'; ?>>Highest Comments</option>
                <option <?php if ('Highest Views' == $instance['orderby']) echo 'selected="selected"'; ?>>Highest Views</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('posts'); ?>">Number of popular posts:</label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tags'); ?>">Number of recent posts:</label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" value="<?php echo $instance['tags']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('comments'); ?>">Number of comments:</label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" value="<?php echo $instance['comments']; ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_popular_posts'], 'on'); ?> id="<?php echo $this->get_field_id('show_popular_posts'); ?>" name="<?php echo $this->get_field_name('show_popular_posts'); ?>" />
            <label for="<?php echo $this->get_field_id('show_popular_posts'); ?>">Show popular posts</label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_recent_posts'], 'on'); ?> id="<?php echo $this->get_field_id('show_recent_posts'); ?>" name="<?php echo $this->get_field_name('show_recent_posts'); ?>" />
            <label for="<?php echo $this->get_field_id('show_recent_posts'); ?>">Show recent posts</label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo $this->get_field_id('show_comments'); ?>" name="<?php echo $this->get_field_name('show_comments'); ?>" />
            <label for="<?php echo $this->get_field_id('show_comments'); ?>">Show comments</label>
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['posts'] = $new_instance['posts'];
        $instance['comments'] = $new_instance['comments'];
        $instance['tags'] = $new_instance['tags'];
        $instance['show_popular_posts'] = $new_instance['show_popular_posts'];
        $instance['show_recent_posts'] = $new_instance['show_recent_posts'];
        $instance['show_comments'] = $new_instance['show_comments'];
        $instance['layout'] = ( ! empty( $new_instance['layout'] ) ) ? $new_instance['layout'] : 'default';
        return $instance;

    }
}

register_widget( 'PGL_Tabs_Widget' );