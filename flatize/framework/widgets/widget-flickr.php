<?php

class PGL_Flickr_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            // Base ID of your widget
            'pgl_flickr_widget',
            // Widget name will appear in UI
            __('PGL Flickr', 'flatize'),
            // Widget description
            array( 'description' => __( 'The most recent photos from flickr.', 'flatize' ), )
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        extract( $instance );

        $title = apply_filters('widget_title', $instance['title']);
        
        echo $before_widget;
            if ( $title ) {
                echo $before_title . $title . $after_title;
            }
            ?>
            <div class="flickr-gallery">
                <?php echo "<script type='text/javascript' src='http://www.flickr.com/badge_code_v2.gne?count={$number}&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user={$flickr_id}'></script>"; ?>
            </div>
        <?php echo $after_widget;
    }
// Widget Backend
    public function form( $instance ) {
        $defaults = array(
            'title' => 'Photos from Flickr',
            'flickr_id' => '', 
            'number' => 6
        );
        $instance = wp_parse_args((array) $instance, $defaults); ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('flickr_id'); ?>">Flickr ID(<a onclick="window.open('http://idgettr.com/');return false;" href="#">Get your flickr ID</a>):</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('flickr_id'); ?>" name="<?php echo $this->get_field_name('flickr_id'); ?>" value="<?php echo $instance['flickr_id']; ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>">Number of photos to show:</label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $instance['number']; ?>" />
        </p>
<?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        $instance['title'] = strip_tags($new_instance['title']);
        $instance['flickr_id'] = $new_instance['flickr_id'];
        $instance['number'] = $new_instance['number'];

        return $instance;

    }
}

register_widget( 'PGL_Flickr_Widget' );