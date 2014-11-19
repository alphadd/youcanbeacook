 <?php
    global $post, $product, $woocommerce;
    $attachment_ids = $product->get_gallery_attachment_ids();
    $images =array();
    if(has_post_thumbnail()){
        $images[] = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ));
    }else{
        $images[] = '<img src="'.wc_placeholder_img_src().'"/>';
    }
    foreach ($attachment_ids as $attachment_id) {
        $images[]       = wp_get_attachment_image( $attachment_id, 'shop_single' );
    }
?> 
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>
    <div id="single-product" class="row woocommerce">
        <div class="col-sm-6">
            <div class="quickview-slides" itemprop="image">
                <?php foreach ($images as $key => $value) {
                    echo '<div class="item">'.$value.'</div>';
                } ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="summary entry-summary">
                <h1 itemprop="name" class="entry-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h1>
                <?php do_action( 'woocommerce_single_product_quickview_summary' ); ?>
            </div><!-- .summary -->
        </div>
    </div>
</div><!-- #product-<?php the_ID(); ?> -->