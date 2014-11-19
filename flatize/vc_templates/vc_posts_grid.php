<?php
$grid_link = $grid_layout_mode = $title = $filter= '';
$posts = array();
extract(shortcode_atts(array(
    'title' => '',
    'grid_columns_count' => 4,
    'grid_teasers_count' => 8,
    'grid_layout' => 'skin1', // title_thumbnail_text, thumbnail_title_text, thumbnail_text, thumbnail_title, thumbnail, title_text
    'grid_link_target' => '_self',
    'filter' => '', //grid,
    'grid_thumb_size' => 'thumbnail',
    'grid_layout_mode' => 'fitRows',
    'el_class' => '',
    'teaser_width' => '12',
    'orderby' => NULL,
    'order' => 'DESC',
    'loop' => '',
), $atts));
if(empty($loop)) return;
global $_config;
$_config = array();
$this->getLoop($loop);
$my_query = $this->query;
$args = $this->loop_args;

$_config['column'] = 12/$grid_columns_count;
$_config['delay'] = 200;

?>
<div class="grid-posts">
    <div class="row">
        <?php while ( $my_query->have_posts() ): $my_query->the_post();global $post; ?>
            <?php get_template_part( 'templates/blog/blog', $grid_layout ); ?>
            <?php $_config['delay']+=200; ?>
        <?php endwhile; ?>
    </div>
</div>
<?php
wp_reset_query();


