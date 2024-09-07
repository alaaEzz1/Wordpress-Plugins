<?php

/**
 * Plugin Name:     Contact Plugin
 * Description:     Handle The basics of plugin Commands
 * Version:         1.0.0
 * Author:          Alaa Ezz-eldin
 * Author URI:      https://alaaezz.com
 */

 if ( ! defined("ABSPATH") ) {
    die("Please Access Plugin From Website Domain Not From File Manager");
 }

 // Create the form shortcode
function simple_contact_form_shortcode() {
    // Check if form was submitted
    if ( isset( $_POST['scf_submit'] ) ) {
        simple_contact_form_process();
    }

    // Display the form
    ob_start();
    ?>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" name="scf_name" required />

        <label for="email">Email:</label>
        <input type="email" name="scf_email" required />

        <label for="phone">Phone:</label>
        <input type="text" name="scf_phone" required />

        <label for="message">Message:</label>
        <textarea name="scf_message" required></textarea>

        <input type="submit" name="scf_submit" value="Send Message" />
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode( 'simple_contact_form', 'simple_contact_form_shortcode' );

// Process form submission
function simple_contact_form_process() {
    // Sanitize the form data
    $name    = sanitize_text_field( $_POST['scf_name'] );
    $email   = sanitize_email( $_POST['scf_email'] );
    $phone   = sanitize_text_field( $_POST['scf_phone'] );
    $message = sanitize_textarea_field( $_POST['scf_message'] );

    // Prepare email details
    $admin_email = get_option( 'admin_email' );
    $subject = 'New Contact Form Submission';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $body = "
        <strong>Name:</strong> $name<br>
        <strong>Email:</strong> $email<br>
        <strong>Phone:</strong> $phone<br>
        <strong>Message:</strong><br>$message
    ";

    // Send the email
    wp_mail( $admin_email, $subject, $body, $headers );

    // Display a success message
    echo '<p>Thank you! Your message has been sent.</p>';
}