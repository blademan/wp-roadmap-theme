<?php

/**
 * Admin Cleanup & Optimization
 * 
 * Removes unused menu items, dashboard widgets, and header bloat.
 * 
 * @package Roadmap
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Remove unused Admin Menu items
 */
function roadmap_remove_admin_menus()
{
    // Remove "Posts" (since we use CPTs)
    remove_menu_page('edit.php');

    // Remove "Comments"
    remove_menu_page('edit-comments.php');

    // Remove "Media"
    remove_menu_page('upload.php');
}
add_action('admin_menu', 'roadmap_remove_admin_menus');

/**
 * Clean up Admin Bar
 */
function roadmap_cleanup_admin_bar()
{
    global $wp_admin_bar;

    // Remove 'Comments' icon
    $wp_admin_bar->remove_node('comments');

    // Remove 'New -> Post'
    $wp_admin_bar->remove_node('new-post');

    // Remove 'New -> Media' 
    $wp_admin_bar->remove_node('new-media');


    // Remove 'New -> User' (optional)
    // $wp_admin_bar->remove_node('new-user');

    // Remove WordPress Logo (optional, for whitelabeling)
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('wp_before_admin_bar_render', 'roadmap_cleanup_admin_bar');

/**
 * Cleanup WP Head (Performance & Security)
 */
function roadmap_cleanup_head()
{
    // Remove WordPress Version
    remove_action('wp_head', 'wp_generator');

    // Remove RSD link (EditURI) for XML-RPC clients
    remove_action('wp_head', 'rsd_link');

    // Remove Windows Live Writer Manifest
    remove_action('wp_head', 'wlwmanifest_link');

    // Remove Shortlink
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('after_setup_theme', 'roadmap_cleanup_head');

/**
 * Disable WordPress Emojis (Performance)
 * Removes the extra JS/CSS requests if not using WP emojis.
 */
function roadmap_disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'roadmap_disable_emojis');

/**
 * Disable Comments Support Everywhere
 */
function roadmap_disable_comments_post_types_support()
{
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'roadmap_disable_comments_post_types_support');

// Close comments on frontend
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

/**
 * Clean Dashboard Widgets
 */
function roadmap_remove_dashboard_widgets()
{
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');   // Quick Draft
    remove_meta_box('dashboard_primary', 'dashboard', 'side');       // WordPress News

    // We can keep 'Activity' or 'Right Now' if useful, but removing mostly everything for clean look
    // remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   // At a Glance
    // remove_meta_box('dashboard_activity', 'dashboard', 'normal');    // Activity
}
add_action('wp_dashboard_setup', 'roadmap_remove_dashboard_widgets');

/**
 * Globally Disable Gutenberg Editor
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/**
 * Remove Gutenberg Block Library CSS and other bloat
 * This ensures no block styles are loaded on the frontend.
 */
function roadmap_remove_block_library_css()
{
    // Remove Gutenberg Block Library CSS
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');

    // Remove WooCommerce Block Styles (if exists)
    wp_dequeue_style('wc-blocks-style');

    // Remove Global Styles (theme.json stuff)
    wp_dequeue_style('global-styles');
}
add_action('wp_enqueue_scripts', 'roadmap_remove_block_library_css', 100);
