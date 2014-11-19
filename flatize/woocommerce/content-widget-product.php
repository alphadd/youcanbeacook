<?php global $product; ?>
<?php 
    $class = '';
    if(isset($is_animate) && $is_animate){
        $class = ' wow fadeInUp';
    }
    if(!isset($delay)){
        $delay = 0;
    }
?>
<div class="item-product-widget clearfix<?php echo $class; ?>" data-wow-duration="1s" data-wow-delay="<?php echo $delay; ?>ms">
    <div class="images pull-left">
        <?php echo $product->get_image(); ?>
    </div>
    <div class="product-meta">
        <?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
        <div class="title">
            <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
                <?php echo $product->get_title(); ?>
            </a>
        </div>
        <div class="category">
            <?php echo $product->get_categories( ', '); ?>
        </div>
        <?php echo $product->get_price_html(); ?>
    </div>
</div>