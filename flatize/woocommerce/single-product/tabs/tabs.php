<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

$_count=0;

if ( ! empty( $tabs ) ) : ?>

	<div class="panel-group" id="accordion">
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#woocommerce-tabs-<?php echo $key; ?>">
							<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?>
						</a>
					</h4>
				</div>
				<div id="woocommerce-tabs-<?php echo $key; ?>" class="panel-collapse collapse<?php echo ($_count==0)?' in':''; ?>">
					<div class="panel-body">
						<?php call_user_func( $tab['callback'], $key, $tab ) ?>
					</div>
				</div>
			</div>
			<?php $_count++; ?>
		<?php endforeach; ?>
	</div>

<?php endif; ?>



