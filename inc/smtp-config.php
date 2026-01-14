<?php

/**
 * SMTP Configuration
 * 
 * @package Roadmap
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configure PHPMailer for SMTP
 */
function roadmap_configure_smtp($phpmailer)
{
    // Check if SMTP is enabled
    if (!get_option('roadmap_smtp_enabled')) {
        return;
    }

    // Get SMTP settings
    $smtp_host = get_option('roadmap_smtp_host');
    $smtp_port = get_option('roadmap_smtp_port', 587);
    $smtp_username = get_option('roadmap_smtp_username');
    $smtp_password = get_option('roadmap_smtp_password');
    $smtp_encryption = get_option('roadmap_smtp_encryption', 'tls');
    $from_email = get_option('roadmap_smtp_from_email');
    $from_name = get_option('roadmap_smtp_from_name', get_bloginfo('name'));

    // Validate required settings
    if (empty($smtp_host) || empty($smtp_username) || empty($smtp_password)) {
        return;
    }

    // Configure PHPMailer
    $phpmailer->isSMTP();
    $phpmailer->Host = $smtp_host;
    $phpmailer->Port = $smtp_port;
    $phpmailer->SMTPAuth = true;
    $phpmailer->Username = $smtp_username;
    $phpmailer->Password = $smtp_password;

    // Set encryption
    if ($smtp_encryption === 'ssl') {
        $phpmailer->SMTPSecure = 'ssl';
    } elseif ($smtp_encryption === 'tls') {
        $phpmailer->SMTPSecure = 'tls';
    }

    // Set From email and name
    if (!empty($from_email)) {
        $phpmailer->From = $from_email;
    }
    if (!empty($from_name)) {
        $phpmailer->FromName = $from_name;
    }

    // Enable SMTP debugging (only for admins)
    if (current_user_can('manage_options') && defined('WP_DEBUG') && WP_DEBUG) {
        $phpmailer->SMTPDebug = 2;
        $phpmailer->Debugoutput = 'error_log';
    }
}
add_action('phpmailer_init', 'roadmap_configure_smtp');

/**
 * Set default From email and name for all emails
 */
function roadmap_mail_from($email)
{
    $from_email = get_option('roadmap_smtp_from_email');
    return !empty($from_email) ? $from_email : $email;
}

function roadmap_mail_from_name($name)
{
    $from_name = get_option('roadmap_smtp_from_name');
    return !empty($from_name) ? $from_name : $name;
}

// Only apply if SMTP is enabled
if (get_option('roadmap_smtp_enabled')) {
    add_filter('wp_mail_from', 'roadmap_mail_from');
    add_filter('wp_mail_from_name', 'roadmap_mail_from_name');
}
