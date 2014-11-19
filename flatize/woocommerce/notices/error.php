<?php
/**
 * Show error messages
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! $messages ) return;
?>
<div class="alert alert-danger clearfix wow fadeInDown" data-wow-duration="400ms">
	<?php foreach ( $messages as $message ) : ?>
		<div class="woocommerce-notice"><?php echo wp_kses_post( $message ); ?></div>
	<?php endforeach; ?>
</div>