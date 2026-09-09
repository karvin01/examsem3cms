<?php
function my_theme_setup() {
    // Automatically add site title to <head>
    add_theme_support('title-tag');
    // Enable featured images for posts
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

function my_theme_scripts() {
    // Enqueue your main style.css
    wp_enqueue_style('main-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

function remove_comment_website_field($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_comment_website_field');

function handle_contact_form_submission() {

    // 1. SECURITY CHECK: Verify nonce
    if ( ! isset($_POST['contact_form_nonce']) || ! wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_action') ) {
        wp_die('Security check failed.');
    }

    // 2. GET & SANITIZE INPUTS
    $name    = isset($_POST['contact_name'])    ? trim(sanitize_text_field($_POST['contact_name'])) : '';
    $email   = isset($_POST['contact_email'])   ? trim(sanitize_email($_POST['contact_email']))     : '';
    $message = isset($_POST['contact_message']) ? trim(sanitize_textarea_field($_POST['contact_message'])) : '';
    $subject = isset($_POST['contact_subject']) ? trim(sanitize_text_field($_POST['contact_subject'])) : '';

    $errors = array();

    // 3. VALIDATION CHECKS
    if ( empty($name) ) {
        $errors[] = 'Full name is required.';
    } elseif ( strlen($name) < 4 ) {
        $errors[] = 'Name must be at least 4 characters long.';
    }

    if ( empty($email) || ! is_email($email) ) {
        $errors[] = 'A valid email address is required.';
    }

    if ( empty($subject) ) {
        $errors[] = 'Subject is required.';
    } elseif ( strlen($subject) < 3 ) {
        $errors[] = 'Subject must be at least 3 characters long.';
    }

    if ( empty($message) ) {
        $errors[] = 'Message is required.';
    } elseif ( strlen($message) < 10 ) {
        $errors[] = 'Message must be at least 10 characters long.';
    }

    // 4. STOP & REDIRECT IF ERRORS EXIST
    if ( ! empty($errors) ) {
        set_transient('contact_form_errors', $errors, 60);

        // anchor so it doesnt scroll up
        $redirect_url = wp_get_referer() ? wp_get_referer() : home_url('/contact');
        wp_redirect( $redirect_url . '#contact-form-section');
        exit;
    }

    // 5. SEND EMAIL TO ADMIN (Appears in Mailpit)
    $to      = get_option('admin_email');
    $mail_subj = 'Contact Form: ' . $subject;
    $body    = "You received a new message from the contact form:\n\n";
    $body   .= "Name: " . $name . "\n";
    $body   .= "Email: " . $email . "\n\n";
    $body   .= "Subject: " . $subject . "\n\n";
    $body   .= "Message:\n" . $message . "\n";

    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    wp_mail($to, $mail_subj, $body, $headers);

    // 6. REDIRECT WITH SUCCESS MESSAGE
    set_transient('contact_form_success', 'Thank you! Your message has been sent.', 60);
    
    // anchor so it doesnt scroll up
    $redirect_url = wp_get_referer() ? wp_get_referer() : home_url('/contact');
    wp_redirect( $redirect_url . '#contact-form-section');
    exit;
}

    // Hook for logged-in and logged-out visitors
    add_action('admin_post_handle_contact_form', 'handle_contact_form_submission');
    add_action('admin_post_nopriv_handle_contact_form', 'handle_contact_form_submission');