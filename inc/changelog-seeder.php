<?php

/**
 * Changelog Seeder - Sample Data
 * 
 * @package Roadmap
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Seed Sample Changelog Data
 * This function creates a sample changelog with v1.0.13 data
 */
function roadmap_seed_sample_changelog()
{
    // Check if we already have changelogs
    $existing = get_posts(array(
        'post_type' => 'changelog',
        'posts_per_page' => 1,
    ));

    if (!empty($existing)) {
        return array(
            'success' => false,
            'message' => 'Changelog already exists. Delete existing changelogs first to re-seed.',
        );
    }

    // Create the changelog post
    $changelog_id = wp_insert_post(array(
        'post_title'   => 'Version 1.0.13 Release',
        'post_type'    => 'changelog',
        'post_status'  => 'publish',
        'post_author'  => get_current_user_id(),
        'post_date'    => '2026-01-10 00:00:00',
    ));

    if (is_wp_error($changelog_id)) {
        return array(
            'success' => false,
            'message' => 'Failed to create changelog: ' . $changelog_id->get_error_message(),
        );
    }

    // Add version number
    update_field('version_number', 'v1.0.13', $changelog_id);

    // Add release date
    update_field('release_date', '2026-01-10', $changelog_id);

    // Add Web Enhancements
    $web_enhancements = array(
        array(
            'feature_title' => 'Pinned Messages',
            'feature_description' => 'High-priority info can now be starred.',
        ),
        array(
            'feature_title' => 'Copy to Clipboard',
            'feature_description' => 'Instant copy button added to message hover.',
        ),
        array(
            'feature_title' => 'Search Overhaul',
            'feature_description' => 'Threads are now fully indexed for search.',
        ),
        array(
            'feature_title' => 'Security',
            'feature_description' => 'New file validation and HEIC support.',
        ),
    );
    update_field('web_enhancements', $web_enhancements, $changelog_id);

    // Add Mobile Features
    $mobile_features = array(
        array(
            'feature_title' => 'Manual Unread',
            'feature_description' => 'Long-press to mark for follow-up.',
        ),
        array(
            'feature_title' => 'Quick Reactions',
            'feature_description' => 'Native double-tap for quick 👍.',
        ),
        array(
            'feature_title' => 'iOS Sound Fix',
            'feature_description' => 'Resolved notification audio issues.',
        ),
    );
    update_field('mobile_features', $mobile_features, $changelog_id);

    // Add Active Bugs
    $active_bugs = array(
        array(
            'bug_title' => 'Socket/Pusher Connection',
            'bug_description' => 'Fixing "zombie connections" during device wake/sleep transitions (Yury\'s Lead).',
        ),
        array(
            'bug_title' => 'Notification Overload',
            'bug_description' => 'Resolving multiple pop-up triggers on desktop reconnect.',
        ),
        array(
            'bug_title' => 'Session Management',
            'bug_description' => 'Implementing Google Token persistence (Eduard\'s request).',
        ),
    );
    update_field('active_bugs', $active_bugs, $changelog_id);

    // Create Roadmap Items
    $roadmap_items_data = array(
        array(
            'title' => 'Adjustable Text Size',
            'description' => 'Nancy\'s request for custom Small/Medium/Large toggles for laptops.',
        ),
        array(
            'title' => 'UI/UX Refactor',
            'description' => 'Standardizing card heights with clamp() and grouping.',
        ),
        array(
            'title' => 'Advanced Code Blocks',
            'description' => 'Proper syntax highlighting for PHP and snippets (Eduard\'s request).',
        ),
        array(
            'title' => 'PM Workflow Reminders',
            'description' => 'Scheduled notification triggers for task management.',
        ),
    );

    foreach ($roadmap_items_data as $index => $item) {
        $roadmap_id = wp_insert_post(array(
            'post_title'   => $item['title'],
            'post_type'    => 'roadmap_item',
            'post_status'  => 'publish',
            'post_author'  => get_current_user_id(),
            'menu_order'   => $index, // For ordering
        ));

        if (!is_wp_error($roadmap_id)) {
            update_field('roadmap_description', $item['description'], $roadmap_id);
        }
    }

    return array(
        'success' => true,
        'message' => 'Sample changelog v1.0.13 and 4 roadmap items created successfully!',
        'changelog_id' => $changelog_id,
    );
}
add_action('after_switch_theme', 'roadmap_seed_sample_changelog');

