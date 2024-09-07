<?php

/**
 * Plugin Name: Alaa Ezz-eldin woocommerce viewer
 * Description: Simple viewer for woocommerce produts.
 * Version:     1.0.0
 * Author:      Alaa Ezz-eldin
 * Author URI:  https://alaa-ezzeldin.great-site.net/
 * Text Domain: Alaa Ezz-eldin
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.21.0
 * Elementor Pro tested up to: 3.21.0
 */

 function alaa_ezz_eldin_woocommerce_viewer( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/product-viewer.php' );

	$widgets_manager->register( new \Custom_WooCommerce_Widget() );

}
add_action( 'elementor/widgets/register', 'alaa_ezz_eldin_woocommerce_viewer' );
