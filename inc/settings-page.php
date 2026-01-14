<?php

/**
 * Roadmap Settings Page
 * 
 * @package Roadmap
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Settings Menu
 */
function roadmap_add_settings_menu()
{
    add_menu_page(
        __('Roadmap Settings', 'roadmap'),
        __('Roadmap Settings', 'roadmap'),
        'manage_options',
        'roadmap-settings',
        'roadmap_settings_page',
        'dashicons-admin-generic',
        100
    );
}
add_action('admin_menu', 'roadmap_add_settings_menu');

/**
 * Register Settings
 */
function roadmap_register_settings()
{
    // Notification Email
    register_setting('roadmap_settings', 'roadmap_notification_email', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_email',
        'default' => get_option('admin_email'),
    ));

    // SMTP Settings
    register_setting('roadmap_settings', 'roadmap_smtp_enabled', array(
        'type' => 'boolean',
        'default' => false,
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_host', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_port', array(
        'type' => 'integer',
        'default' => 587,
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_username', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_password', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_encryption', array(
        'type' => 'string',
        'default' => 'tls',
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_from_email', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_email',
    ));

    register_setting('roadmap_settings', 'roadmap_smtp_from_name', array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => get_bloginfo('name'),
    ));
}
add_action('admin_init', 'roadmap_register_settings');

/**
 * Settings Page HTML
 */
function roadmap_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    // Save settings
    if (isset($_GET['settings-updated'])) {
        add_settings_error('roadmap_messages', 'roadmap_message', __('Settings Saved', 'roadmap'), 'updated');
    }

    settings_errors('roadmap_messages');