/**
 * Add admin menu for seeder
 */
function roadmap_add_seeder_menu()
{
    add_submenu_page(
        'edit.php?post_type=changelog',
        'Seed Sample Data',
        'Seed Sample Data',
        'manage_options',
        'roadmap-seed-changelog',
        'roadmap_seeder_page'
    );
}
add_action('admin_menu', 'roadmap_add_seeder_menu');

/**
 * Seeder admin page
 */
function roadmap_seeder_page()
{
?>
    <div class="wrap">
        <h1>Seed Sample Changelog Data</h1>

        <?php
        if (isset($_POST['seed_changelog']) && check_admin_referer('roadmap_seed_changelog')) {
            $result = roadmap_seed_sample_changelog();

            if ($result['success']) {
                echo '<div class="notice notice-success"><p>' . esc_html($result['message']) . '</p></div>';
                echo '<p><a href="' . admin_url('edit.php?post_type=changelog') . '" class="button button-primary">View Changelogs</a></p>';
                echo '<p><a href="' . home_url('/') . '" class="button">View Homepage</a></p>';
            } else {
                echo '<div class="notice notice-error"><p>' . esc_html($result['message']) . '</p></div>';
            }
        }
        ?>

        <div class="card" style="max-width: 600px;">
            <h2>Sample Changelog v1.0.13</h2>
            <p>This will create a sample changelog with the following data:</p>

            <h3>Web Enhancements:</h3>
            <ul>
                <li><strong>Pinned Messages:</strong> High-priority info can now be starred.</li>
                <li><strong>Copy to Clipboard:</strong> Instant copy button added to message hover.</li>
                <li><strong>Search Overhaul:</strong> Threads are now fully indexed for search.</li>
                <li><strong>Security:</strong> New file validation and HEIC support.</li>
            </ul>

            <h3>Mobile Features:</h3>
            <ul>
                <li><strong>Manual Unread:</strong> Long-press to mark for follow-up.</li>
                <li><strong>Quick Reactions:</strong> Native double-tap for quick 👍.</li>
                <li><strong>iOS Sound Fix:</strong> Resolved notification audio issues.</li>
            </ul>

            <h3>Active Development & Bugs:</h3>
            <ul>
                <li><strong>Socket/Pusher Connection:</strong> Fixing "zombie connections" during device wake/sleep transitions (Yury's Lead).</li>
                <li><strong>Notification Overload:</strong> Resolving multiple pop-up triggers on desktop reconnect.</li>
                <li><strong>Session Management:</strong> Implementing Google Token persistence (Eduard's request).</li>
            </ul>

            <h3>Future Roadmap:</h3>
            <ul>
                <li><strong>Adjustable Text Size:</strong> Nancy's request for custom Small/Medium/Large toggles for laptops.</li>
                <li><strong>UI/UX Refactor:</strong> Standardizing card heights with clamp() and grouping.</li>
                <li><strong>Advanced Code Blocks:</strong> Proper syntax highlighting for PHP and snippets (Eduard's request).</li>
                <li><strong>PM Workflow Reminders:</strong> Scheduled notification triggers for task management.</li>
            </ul>

            <form method="post">
                <?php wp_nonce_field('roadmap_seed_changelog'); ?>
                <p>
                    <button type="submit" name="seed_changelog" class="button button-primary button-large">
                        Create Sample Changelog
                    </button>
                </p>
            </form>

            <p class="description">
                <strong>Note:</strong> This will only work if you have Secure Custom Fields (SCF) installed and no existing changelogs.
            </p>
        </div>
    </div>
<?php
}
