<?php
/**
 * Plugin Name: Elementor alaa test
 * Description: Simple hello world widgets for Elementor.
 * Version:     1.0.0
 * Author:      Alaa Ezz-eldin
 * Author URI:  https://developers.elementor.com/
 * Text Domain: Alaa Ezz-eldin
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.21.0
 * Elementor Pro tested up to: 3.21.0
 */

function register_hello_world_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/hello-world-widget-1.php' );
	require_once( __DIR__ . '/widgets/hello-world-widget-2.php' );

	$widgets_manager->register( new \Elementor_Hello_World_Widget_1() );
	$widgets_manager->register( new \Elementor_Hello_World_Widget_2() );

}
add_action( 'elementor/widgets/register', 'register_hello_world_widget' );