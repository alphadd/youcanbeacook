<?php

define( 'PGL_WOOCOMMERCE_PATH', PGL_FRAMEWORK_PATH.'woocommerce/' );
define( 'PGL_WOOCOMMERCE_URI', PGL_FRAMEWORK_URI.'woocommerce/' );


global $theme_option,$pagenow;


/*==========================================================================
Woocommerce support
==========================================================================*/
add_theme_support( 'woocommerce' );

/*==========================================================================
Woocommerce Category Image
==========================================================================*/
function pgl_woocommerce_category_image(){
	if (is_product_category()) {
        global $wp_query;
        // get the query object
        $cat = $wp_query->get_queried_object();
        // get the thumbnail id user the term_id
        $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);

        if($thumbnail_id!=0){
            // get the image URL
            $image = wp_get_attachment_link($thumbnail_id, 'full');
        ?>
            <div class="category-image">
                <?php echo $image; ?>
            </div>
        <?php
    	}
    }
}
add_action( 'woocommerce_archive_description' , 'pgl_woocommerce_category_image' , 5 );


/*==========================================================================
Related Products
==========================================================================*/
add_filter( 'woocommerce_output_related_products_args', 'pgl_related_products_args' );
  function pgl_related_products_args( $args ) {
  	global $theme_option;
	$args['posts_per_page'] = $theme_option['woo-related-number'];
	$args['columns'] = $theme_option['woo-related-column'];
	return $args;
}

/*==========================================================================
Upsells Products
==========================================================================*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );

if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
		global $theme_option;
	    woocommerce_upsell_display( $theme_option['woo-upsells-number'], $theme_option['woo-upsells-column'] ); // Display 3 products in rows of 3
	}
}

/*==========================================================================
Cross Sells Products
==========================================================================*/
add_action( 'woocommerce_cross_sells_columns', 'pgl_cross_sells_columns' );
function pgl_cross_sells_columns(){
	global $theme_option;
	return $theme_option['woo-cross-sells-column'];
}
add_action( 'woocommerce_cross_sells_total', 'pgl_cross_sells_total' );
function pgl_cross_sells_total(){
	global $theme_option;
	return $theme_option['woo-cross-sells-number'];
}


/*==========================================================================
init woocommerce
==========================================================================*/
function pgl_woocommerce_init(){
	add_action( 'woocommerce_before_main_content',create_function('','get_template_part( "templates/breadcrumb" );'),9 );
	remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );
}
add_action('init','pgl_woocommerce_init');

/*==========================================================================
Custom js add to cart
==========================================================================*/
if($theme_option['woo-is-effect-add-cart']){
	add_action( 'wp_enqueue_scripts', 'pgl_woocommerce_custom_add_to_cart', 9 );
	function pgl_woocommerce_custom_add_to_cart() {
	    wp_enqueue_script( 'wc-add-to-cart', PGL_FRAMEWORK_URI . 'woocommerce/js/add-to-cart.js', array( 'jquery' ), WC_VERSION, true );
	}
}

/*==========================================================================
Cart Header
==========================================================================*/
global $theme_option;

if( isset($theme_option['header-is-cart']) && $theme_option['header-is-cart'] ):
	add_action( 'plg_main_menu_action' , 'pgl_cart_mainmenu' , 5 );
	add_action( 'pgl_topbar_right', 'pgl_cart_topbar', 10 );
endif;
function pgl_cart_mainmenu(){
	global $woocommerce;
?>
	<div class="icon-action dropdown shoppingcart pull-right">
        <a class="dropdown-toggle mini-cart inner" data-toggle="dropdown" data-hover="dropdown" data-delay="0" href="#" title="<?php echo esc_attr__( 'View your shopping cart', 'woothemes' ); ?>">
            <i class="fa fa-shopping-cart"></i>
            <span class="badge badge-inverse"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
        </a>
        <div class="dropdown-menu">
            <?php pgl_woocommerce_mini_cart(); ?>
        </div>
    </div>
<?php
}

function pgl_cart_topbar(){
    global $woocommerce;
?>
    <li class="dropdown shoppingcart pull-right">
        <a class="dropdown-toggle mini-cart inner" data-toggle="dropdown" href="#" title="<?php echo esc_attr__( 'View your shopping cart', 'woothemes' ); ?>">
            <i class="fa fa-shopping-cart"></i>
            <span class="badge badge-inverse"><?php echo $woocommerce->cart->cart_contents_count; ?></span>
        </a>
        <div class="dropdown-menu">
            <?php pgl_woocommerce_mini_cart(); ?>
        </div>
    </li>
<?php
}



