<?php

extract($atts);

switch ($columns_count) {
	case '4':
		$class_column='col-sm-3';
		break;
	case '3':
		$class_column='col-sm-4';
		break;
	case '2':
		$class_column='col-sm-6';
		break;
	default:
		$class_column='col-sm-12';
		break;
}

if($type=='') return;

global $woocommerce;

$_id = pgl_make_id();
$_count = 1;
$args = array(
	'post_type' => 'product',
	'posts_per_page' => $number,
	'post_status' => 'publish'
);
switch ($type) {
	case 'best_selling':
		$args['meta_key']='total_sales';
		$args['orderby']='meta_value_num';
		$args['ignore_sticky_posts']   = 1;
		$args['meta_query'] = array();
        $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
		break;
	case 'featured_product':
		$args['ignore_sticky_posts']=1;
		$args['meta_query'] = array();
		$args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
		$args['meta_query'][] = array(
                     'key' => '_featured',
                     'value' => 'yes'
                 );
		$query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
		break;
	case 'top_rate':
		add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
		$args['meta_query'] = array();
        $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
        $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
		break;
	case 'recent_product':
		$args['meta_query'] = array();
        $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
		break;
}

$loop = new WP_Query( $args );

if ( $loop->have_posts() ) : ?>
	<div class="woocommerce">
		<div class="inner-content">
			<?php if($layout=='list'){ ?>
				<div class="product_list_widget">
					<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
						<?php wc_get_template( 'content-widget-product.php', array( 'show_rating' => false, 'show_category'=> true ) ); ?>
					<?php endwhile; ?>
				</div>
			<?php }else{ ?>
			<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
					<!-- Product Item -->
					<div class="<?php echo $class_column ?>">
						<?php wc_get_template_part( 'content', 'product-inner' ); ?>
					</div>
					<!-- End Product Item -->
				<?php $_count++; ?>
			<?php endwhile; ?>
			<?php } ?>
		</div>
	</div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>


