<?php

/**
 * Template Name: Submission Thank You
 * Description: Thank you page for bug reports and feature requests with dark mode
 * 
 * @package Roadmap
 */

get_header();

// Get submission type from URL
$type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'bug';
$is_bug = ($type === 'bug');

// Set content based on type
$icon = $is_bug ? '🐛' : '✨';
$title = $is_bug ? 'Bug Report Received!' : 'Feature Request Received!';
$message = $is_bug
    ? 'Thank you for reporting this bug. Our development team will investigate and work on a fix.'
    : 'Thank you for your feature suggestion! We\'ll review it and consider it for future updates.';
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="min-h-screen flex items-center justify-center px-4 py-12 transition-colors duration-300 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
            <div class="max-w-2xl w-full">

                <!-- Success Card -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-2xl overflow-hidden transition-colors duration-300">

                    <!-- Header with Gradient (Blue) -->
                    <div class="bg-gradient-to-r from-blue-600 to-blue-500 dark:from-blue-700 dark:to-blue-600 p-8 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 bg-white dark:bg-slate-100 rounded-full shadow-lg mb-4">
                            <span class="text-5xl"><?php echo $icon; ?></span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">
                            <?php echo esc_html($title); ?>
                        </h1>
                    </div>

                    <!-- Content -->
                    <div class="p-8 md:p-12">
                        <p class="text-lg text-slate-700 dark:text-slate-300 leading-relaxed mb-8 text-center">
                            <?php echo esc_html($message); ?>
                        </p>

                        <!-- What Happens Next -->
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-6 mb-8 transition-colors duration-300">
                            <h2 class="text-lg font-bold text-slate-800 dark:text-slate-200 mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                What Happens Next?
                            </h2>
                            <ul class="space-y-3 text-sm text-slate-600 dark:text-slate-400">
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Your submission has been saved and our team has been notified</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span><?php echo $is_bug ? 'We\'ll investigate the issue and prioritize a fix' : 'We\'ll review your suggestion and consider it for our roadmap'; ?></span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>You can track updates on our roadmap page</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="<?php echo esc_url(home_url('/')); ?>"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-500 dark:from-blue-700 dark:to-blue-600 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-600 dark:hover:from-blue-800 dark:hover:to-blue-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Back to Home
                            </a>
                            <a href="<?php echo esc_url(home_url('/#submit-feedback')); ?>"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-white dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold rounded-xl hover:bg-slate-50 dark:hover:bg-slate-600 transition-all border-2 border-slate-200 dark:border-slate-600 hover:border-slate-300 dark:hover:border-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Submit Another
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Additional Info -->
                <div class="text-center mt-8 text-sm text-slate-500 dark:text-slate-400">
                    <p>Need help? Contact us at <a href="mailto:<?php echo get_option('admin_email'); ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium"><?php echo get_option('admin_email'); ?></a></p>
                </div>

            </div>
        </div>

    </main>
</div>

<?php
get_footer();
