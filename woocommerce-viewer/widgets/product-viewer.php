<?php

class Custom_WooCommerce_Widget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'alaa_product_viewer';
    }

    public function get_title()
    {
        return __('Custom WooCommerce Widget', 'elementor-custom-widget');
    }

    public function get_icon() {
        // Get the URL of the plugin's assets directory
        $plugin_assets_url = plugin_dir_url( __FILE__ ) . 'assets/';
    
        // Specify the path to the icon image relative to the assets directory
        $icon_path = $plugin_assets_url . 'img/viewer.png';
    
        // Return the icon HTML with the specified image path
        return sprintf(
            '<img src="%s" />',
            esc_url( $icon_path )
        );
    }

    public function get_categories()
    {
        return ['basic'];
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $rows = isset($settings['rows']) ? $settings['rows'] : 1;
        $columns = isset($settings['columns']) ? $settings['columns'] : 1;

        // Retrieve WooCommerce products.
        $products = wc_get_products([
            'limit' => $rows * $columns,
        ]);

        if ($products) {
            echo '<div class="custom-woocommerce-widget">';
            echo '<div class="custom-product-grid">';
            $count = 0;
            foreach ($products as $product) {
                if ($count % $columns == 0) {
                    echo '<div class="custom-product-row">';
                }
                echo '<div class="custom-product-column">';
                echo '<h4>' . $product->get_name() . '</h4>';       //show title of product
                echo '<div class="custom-product-thumbnail">' . $product->get_image('thumbnail') . '</div>';  //show image of product
                echo '<p>' . $product->get_price_html() . '</p>';    //show price of product
                echo '</div>';
                if (($count + 1) % $columns == 0 || ($count + 1) == count($products)) {
                    echo '</div>'; // Close row div.
                }
                $count++;
            }
            echo '</div>'; // Close product-grid div.
            echo '</div>'; // Close custom-woocommerce-widget div.
        }
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'elementor-custom-widget'),
            ]
        );

        $this->add_control(
            'rows',
            [
                'label' => __('Rows', 'elementor-custom-widget'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'elementor-custom-widget'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
            ]
        );

        $this->end_controls_section();
    }
}
