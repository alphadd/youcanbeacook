<?php
/**
 * Show messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>

<?php foreach ( $messages as $message ) : ?>
	<div class="alert alert-success clearfix wow fadeInDown" data-wow-duration="400ms">
		<div class="woocommerce-notice"><?php echo wp_kses_post( $message ); ?></div>
	</div>
<?php endforeach; ?>
