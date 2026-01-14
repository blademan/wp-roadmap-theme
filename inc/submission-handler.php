<?php

/**
 * Submission Form Handler
 * 
 * @package Roadmap
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handle Submission Form
 */
function roadmap_handle_submission()
{
    // Check if form was submitted
    if (!isset($_POST['roadmap_submit']) || !isset($_POST['roadmap_submission_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['roadmap_submission_nonce'], 'roadmap_submission_form')) {
        wp_die('Security check failed');
    }

    // Get form data
    $name = sanitize_text_field($_POST['submitter_name']);
    $email = sanitize_email($_POST['submitter_email']);
    $type = sanitize_text_field($_POST['submission_type']);
    $title = sanitize_text_field($_POST['submission_title']);
    $description = sanitize_textarea_field($_POST['submission_description']);

    // Validate email domain
    $email_domain = substr(strrchr($email, "@"), 1);
    $allowed_domain = 'designindc.com';

    if ($email_domain !== $allowed_domain) {
        wp_redirect(add_query_arg('submission', 'invalid_email', home_url('/')));
        exit;
    }

    // Validate required fields
    if (empty($name) || empty($email) || empty($type) || empty($title) || empty($description)) {
        wp_redirect(add_query_arg('submission', 'missing_fields', home_url('/')));
        exit;
    }

    // Create submission post
    $post_id = wp_insert_post(array(
        'post_title'   => $title,
        'post_type'    => 'submission',
        'post_status'  => 'publish',
        'post_author'  => 1, // Admin user
    ));

    if (is_wp_error($post_id)) {
        wp_redirect(add_query_arg('submission', 'error', home_url('/')));
        exit;
    }

    // Save custom fields
    update_field('submission_type', $type, $post_id);
    update_field('submission_description', $description, $post_id);
    update_field('submitter_name', $name, $post_id);
    update_field('submitter_email', $email, $post_id);
    update_field('submission_date', current_time('Y-m-d H:i:s'), $post_id);


    // Send notification email to configured address
    $notification_email = get_option('roadmap_notification_email', get_option('admin_email'));
    $subject = sprintf('[Roadmap] New %s: %s', ($type === 'bug' ? 'Bug Report' : 'Feature Request'), $title);
    $message = sprintf(
        "New submission received:\n\nType: %s\nTitle: %s\nDescription: %s\n\nSubmitted by: %s (%s)\nDate: %s\n\nView in admin: %s",
        ($type === 'bug' ? 'Bug Report' : 'Feature Request'),
        $title,
        $description,
        $name,
        $email,
        current_time('F j, Y g:i a'),
        admin_url('post.php?post=' . $post_id . '&action=edit')
    );

    wp_mail($notification_email, $subject, $message);

    // Get Thank You page URL - try both possible slugs
    $thank_you_page = get_page_by_path('thank-you-page');
    if (!$thank_you_page) {
        $thank_you_page = get_page_by_path('thank-you');
    }

    if ($thank_you_page) {
        $redirect_url = add_query_arg('type', $type, get_permalink($thank_you_page->ID));
    } else {
        // Fallback to home with success message
        $redirect_url = add_query_arg(array(
            'submission' => 'success',
            'type' => $type
        ), home_url('/'));
    }

    wp_redirect($redirect_url);
    exit;
}
add_action('template_redirect', 'roadmap_handle_submission');


/**
 * Display submission form messages
 */
function roadmap_submission_messages()
{
    if (!isset($_GET['submission'])) {
        return '';
    }

    $status = $_GET['submission'];
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    // Success message with type-specific content
    if ($status === 'success') {
        $is_bug = ($type === 'bug');
        $icon = $is_bug ? '🐛' : '✨';
        $title = $is_bug ? 'Bug Report Received!' : 'Feature Request Received!';
        $message = $is_bug
            ? 'Thank you for reporting this bug. Our development team will investigate and work on a fix.'
            : 'Thank you for your feature suggestion! We\'ll review it and consider it for future updates.';

        ob_start();
?>
        <div class="mb-8 p-8 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl shadow-lg">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center text-3xl">
                        <?php echo $icon; ?>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-green-900 mb-2">
                        <?php echo esc_html($title); ?>
                    </h3>
                    <p class="text-green-800 mb-4 leading-relaxed">
                        <?php echo esc_html($message); ?>
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="<?php echo esc_url(home_url('/')); ?>"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Back to Home
                        </a>
                        <a href="<?php echo esc_url(home_url('/#submit-feedback')); ?>"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-green-700 font-semibold rounded-lg hover:bg-green-50 transition-colors border-2 border-green-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Submit Another
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php
        return ob_get_clean();
    }

    // Error messages
    $error_messages = array(
        'invalid_email' => array(
            'icon' => '⚠️',
            'title' => 'Invalid Email Domain',
            'text' => 'Sorry, submissions are only allowed from @designindc.com email addresses.',
        ),
        'missing_fields' => array(
            'icon' => '📝',
            'title' => 'Missing Information',
            'text' => 'Please fill in all required fields to submit your feedback.',
        ),
        'error' => array(
            'icon' => '❌',
            'title' => 'Submission Error',
            'text' => 'An error occurred while processing your submission. Please try again.',
        ),
    );

    if (!isset($error_messages[$status])) {
        return '';
    }

    $error = $error_messages[$status];

    ob_start();
    ?>
    <div class="mb-6 p-6 bg-red-50 border-2 border-red-200 rounded-xl">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0 text-2xl">
                <?php echo $error['icon']; ?>
            </div>
            <div class="flex-1">
                <h4 class="text-lg font-bold text-red-900 mb-1">
                    <?php echo esc_html($error['title']); ?>
                </h4>
                <p class="text-red-800 text-sm">
                    <?php echo esc_html($error['text']); ?>
                </p>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
