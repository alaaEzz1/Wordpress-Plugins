<?php

/**
 * Plugin Name: Custom Greating Message
 * Description: A simple plugin to display a greeting message based on the time of day.
 * Version: 1.0.0
 * Author: Alaa Ezz-eldin
 * Author URI: https://alaaezz.com
 */

 function get_greating_message(){
    date_default_timezone_set('Asia/Dubai');
    $current_hour = date("H");

    if($current_hour >= 5 && $current_hour <=12){

        $greeting = "good morning";
    }elseif ($current_hour >= 12 && $current_hour < 18) {
        $greeting = "Good Afternoon!";
    } elseif ($current_hour >= 18 && $current_hour < 21) {
        $greeting = "Good Evening!";
    } else {
        $greeting = "Good Night!";
    }

    return $greeting;
 }

 function display_greating_message(){
    $greeting = get_greating_message();

    return "<h2 class='custom_greating'><strong>$greeting</strong></h2>";
 }

 add_shortcode( "custom_greeting", "display_greating_message" );

 function add_greeting_to_footer() {
    echo '<div class="footer-greeting">';
    echo display_greating_message();
    echo '</div>';
    echo date("H");
}

add_action( "wp_footer", 'add_greeting_to_footer' );

function enqueue_styles(){
    echo "
    <style>
        .custom-greeting {
            font-size: 24px;
            font-weight: bold;
            color: #4CAF50;
            text-align: center;
        }
        .footer-greeting {
            margin-top: 20px;
            padding: 10px;
        }
    </style>
    ";
}

add_action("wp_head","enqueue_styles");