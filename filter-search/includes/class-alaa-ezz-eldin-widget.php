<?php

class Alaa_Ezz_Eldin_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'alaa-ezz-eldin-filter'; // Name of your Elementor widget
    }

    public function get_title() {
        return __( 'Alaa Ezz-Eldin Filter', 'alaa-ezz-eldin-filter' ); // Title of your Elementor widget
    }

    public function get_icon() {
        // Get the URL of the plugin's assets directory
        $plugin_assets_url = plugin_dir_url( __FILE__ ) . 'assets/';
    
        // Specify the path to the icon image relative to the assets directory
        $icon_path = $plugin_assets_url . 'img/down-arrow.png';
    
        // Return the icon HTML with the specified image path
        return sprintf(
            '<img src="%s" />',
            esc_url( $icon_path )
        );
    }

    public function get_categories() {
        return [ 'general' ]; // Category for your Elementor widget
    }

    protected function render() {
        // Handle form submission and filter products
        if ( isset( $_GET['apply_filters'] ) ) {
            // Retrieve submitted form data
            $title = isset( $_GET['title'] ) ? sanitize_text_field( $_GET['title'] ) : '';
            $category = isset( $_GET['category'] ) ? intval( $_GET['category'] ) : '';
            $model = isset( $_GET['model'] ) ? sanitize_text_field( $_GET['model'] ) : '';
            $color = isset( $_GET['color'] ) ? sanitize_text_field( $_GET['color'] ) : '';
            $year = isset( $_GET['year'] ) ? sanitize_text_field( $_GET['year'] ) : '';
            $min_price = isset( $_GET['min_price'] ) ? floatval( $_GET['min_price'] ) : 0;
            $max_price = isset( $_GET['max_price'] ) ? floatval( $_GET['max_price'] ) : 100000;

            // Modify product query based on form data
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1, // Retrieve all products
                'meta_query'     => array(
                    'relation' => 'AND', // Apply AND condition for all meta queries
                    array(
                        'key'     => 'product_model',
                        'value'   => $model,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => 'product_color',
                        'value'   => $color,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => 'product_year',
                        'value'   => $year,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => '_price',
                        'value'   => array( $min_price, $max_price ),
                        'type'    => 'numeric',
                        'compare' => 'BETWEEN',
                    ),
                ),
            );

            // Add additional query parameters if necessary
            if ( ! empty( $title ) ) {
                $args['s'] = $title; // Search by title
            }
            if ( ! empty( $category ) ) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'term_id',
                        'terms'    => $category,
                    ),
                );
            }

            // Query products
            $products_query = new WP_Query( $args );

            // Output filtered products
            if ( $products_query->have_posts() ) {
                while ( $products_query->have_posts() ) {
                    $products_query->the_post();
                    // Display product content here
                }
                wp_reset_postdata();
            } else {
                echo 'No products found.';
            }

            return;
        }
        
        // Output the filtering form HTML here
        ?>
        <div class="alaa-ezz-eldin-filter-form">
            <form id="alaa-ezz-eldin-filter" method="GET">
                <input type="text" name="title" placeholder="Search by title">
                <select name="category">
                    <option value="">Select category</option>
                    <?php
                    $categories = get_terms(array('taxonomy' => 'product_cat', 'hide_empty' => true));
                    foreach ($categories as $category) {
                        echo '<option value="' . $category->term_id . '">' . $category->name . '</option>';
                    }
                    ?>
                </select>
                <select name="model">
                    <option value="">Select model</option>
                    <?php
                    // Fetch and display models dynamically
                    $models = array_unique(wc_get_products(array('return' => 'ids', 'meta_key' => 'product_model')));
                    foreach ($models as $model_id) {
                        $model = get_post_meta($model_id, 'product_model', true);
                        echo '<option value="' . $model . '">' . $model . '</option>';
                    }
                    ?>
                </select>
                <select name="color">
                    <option value="">Select color</option>
                    <?php
                    // Fetch and display colors dynamically
                    $colors = array_unique(wc_get_products(array('return' => 'ids', 'meta_key' => 'product_color')));
                    foreach ($colors as $color_id) {
                        $color = get_post_meta($color_id, 'product_color', true);
                        echo '<option value="' . $color . '">' . $color . '</option>';
                    }
                    ?>
                </select>
                <select name="year">
                    <option value="">Select year</option>
                    <?php
                    // Fetch and display years dynamically
                    $years = array_unique(wc_get_products(array('return' => 'ids', 'meta_key' => 'product_year')));
                    foreach ($years as $year_id) {
                        $year = get_post_meta($year_id, 'product_year', true);
                        echo '<option value="' . $year . '">' . $year . '</option>';
                    }
                    ?>
                </select>
                <input type="hidden" name="min_price" value="50">
                <input type="hidden" name="max_price" value="100000">
                <button type="submit" name="apply_filters">Apply Filters</button>
            </form>
        </div>
        <?php
    }
}
