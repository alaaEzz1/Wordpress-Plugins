<?php
/*
Plugin Name: Alaa Ezz-Eldin Filter
Description: Adds advanced filtering options to WooCommerce product listings and integrates with Elementor as a widget.
Version: 1.0
Author: Alaa Ahmed Ezz-eldin
*/

// Enqueue scripts and styles
//includes/class-alaa-ezz-eldin-widget.php
function alaa_ezz_eldin_filter_enqueue_scripts() {
    // Enqueue jQuery UI for slider
    wp_enqueue_script('jquery-ui-slider');
    // Enqueue custom script for filtering
    wp_enqueue_script('alaa-ezz-eldin-custom-script', plugin_dir_url(__FILE__) . 'assets/js/custom-script.js', array('jquery'), '1.0', true);
    // Enqueue custom styles
    wp_enqueue_style('alaa-ezz-eldin-custom-style', plugin_dir_url(__FILE__) . 'assets/css/custom-style.css');
}
add_action('wp_enqueue_scripts', 'alaa_ezz_eldin_filter_enqueue_scripts');

// Include Elementor widget registration
function register_alaa_ezz_eldin_filter_widget( $widgets_manager ) {

	require_once( __DIR__ . '/includes/class-alaa-ezz-eldin-widget.php' );

	$widgets_manager->register( new \Alaa_Ezz_Eldin_Widget() );

}
add_action( 'elementor/widgets/register', 'register_alaa_ezz_eldin_filter_widget' );
