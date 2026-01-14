<?php

/**
 * Roadmap Theme Functions
 * 
 * @package Roadmap
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load ACF Field Groups
 */
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * Load Changelog Seeder
 */
require_once get_template_directory() . '/inc/changelog-seeder.php';

/**
 * Load Submission Handler
 */
require_once get_template_directory() . '/inc/submission-handler.php';

/**
 * Load Settings Page
 */
require_once get_template_directory() . '/inc/settings-page.php';

/**
 * Load SMTP Configuration
 */
require_once get_template_directory() . '/inc/smtp-config.php';

/**
 * Admin Cleanup & Optimization
 */
require_once get_template_directory() . '/inc/admin-cleanup.php';





/**
 * Remove Editor Support from Changelog and Roadmap CPTs
 */
function roadmap_remove_changelog_editor_support()
{
    remove_post_type_support('changelog', 'editor');
    remove_post_type_support('roadmap_item', 'editor');
}
add_action('init', 'roadmap_remove_changelog_editor_support');


/**
 * Theme Setup
 */
function roadmap_theme_setup()
{
    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails
    add_theme_support('post-thumbnails');

    // Enable support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'roadmap'),
        'footer'  => __('Footer Menu', 'roadmap'),
    ));

    // Switch default core markup to output valid HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));

    // Add theme support for selective refresh for widgets
    add_theme_support('customize-selective-refresh-widgets');
}
add_action('after_setup_theme', 'roadmap_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function roadmap_scripts()
{
    // Enqueue Google Fonts
    wp_enqueue_style(
        'roadmap-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap',
        array(),
        null
    );

    // Enqueue Tailwind CSS CDN (as script, not style)
    wp_enqueue_script(
        'roadmap-tailwind',
        'https://cdn.tailwindcss.com',
        array(),
        '3.4.0',
        false // Load in head
    );

    // Add Tailwind configuration for custom colors
    wp_add_inline_script(
        'roadmap-tailwind',
        'tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "ddc-blue": "#0066cc",
                    }
                }
            }
        }',
        'after'
    );

    // Enqueue theme stylesheet
    wp_enqueue_style(
        'roadmap-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // Enqueue custom JavaScript
    wp_enqueue_script(
        'roadmap-scripts',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'roadmap_scripts');

/**
 * Register Widget Areas
 */
function roadmap_widgets_init()
{
    register_sidebar(array(
        'name'          => __('Sidebar', 'roadmap'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'roadmap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    register_sidebar(array(
        'name'          => __('Footer', 'roadmap'),
        'id'            => 'footer-1',
        'description'   => __('Add widgets here to appear in your footer.', 'roadmap'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'roadmap_widgets_init');

/**
 * Create Initial Pages on Theme Activation
 */
function roadmap_create_initial_pages()
{
    // Check if pages already exist
    if (get_option('roadmap_pages_created')) {
        return;
    }

    // Create Home page
    $home_page = array(
        'post_title'    => 'Home',
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => 1,
    );
    $home_id = wp_insert_post($home_page);

    // Set as front page
    update_option('page_on_front', $home_id);
    update_option('show_on_front', 'page');

    // Create Thank You page
    $thank_you_page = array(
        'post_title'    => 'Thank You',
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => 1,
    );
    $thank_you_id = wp_insert_post($thank_you_page);

    // Set page template
    update_post_meta($thank_you_id, '_wp_page_template', 'page-thank-you.php');

    // Mark as created
    update_option('roadmap_pages_created', true);
}
add_action('after_switch_theme', 'roadmap_create_initial_pages');

/**
 * Custom Post Types
 */
function roadmap_register_post_types()
{
    // Register Changelog CPT
    register_post_type('changelog', array(
        'labels' => array(
            'name'               => __('Changelogs', 'roadmap'),
            'singular_name'      => __('Changelog', 'roadmap'),
            'add_new'            => __('Add New', 'roadmap'),
            'add_new_item'       => __('Add New Changelog', 'roadmap'),
            'edit_item'          => __('Edit Changelog', 'roadmap'),
            'new_item'           => __('New Changelog', 'roadmap'),
            'view_item'          => __('View Changelog', 'roadmap'),
            'search_items'       => __('Search Changelogs', 'roadmap'),
            'not_found'          => __('No changelogs found', 'roadmap'),
            'not_found_in_trash' => __('No changelogs found in Trash', 'roadmap'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'supports'     => array('title', 'thumbnail'),
        'menu_icon'    => 'dashicons-list-view',
        'rewrite'      => array('slug' => 'changelog'),
    ));

    // Register Roadmap Items CPT
    register_post_type('roadmap_item', array(
        'labels' => array(
            'name'               => __('Roadmap Items', 'roadmap'),
            'singular_name'      => __('Roadmap Item', 'roadmap'),
            'add_new'            => __('Add New', 'roadmap'),
            'add_new_item'       => __('Add New Roadmap Item', 'roadmap'),
            'edit_item'          => __('Edit Roadmap Item', 'roadmap'),
            'new_item'           => __('New Roadmap Item', 'roadmap'),
            'view_item'          => __('View Roadmap Item', 'roadmap'),
            'search_items'       => __('Search Roadmap Items', 'roadmap'),
            'not_found'          => __('No roadmap items found', 'roadmap'),
            'not_found_in_trash' => __('No roadmap items found in Trash', 'roadmap'),
        ),
        'public'       => true,
        'has_archive'  => true,
        'show_in_rest' => true,
        'supports'     => array('title', 'thumbnail'),
        'menu_icon'    => 'dashicons-clipboard',
        'rewrite'      => array('slug' => 'roadmap'),
    ));

    // Register Submissions CPT (for bug reports and feature requests)
    register_post_type('submission', array(
        'labels' => array(
            'name'               => __('Submissions', 'roadmap'),
            'singular_name'      => __('Submission', 'roadmap'),
            'add_new'            => __('Add New', 'roadmap'),
            'add_new_item'       => __('Add New Submission', 'roadmap'),
            'edit_item'          => __('Edit Submission', 'roadmap'),
            'new_item'           => __('New Submission', 'roadmap'),
            'view_item'          => __('View Submission', 'roadmap'),
            'search_items'       => __('Search Submissions', 'roadmap'),
            'not_found'          => __('No submissions found', 'roadmap'),
            'not_found_in_trash' => __('No submissions found in Trash', 'roadmap'),
        ),
        'public'              => false,
        'publicly_queryable'  => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'has_archive'         => false,
        'show_in_rest'        => false,
        'supports'            => array('title'),
        'menu_icon'           => 'dashicons-feedback',
        'capability_type'     => 'post',
        'capabilities'        => array(
            'create_posts' => 'do_not_allow', // Removes "Add New" from admin
        ),
        'map_meta_cap'        => true,
    ));
}
add_action('init', 'roadmap_register_post_types');

/**
 * Add Admin Dashboard Widget
 */
function roadmap_dashboard_widget()
{
    wp_add_dashboard_widget(
        'roadmap_status_widget',
        'Roadmap Theme Status',
        'roadmap_dashboard_widget_content'
    );
}
add_action('wp_dashboard_setup', 'roadmap_dashboard_widget');

function roadmap_dashboard_widget_content()
{
?>
    <div class="roadmap-dashboard-widget">
        <h3>🚀 Theme Status</h3>
        <p><strong>Version:</strong> <?php echo wp_get_theme()->get('Version'); ?></p>
        <p><strong>Changelogs:</strong> <?php echo wp_count_posts('changelog')->publish; ?></p>
        <p><strong>Roadmap Items:</strong> <?php echo wp_count_posts('roadmap_item')->publish; ?></p>
        <hr>
        <p><a href="<?php echo admin_url('edit.php?post_type=changelog'); ?>" class="button button-primary">Manage Changelogs</a></p>
        <p><a href="<?php echo admin_url('edit.php?post_type=roadmap_item'); ?>" class="button button-primary">Manage Roadmap</a></p>
    </div>
<?php
}

/**
 * Redirect 404s to Homepage
 */
function roadmap_redirect_404()
{
    if (is_404()) {
        wp_safe_redirect(home_url());
        exit;
    }
}
add_action('template_redirect', 'roadmap_redirect_404');
