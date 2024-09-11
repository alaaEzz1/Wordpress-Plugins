<?php

/*
Plugin Name: Custom Social Widget
Plugin URI: http://alaaezz.com
Description: A simple plugin to add a custom widget for displaying social media links or custom text.
Version: 1.0
Author: Alaa Ezz-eldin
Author URI: http://alaaezz.com
License: GPL2
*/

// Register the widget
function csw_register_widget() {
    register_widget('Custom_Social_Widget');
}
add_action('widgets_init', 'csw_register_widget');

// Define the Custom Widget Class
class Custom_Social_Widget extends WP_Widget {
    
    // Constructor
    public function __construct() {
        parent::__construct(
            'custom_social_widget',  // Base ID
            'Custom Social Widget',  // Name
            array('description' => 'A widget to display social media links or custom text')
        );
    }

    // Frontend display of widget
    public function widget($args, $instance) {
        echo $args['before_widget'];

        // Display widget title
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        // Display social media links or custom text
        echo '<div class="custom-social-widget">';
        echo !empty($instance['content']) ? $instance['content'] : 'Add your custom text or social media links here.';
        echo '</div>';

        echo $args['after_widget'];
    }

    // Widget backend (admin form)
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Follow Us';
        $content = !empty($instance['content']) ? $instance['content'] : 'Enter your content here.';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('content')); ?>">Content:</label>
            <textarea class="widefat" id="<?php echo esc_attr($this->get_field_id('content')); ?>" name="<?php echo esc_attr($this->get_field_name('content')); ?>" rows="5"><?php echo esc_attr($content); ?></textarea>
        </p>
        <?php
    }

    // Sanitize widget form values as they are saved
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['content'] = (!empty($new_instance['content'])) ? sanitize_textarea_field($new_instance['content']) : '';

        return $instance;
    }
}

// Enqueue custom styles for the widget (optional)
function csw_enqueue_styles() {
    echo "
    <style>
        .custom-social-widget {
            padding: 10px;
            background-color: #2e2e2e;
            border: 1px solid #ddd;
            text-align: center;
        }
        .custom-social-widget a {
            margin: 0 5px;
            text-decoration: none;
            color: #0073aa;
        }
    </style>
    ";
}
add_action('wp_head', 'csw_enqueue_styles');

