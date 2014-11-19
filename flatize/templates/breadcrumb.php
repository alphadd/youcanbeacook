<?php

global $post,$wp_query;

$prepend      = '';
$permalinks   = get_option( 'woocommerce_permalinks' );

?>
        
<div class="breadcrumb">
	<div class="inner">
		<h2 class="page-title">
			<span>
				<?php 
					if(is_404()){
						echo __( 'Error 404', 'flatize' );
					}else if(is_single()){
						echo get_the_title();
					}else if( is_category() ){
						$cat_obj = $wp_query->get_queried_object();
						$this_category = get_category( $cat_obj->term_id );
						echo single_cat_title( '', false );
					}else if( is_tax( 'product_cat' ) ){
						$current_term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
						echo esc_html( $current_term->name );						
					}else if( is_tax('product_tag') ){
						$queried_object = $wp_query->get_queried_object();
						echo __( 'Products tagged &ldquo;', 'woocommerce' ) .$queried_object->name.'&rdquo;';
					}else if(is_post_type_archive('product')){
						$shop_page_id = wc_get_page_id( 'shop' );
						if($shop_page_id){
							$shop_page    = get_post( $shop_page_id );
							echo $shop_page->post_title;
						}
					}else if (is_search()){
						echo __( 'Search results for &ldquo;', 'woocommerce' ) . get_search_query() . '&rdquo;';
					}else if (is_day()){
						echo get_the_time( 'd' );
					}else if(is_month()){
						echo get_the_time( 'F' );
					}else if(is_year()){
						echo get_the_time( 'Y' );
					}else if( is_page() ){
						echo get_the_title();
					}

				?>
			</span>
		</h2>
	</div>
</div>