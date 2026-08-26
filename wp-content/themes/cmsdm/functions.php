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