function pgl_woocommerce_mini_cart(){
?>
	<ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

	<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );

					?>
					<li class="media">
						<a href="<?php echo get_permalink( $product_id ); ?>" class="cart-image pull-left">
							<?php echo $thumbnail; ?>
						</a>
						<div class="cart-main-content media-body">
							<div class="name">
								<a href="<?php echo get_permalink( $product_id ); ?>">
									<?php echo $product_name; ?>
								</a>
							</div>
							<p class="cart-item">
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
							</p>
						</div>
						<a href="#" data-product-id="<?php echo $product_id; ?>" class="pgl_product_remove">
							<i class="fa fa-trash-o"></i>
						</a>
					</li>
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

	<p class="total"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="buttons">
		<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="btn btn-transparent btn-white btn-sm btn-viewcart wc-forward"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
		<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="btn btn-primary btn-sm checkout wc-forward"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
	</p>

<?php endif; ?>
<?php
}

/*==========================================================================
Ajax Remove Cart
==========================================================================*/
add_action( 'wp_ajax_cart_remove_product', 'pgl_woocommerce_cart_remove_product' );
add_action( 'wp_ajax_nopriv_cart_remove_product', 'pgl_woocommerce_cart_remove_product' );
function pgl_woocommerce_cart_remove_product() {
    $cart = WC()->instance()->cart;
	$id = $_POST['product_id'];
	$cart_id = $cart->generate_cart_id($id);
	$cart_item_id = $cart->find_product_in_cart($cart_id);

	if($cart_item_id){
	   $cart->set_quantity($cart_item_id,0);
	}
	$output = array();
	$output['subtotal'] = $cart->get_cart_subtotal();
	$output['count'] = $cart->cart_contents_count;
	print_r( json_encode( $output ) );
    exit();
}

/*==========================================================================
Layout Shop : sidebar
==========================================================================*/
function pgl_woocommerce_layout_shop_sidebar($value){
	global $theme_option;
	return $theme_option['woo-shop-sidebar'];
}
add_filter( 'pgl_woocommerce_shop_sidebar' ,'pgl_woocommerce_layout_shop_sidebar' );

/*==========================================================================
Layout Single Product : sidebar
==========================================================================*/
function pgl_woocommerce_layout_single_sidebar($value){
	global $theme_option;
	return $theme_option['woo-single-sidebar'];
}
add_filter( 'pgl_woocommerce_single_sidebar' ,'pgl_woocommerce_layout_single_sidebar' );

/*==========================================================================
Ajax Add To cart
==========================================================================*/
add_filter('add_to_cart_fragments', 'pgl_woocommerce_ajax_cart');
function pgl_woocommerce_ajax_cart( $fragments ) {
	global $woocommerce;
	ob_start();
	pgl_cart_topbar();
	$fragments['#header-topbar .shoppingcart'] = ob_get_clean();
	ob_start();
	pgl_cart_mainmenu();
	$fragments['#pgl-mainnav .shoppingcart'] = ob_get_clean();
	ob_start();
	pgl_cart_mainmenu();
	$fragments['.header-action .shoppingcart'] = ob_get_clean();
	return $fragments;
}

/*==========================================================================
Set Column class
==========================================================================*/
add_filter( 'pgl_woocommerce_column_class', 'pgl_set_column_class' );
function pgl_set_column_class($value){
	global $woocommerce_loop;
	switch ($woocommerce_loop['columns']) {
		case '2':
			$value[] = 'col-sm-6';
			break;
		case '3':
			$value[] = 'col-sm-4';
			break;
		case '4':
			$value[] = 'col-md-3 col-sm-6';
			break;
		case '6':
			$value[] = 'col-sm-4 col-md-2';
			break;
		default:
			$value[] = 'col-md-3 col-sm-6';
			break;
	}
	return $value;
}


/*==========================================================================
Quick View
==========================================================================*/

if( $theme_option['woo-is-quickview'] ){

	add_action( 'wp_ajax_pgl_quickview', 'pgl_woocoomerce_quickView' );
	add_action( 'wp_ajax_nopriv_pgl_quickview', 'pgl_woocoomerce_quickView' );
	function pgl_woocoomerce_quickView(){
		global $post, $product, $woocommerce;
	    $prod_id =  $_POST["product"];
	    $post = get_post($prod_id);
	    $product = get_product($prod_id);
	    ob_start();
	?>

	<?php woocommerce_get_template( 'woocommerce-lightbox.php'); ?>

	<?php
	    $output = ob_get_contents();
	    ob_end_clean();
	    echo $output;
	    die();
	}

	add_action( 'woocommerce_after_shop_loop_item', 'pgl_button_quickview' , 5 );
	function pgl_button_quickview(){
		global $product;
	?>
		<div class="quickview-loading" style="display:none;">
			<div class="loading-item loading-1">
			</div>
			<div class="loading-item loading-2">
			</div>
			<div class="loading-item loading-3">
			</div>
			<div class="loading-item loading-4">
			</div>
			<div class="loading-item loading-5">
			</div>
			<div class="loading-item loading-6">
			</div>
			<div class="loading-item loading-7">
			</div>
			<div class="loading-item loading-8">
			</div>
		</div>
		<a href="#" class="button btn-quickview quickview"
           data-proid="<?php echo $product->id; ?>"
           ><i class="fa fa-external-link"></i></a>
	<?php
	}

	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_single_meta', 40 );
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_loop_add_to_cart', 30 );
}
/*==========================================================================
Override Widget Woocommerce
==========================================================================*/

