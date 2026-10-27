<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function my_theme_setup() {
    // Automatically add site title to <head>
    add_theme_support('title-tag');
    // Enable featured images for posts
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'my_theme_setup');

function my_theme_scripts() {
    // 1. Enqueue main style.css
    wp_enqueue_style('main-style', get_stylesheet_uri());

    // 2. Enqueue main.js in the footer
    wp_enqueue_script(
        'main-script',
        get_template_directory_uri() . '/assets/main.js',
        array(),
        '1.0.0',
        true // true loads the script right before </body> so elements exist
    );
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');

function remove_comment_website_field($fields) {
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields', 'remove_comment_website_field');

function handle_contact_form_submission() {

    // 1. SECURITY CHECK: Verify nonce (CSRF Protection)
    if ( ! isset($_POST['contact_form_nonce']) || ! wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_action') ) {
        wp_die('Security check failed.');
    }

    // 2. BOT HONEYPOT TRAP
    if ( ! empty($_POST['contact_honeypot']) ) {
        wp_die(); // Drop automated bots without sending email
    }

    // 3. GET & SANITIZE INPUTS (XSS Protection)
    $name    = isset($_POST['contact_name'])    ? trim(sanitize_text_field($_POST['contact_name'])) : '';
    $email   = isset($_POST['contact_email'])   ? trim(sanitize_email($_POST['contact_email']))     : '';
    $message = isset($_POST['contact_message']) ? trim(sanitize_textarea_field($_POST['contact_message'])) : '';
    $subject = isset($_POST['contact_subject']) ? trim(sanitize_text_field($_POST['contact_subject'])) : '';

    $errors = array();

    // 4. VALIDATION CHECKS
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

    // 5. STOP & REDIRECT IF ERRORS EXIST
    if ( ! empty($errors) ) {
        set_transient('contact_form_errors', $errors, 60);

        // Safe redirect back to form anchor
        $redirect_url = wp_get_referer() ? wp_get_referer() : home_url('/contact');
        wp_safe_redirect( $redirect_url . '#contact-form-section');
        exit;
    }

    // 6. SEND EMAIL TO ADMIN (Appears in Mailpit)
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

    // 7. REDIRECT WITH SUCCESS MESSAGE
    set_transient('contact_form_success', 'Thank you! Your message has been sent.', 60);
    
    $redirect_url = wp_get_referer() ? wp_get_referer() : home_url('/contact');
    wp_safe_redirect( $redirect_url . '#contact-form-section');
    exit;
}

// Hook for logged-in and logged-out visitors
add_action('admin_post_handle_contact_form', 'handle_contact_form_submission');
add_action('admin_post_nopriv_handle_contact_form', 'handle_contact_form_submission');


// WooCommerce theme support
function cmsdm_add_woocommerce_support() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'cmsdm_add_woocommerce_support');


//=================================//
// Shop page filters
//=================================//
// Add A-Z and Z-A options to the sorting dropdown
add_filter( 'woocommerce_catalog_orderby', function( $options ) {
    unset( $options['popularity'] );
    unset( $options['rating'] );

    $options['title_asc']  = __( 'Name: A to Z', 'woocommerce' );
    $options['title_desc'] = __( 'Name: Z to A', 'woocommerce' );
    return $options;
});

// Handle the orderby query for title sorting
add_filter( 'woocommerce_get_catalog_ordering_args', function( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( (string) wp_unslash( $_GET['orderby'] ) ) : wc_clean( get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'title_asc' === $orderby_value ) {
        $args['orderby'] = 'title';
        $args['order']   = 'ASC';
    } elseif ( 'title_desc' === $orderby_value ) {
        $args['orderby'] = 'title';
        $args['order']   = 'DESC';
    }

    return $args;
});

// Filter for different categories
function cmsdm_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Shop Sidebar', 'cmsdm' ),
        'id'            => 'shop-sidebar',
        'description'   => __( 'Widgets in this area will be shown on shop and product archive pages.', 'cmsdm' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s shop-widget">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'cmsdm_widgets_init' );

// Remove count numbers from product category lists
add_filter( 'woocommerce_product_categories_widget_args', function( $args ) {
    $args['show_count'] = 0;
    return $args;
} );

add_filter( 'wp_list_categories_args', function( $args ) {
    if ( isset( $args['taxonomy'] ) && 'product_cat' === $args['taxonomy'] ) {
        $args['show_count'] = 0;
    }
    return $args;
} );

// Strip out all "(X)" count strings from the rendered category HTML
add_filter( 'wp_list_categories', function( $output, $args ) {
    if ( ! isset( $args['taxonomy'] ) || 'product_cat' === $args['taxonomy'] ) {
        $output = preg_replace( '/\s*\(\d+\)/', '', $output );
    }
    return $output;
}, 99, 2 );

// Fix for ARIA issue in siteimprove addon
add_filter( 'woocommerce_pagination_args', function( $args ) {
    return $args;
});

add_filter( 'paginate_links_output', function( $html ) {
    return preg_replace( '/(<span[^>]*?)\saria-label="[^"]*"([^>]*?>)/i', '$1$2', $html );
}, 20 );

//=================================//
// Test drive page logic
//=================================//
/**
 * Handle Test Ride Booking Submission & Mailpit Routing
 */
function cmsdm_handle_test_ride() {
    // 1. Verify CSRF Nonce
    if ( ! isset($_POST['test_ride_nonce']) || ! wp_verify_nonce( $_POST['test_ride_nonce'], 'test_ride_verify' ) ) {
        wp_die( esc_html__( 'Security check failed. Please refresh and try again.', 'cmsdm' ), 403 );
    }

    // 2. BOT HONEYPOT TRAP
    if ( ! empty($_POST['test_ride_honeypot']) ) {
        wp_die();
    }

    // 3. Validate Required Fields
    $required = array( 'motorcycle_model', 'license_type', 'ride_date', 'ride_time', 'rider_name', 'rider_email', 'rider_phone', 'terms_agree' );
    foreach ( $required as $field ) {
        if ( empty( $_POST[$field] ) ) {
            wp_safe_redirect( add_query_arg( 'booking', 'error', wp_get_referer() ) );
            exit;
        }
    }

    // 4. Sanitize Inputs
    $model      = sanitize_text_field( $_POST['motorcycle_model'] );
    $license    = sanitize_text_field( $_POST['license_type'] );
    $experience = sanitize_text_field( $_POST['experience_level'] ?? 'Not specified' );
    $date       = sanitize_text_field( $_POST['ride_date'] );
    $time       = sanitize_text_field( $_POST['ride_time'] );
    $loaner     = isset( $_POST['loaner_gear'] ) ? 'Yes' : 'No';
    $name       = sanitize_text_field( $_POST['rider_name'] );
    $email      = sanitize_email( $_POST['rider_email'] );
    $phone      = sanitize_text_field( $_POST['rider_phone'] );
    $notes      = sanitize_textarea_field( $_POST['rider_notes'] ?? '' );

    // 5. Send Email Notification to Store Admin
    $admin_email   = get_option( 'admin_email' );
    $admin_subject = sprintf( 'New Test Ride Booking: %s - %s', $name, $model );
    $admin_body    = "You received a new test ride booking request:\n\n"
                   . "Rider: {$name}\n"
                   . "Email: {$email}\n"
                   . "Phone: {$phone}\n\n"
                   . "Motorcycle: {$model}\n"
                   . "License: {$license}\n"
                   . "Experience: {$experience}\n"
                   . "Scheduled Slot: {$date} at {$time}\n"
                   . "Loaner Gear Needed: {$loaner}\n\n"
                   . "Special Notes:\n{$notes}\n";

    $admin_headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        "Reply-To: {$name} <{$email}>"
    );

    wp_mail( $admin_email, $admin_subject, $admin_body, $admin_headers );

    // 6. Send Customer Confirmation Email
    $customer_subject = "Test Ride Request Received - {$model}";
    $customer_body    = "Hi {$name},\n\n"
                      . "Thanks for scheduling a test ride with us!\n\n"
                      . "Booking Details:\n"
                      . "- Motorcycle: {$model}\n"
                      . "- Date & Time: {$date} at {$time}\n"
                      . "- Loaner Gear: {$loaner}\n\n"
                      . "Please bring your valid driver's license ({$license}) when arriving at the showroom.\n\n"
                      . "Best regards,\nMotoShop Team";

    wp_mail( $email, $customer_subject, $customer_body, array( 'Content-Type: text/plain; charset=UTF-8' ) );

    // 7. Redirect back with success message
    wp_safe_redirect( add_query_arg( 'booking', 'success', wp_get_referer() ) );
    exit;
}
add_action( 'admin_post_nopriv_submit_test_ride', 'cmsdm_handle_test_ride' );
add_action( 'admin_post_submit_test_ride', 'cmsdm_handle_test_ride' );


//=================================//
// Stripe Styling Filter
//=================================//
add_filter( 'wc_stripe_upe_params', function( $stripe_params ) {
    $stripe_style = (object) [
        'labels' => 'above',
        'rules'  => (object) [
            '.Input' => (object) [
                'padding' => '12px 14px',
            ],
            '.Label' => (object) [
                'fontWeight'   => '600',
                'color'        => '#475569',
                'marginBottom' => '6px',
            ],
        ],
    ];

    $stripe_params['blocksAppearance'] = $stripe_style;
    $stripe_params['appearance'] = $stripe_style;

    return $stripe_params;
} );

/**
 * Global dynamic meta description generator for SEO across all templates
 */
function motoshop_dynamic_meta_description() {
    $description = '';

    if ( is_front_page() || is_home() ) {
        // Front page or Blog main page
        $description = get_bloginfo( 'description' ) ?: 'Explore premium motorcycles, high-performance protective gear, and workshop services at MotoShop.';
    } elseif ( function_exists( 'is_shop' ) && is_shop() ) {
        // WooCommerce main shop page
        $description = 'Browse our selection of modern motorcycles, helmets, jackets, riding boots, and replacement parts at MotoShop.';
    } elseif ( function_exists( 'is_product' ) && is_product() ) {
        // Single WooCommerce product page
        global $post;
        $product = function_exists( 'wc_get_product' ) ? wc_get_product( $post->ID ) : null;
        if ( $product && $product->get_short_description() ) {
            $description = $product->get_short_description();
        } else {
            $description = get_the_excerpt( $post->ID ) ?: wp_trim_words( get_the_content(), 25 );
        }
    } elseif ( function_exists( 'is_product_category' ) && is_product_category() ) {
        // Product category pages
        $term_desc = term_description();
        $description = ! empty( $term_desc ) ? $term_desc : 'Shop ' . single_term_title( '', false ) . ' designed for rider safety and durability at MotoShop.';
    } elseif ( function_exists( 'is_cart' ) && is_cart() ) {
        // Cart page
        $description = 'View and manage items in your shopping cart before proceeding to checkout at MotoShop.';
    } elseif ( function_exists( 'is_checkout' ) && is_checkout() ) {
        // Checkout page
        $description = 'Complete your motorcycle and gear order securely with multiple payment options at MotoShop.';
    } elseif ( is_singular() ) {
        // Regular single posts, pages (Contact, Sustainability, Test Ride, etc.)
        global $post;
        if ( ! empty( $post->post_excerpt ) ) {
            $description = $post->post_excerpt;
        } else {
            $description = wp_trim_words( $post->post_content, 25 );
        }
    } elseif ( is_archive() ) {
        // Blog archives
        $description = get_the_archive_description() ?: 'Browse articles and updates from the MotoShop motorcycle journal.';
    }

    // Site-wide fallback if content was completely blank
    if ( empty( trim( $description ) ) ) {
        $description = get_bloginfo( 'description' ) ?: 'MotoShop - Precision-tuned motorcycles and tested rider gear.';
    }

    // Strip HTML tags, remove redundant whitespace, and cap at 160 characters
    $clean_desc = wp_strip_all_tags( $description );
    $clean_desc = mb_substr( trim( preg_replace( '/\s+/', ' ', $clean_desc ) ), 0, 160 );

    echo '<meta name="description" content="' . esc_attr( $clean_desc ) . '">' . "\n";
}
add_action( 'wp_head', 'motoshop_dynamic_meta_description', 1 );

// Clear the cached Stripe appearance transients so changes load immediately
delete_transient( 'wc_stripe_appearance' );
delete_transient( 'wc_stripe_blocks_appearance' );