?>

    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <form action="options.php" method="post">
            <?php
            settings_fields('roadmap_settings');
            ?>

            <table class="form-table" role="presentation">

                <!-- Notification Email -->
                <tr>
                    <th scope="row">
                        <label for="roadmap_notification_email">
                            <?php _e('Notification Email', 'roadmap'); ?>
                        </label>
                    </th>
                    <td>
                        <input type="email"
                            id="roadmap_notification_email"
                            name="roadmap_notification_email"
                            value="<?php echo esc_attr(get_option('roadmap_notification_email', get_option('admin_email'))); ?>"
                            class="regular-text"
                            required>
                        <p class="description">
                            <?php _e('Email address to receive bug reports and feature requests.', 'roadmap'); ?>
                        </p>
                    </td>
                </tr>

                <!-- SMTP Enabled -->
                <tr>
                    <th scope="row">
                        <label for="roadmap_smtp_enabled">
                            <?php _e('Enable SMTP', 'roadmap'); ?>
                        </label>
                    </th>
                    <td>
                        <label>
                            <input type="checkbox"
                                id="roadmap_smtp_enabled"
                                name="roadmap_smtp_enabled"
                                value="1"
                                <?php checked(get_option('roadmap_smtp_enabled'), 1); ?>>
                            <?php _e('Use SMTP for sending emails', 'roadmap'); ?>
                        </label>
                        <p class="description">
                            <?php _e('Enable this to use SMTP instead of PHP mail() function.', 'roadmap'); ?>
                        </p>
                    </td>
                </tr>

            </table>

            <!-- SMTP Settings (shown when enabled) -->
            <div id="smtp-settings" style="<?php echo get_option('roadmap_smtp_enabled') ? '' : 'display:none;'; ?>">

                <h2><?php _e('SMTP Configuration', 'roadmap'); ?></h2>

                <table class="form-table" role="presentation">

                    <!-- SMTP Host -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_host">
                                <?php _e('SMTP Host', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text"
                                id="roadmap_smtp_host"
                                name="roadmap_smtp_host"
                                value="<?php echo esc_attr(get_option('roadmap_smtp_host')); ?>"
                                class="regular-text"
                                placeholder="smtp.gmail.com">
                            <p class="description">
                                <?php _e('Your SMTP server address (e.g., smtp.gmail.com)', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- SMTP Port -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_port">
                                <?php _e('SMTP Port', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="number"
                                id="roadmap_smtp_port"
                                name="roadmap_smtp_port"
                                value="<?php echo esc_attr(get_option('roadmap_smtp_port', 587)); ?>"
                                class="small-text"
                                min="1"
                                max="65535">
                            <p class="description">
                                <?php _e('Common ports: 587 (TLS), 465 (SSL), 25 (Non-encrypted)', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- SMTP Encryption -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_encryption">
                                <?php _e('Encryption', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <select id="roadmap_smtp_encryption" name="roadmap_smtp_encryption">
                                <option value="tls" <?php selected(get_option('roadmap_smtp_encryption', 'tls'), 'tls'); ?>>TLS</option>
                                <option value="ssl" <?php selected(get_option('roadmap_smtp_encryption'), 'ssl'); ?>>SSL</option>
                                <option value="none" <?php selected(get_option('roadmap_smtp_encryption'), 'none'); ?>>None</option>
                            </select>
                            <p class="description">
                                <?php _e('Recommended: TLS (port 587) or SSL (port 465)', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- SMTP Username -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_username">
                                <?php _e('SMTP Username', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text"
                                id="roadmap_smtp_username"
                                name="roadmap_smtp_username"
                                value="<?php echo esc_attr(get_option('roadmap_smtp_username')); ?>"
                                class="regular-text"
                                autocomplete="off">
                            <p class="description">
                                <?php _e('Your SMTP username (usually your email address)', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- SMTP Password -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_password">
                                <?php _e('SMTP Password', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="password"
                                id="roadmap_smtp_password"
                                name="roadmap_smtp_password"
                                value="<?php echo esc_attr(get_option('roadmap_smtp_password')); ?>"
                                class="regular-text"
                                autocomplete="new-password">
                            <p class="description">
                                <?php _e('Your SMTP password or app-specific password', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- From Email -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_from_email">
                                <?php _e('From Email', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="email"
                                id="roadmap_smtp_from_email"
                                name="roadmap_smtp_from_email"
                                value="<?php echo esc_attr(get_option('roadmap_smtp_from_email')); ?>"
                                class="regular-text">
                            <p class="description">
                                <?php _e('Email address to send from (must match SMTP account)', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                    <!-- From Name -->
                    <tr>
                        <th scope="row">
                            <label for="roadmap_smtp_from_name">
                                <?php _e('From Name', 'roadmap'); ?>
                            </label>
                        </th>
                        <td>
                            <input type="text"
                                id="roadmap_smtp_from_name"
                                name="roadmap_smtp_from_name"
                                value="<?php echo esc_attr(get_option('roadmap_smtp_from_name', get_bloginfo('name'))); ?>"
                                class="regular-text">
                            <p class="description">
                                <?php _e('Name to display as sender', 'roadmap'); ?>
                            </p>
                        </td>
                    </tr>

                </table>

                <!-- Test Email Button -->
                <p>
                    <button type="button" id="test-smtp" class="button button-secondary">
                        <?php _e('Send Test Email', 'roadmap'); ?>
                    </button>
                    <span id="test-result" style="margin-left: 10px;"></span>
                </p>

            </div>

            <?php submit_button(__('Save Settings', 'roadmap')); ?>

        </form>
    </div>

    <script>
        jQuery(document).ready(function($) {
            // Toggle SMTP settings visibility
            $('#roadmap_smtp_enabled').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#smtp-settings').slideDown();
                } else {
                    $('#smtp-settings').slideUp();
                }
            });

            // Test SMTP connection
            $('#test-smtp').on('click', function() {
                var button = $(this);
                var result = $('#test-result');

                button.prop('disabled', true).text('<?php _e('Sending...', 'roadmap'); ?>');
                result.html('');

                $.post(ajaxurl, {
                    action: 'roadmap_test_smtp',
                    nonce: '<?php echo wp_create_nonce('roadmap_test_smtp'); ?>'
                }, function(response) {
                    button.prop('disabled', false).text('<?php _e('Send Test Email', 'roadmap'); ?>');

                    if (response.success) {
                        result.html('<span style="color: green;">✓ ' + response.data.message + '</span>');
                    } else {
                        result.html('<span style="color: red;">✗ ' + response.data.message + '</span>');
                    }
                });
            });
        });
    </script>

<?php
}

/**
 * AJAX Handler for Test Email
 */
function roadmap_test_smtp_ajax()
{
    check_ajax_referer('roadmap_test_smtp', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => __('Permission denied', 'roadmap')));
    }

    $to = get_option('roadmap_notification_email', get_option('admin_email'));
    $subject = __('SMTP Test Email', 'roadmap');
    $message = __('This is a test email from your Roadmap theme. If you received this, SMTP is working correctly!', 'roadmap');

    $sent = wp_mail($to, $subject, $message);

    if ($sent) {
        wp_send_json_success(array('message' => __('Test email sent successfully!', 'roadmap')));
    } else {
        wp_send_json_error(array('message' => __('Failed to send test email. Check your SMTP settings.', 'roadmap')));
    }
}
add_action('wp_ajax_roadmap_test_smtp', 'roadmap_test_smtp_ajax');