add_action( 'widgets_init', 'pgl_woocoomerce_override_woocommerce_widgets' , 15 );
function pgl_woocoomerce_override_woocommerce_widgets() {
	$args = array(
		'WC_Widget_Cart',
		'WC_Widget_Layered_Nav',
		'WC_Widget_Layered_Nav_Filters',
		'WC_Widget_Price_Filter',
		'WC_Widget_Product_Categories',
		'WC_Widget_Products',
		'WC_Widget_Product_Search',
		'WC_Widget_Product_Tag_Cloud',
		'WC_Widget_Recently_Viewed',
		'WC_Widget_Recent_Reviews',
		'WC_Widget_Top_Rated_Products'
	);
	foreach ($args as $c) {
		if ( class_exists( $c ) ) {
			unregister_widget( $c );
			$file = PGL_THEME_DIR.'/woocommerce/widgets/'.str_replace('_', '-', str_replace( 'wc_' , '', strtolower($c) )).'.php';
			if(is_file($file)){
				include_once( $file );
			}
		}
	}
}

/*==========================================================================
Effect Hover Image Product
==========================================================================*/
if( $theme_option['woo-is-effect-thumbnail']){
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	add_action('woocommerce_before_shop_loop_item_title', 'pgl_woocommerce_template_loop_product_thumbnail' ,10);
	function  pgl_woocommerce_template_loop_product_thumbnail(){
		global $post, $product, $woocommerce;
		$placeholder_width = get_option('shop_catalog_image_size');
		$placeholder_width = $placeholder_width['width'];

		$placeholder_height = get_option('shop_catalog_image_size');
		$placeholder_height = $placeholder_height['height'];

		$output='';
		$class = 'image-no-effect';
		if(has_post_thumbnail()){
			$attachment_ids = $product->get_gallery_attachment_ids();
			if($attachment_ids) {
				$class = 'image-effect';
				$output.=wp_get_attachment_image($attachment_ids[0],'shop_catalog',false,array('class'=>"attachment-shop_catalog image-hover"));
			}
			$output.=get_the_post_thumbnail( $post->ID,'shop_catalog',array('class'=>$class) );
		}else{
			$output .= '<img src="'.woocommerce_placeholder_img_src().'" alt="'.__('Placeholder' , 'gp_lang').'" class="'.$class.'" width="'.$placeholder_width.'" height="'.$placeholder_height.'" />';
		}
		echo $output;
	}
}

/*==========================================================================
Change Config Woocommerce
==========================================================================*/
add_filter( 'loop_shop_columns', 'pgl_woocoomerce_wc_loop_shop_columns', 1 );
add_filter( 'loop_shop_per_page', 'pgl_woocoomerce_wc_product_per_page' , 20 );
function pgl_woocoomerce_wc_product_per_page($cols){
	global $theme_option;
	$number = $theme_option['woo-shop-number'];
	return $number;
}

function pgl_woocoomerce_wc_loop_shop_columns(){
	global $theme_option;
	$columns = $theme_option['woo-shop-column'];
	return $columns;
}

/*==========================================================================
Add Scripts
==========================================================================*/
add_action( 'wp_enqueue_scripts', 'pgl_woocoomerce_initScripts' );
function pgl_woocoomerce_initScripts(){
	wp_enqueue_script('PGL_quickview_js', PGL_WOOCOMMERCE_URI.'js/woocommerce.js',array(),false,true);
}


/*==========================================================================
 WooCommerce - Function get Query
==========================================================================*/
function pgl_woocommerce_query($type,$post_per_page=-1,$cat=''){
    global $woocommerce;
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
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
        case 'on_sale':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = wc_get_product_ids_on_sale();
            break;
        case 'recent_review':
            if($number == -1) $_limit = 4;
            else $_limit = $number;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, ". $_limit;
            $results = $wpdb->get_results($query, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                $_pids[] = $re->comment_post_ID;
            }

            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = $_pids;
            break;
    }

    if($cat!=''){
        $args['product_cat']= $cat;
    }
    return new WP_Query($args);
}