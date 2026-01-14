<?php

/**
 * Front Page Template
 * 
 * @package Roadmap
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 shadow-xl rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700 transition-colors duration-300">

            <!-- Header -->
            <header class="bg-slate-50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-700 p-8 sm:p-12 text-center transition-colors duration-300">
                <h1 class="text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">
                    <?php echo esc_html(get_bloginfo('name')); ?>: Changelog &amp; Progress Report
                </h1>
                <p class="text-slate-500 dark:text-slate-400 font-semibold tracking-widest uppercase text-xs">
                    Internal Development Sync | <?php echo date('F Y'); ?>
                </p>
            </header>

            <div class="p-8 sm:p-12 space-y-12">

                <!-- Recently Shipped (Dynamic from Changelog CPT) -->
                <?php
                // Query the latest changelog by release_date
                $latest_changelog = new WP_Query(array(
                    'post_type'      => 'changelog',
                    'posts_per_page' => 1,
                    'meta_key'       => 'release_date',
                    'orderby'        => 'meta_value',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                ));

                if ($latest_changelog->have_posts()) :
                    while ($latest_changelog->have_posts()) : $latest_changelog->the_post();
                        $version_number = get_field('version_number');
                        $web_enhancements = get_field('web_enhancements');
                        $mobile_features = get_field('mobile_features');
                ?>

                        <section>
                            <div class="flex items-center gap-3 mb-8">
                                <div class="p-2.5 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                                    <svg class="w-6 h-6 ddc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">
                                    Recently Shipped (<?php echo esc_html($version_number ? $version_number : 'Latest'); ?>)
                                </h2>
                            </div>

                            <div class="grid md:grid-cols-2 gap-8">
                                <!-- Web Enhancements -->
                                <div class="space-y-5">
                                    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full ddc-bg-blue"></span> Web Enhancements
                                    </h3>
                                    <?php if ($web_enhancements && is_array($web_enhancements)) : ?>
                                        <ul class="space-y-4 text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                                            <?php foreach ($web_enhancements as $enhancement) : ?>
                                                <li class="flex gap-3">
                                                    <span class="text-blue-500 dark:text-blue-400 font-bold">#</span>
                                                    <span>
                                                        <strong><?php echo esc_html($enhancement['feature_title']); ?>:</strong>
                                                        <?php echo esc_html($enhancement['feature_description']); ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm italic">No web enhancements for this version.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Mobile Features -->
                                <div class="space-y-5">
                                    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full ddc-bg-blue"></span> Mobile Features
                                    </h3>
                                    <?php if ($mobile_features && is_array($mobile_features)) : ?>
                                        <ul class="space-y-4 text-slate-600 dark:text-slate-300 text-sm leading-relaxed">
                                            <?php foreach ($mobile_features as $feature) : ?>
                                                <li class="flex gap-3">
                                                    <span class="text-blue-500 dark:text-blue-400 font-bold">#</span>
                                                    <span>
                                                        <strong><?php echo esc_html($feature['feature_title']); ?>:</strong>
                                                        <?php echo esc_html($feature['feature_description']); ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm italic">No mobile features for this version.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- View All Changelogs Link -->
                            <div class="mt-8 text-center">
                                <a href="<?php echo esc_url(get_post_type_archive_link('changelog')); ?>"
                                    class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold text-sm transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    View All Version History
                                </a>
                            </div>
                        </section>

                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback if no changelog exists
                    ?>

                    <section>
                        <div class="flex items-center gap-3 mb-8">
                            <div class="p-2.5 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                                <svg class="w-6 h-6 ddc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Recently Shipped</h2>
                        </div>
                        <div class="p-8 bg-slate-50 dark:bg-slate-700/30 rounded-xl text-center">
                            <p class="text-slate-600 dark:text-slate-400 mb-4">No changelogs have been published yet.</p>
                            <?php if (current_user_can('edit_posts')) : ?>
                                <a href="<?php echo admin_url('post-new.php?post_type=changelog'); ?>"
                                    class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                    Create First Changelog
                                </a>
                            <?php endif; ?>
                        </div>
                    </section>

                <?php endif; ?>


                <!-- Active Development & Bugs (Dynamic) -->
                <?php
                // Query the latest changelog for active bugs (by release_date)
                $latest_for_bugs = new WP_Query(array(
                    'post_type'      => 'changelog',
                    'posts_per_page' => 1,
                    'meta_key'       => 'release_date',
                    'orderby'        => 'meta_value',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                ));

                if ($latest_for_bugs->have_posts()) :
                    while ($latest_for_bugs->have_posts()) : $latest_for_bugs->the_post();
                        $active_bugs = get_field('active_bugs');
                ?>

                        <section class="gradient-border bg-slate-50 dark:bg-slate-700/30 rounded-r-2xl p-8 border-l-4">
                            <div class="flex items-center gap-3 mb-6">
                                <h2 class="text-sm font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Active Development &amp; Bugs</h2>
                            </div>

                            <?php if ($active_bugs && is_array($active_bugs) && count($active_bugs) > 0) : ?>
                                <ul class="space-y-5 text-slate-600 dark:text-slate-300 text-sm">
                                    <?php foreach ($active_bugs as $bug) : ?>
                                        <li class="flex items-start gap-4">
                                            <div class="mt-1.5 w-2 h-2 rounded-full bg-orange-500 shrink-0 shadow-sm shadow-orange-200"></div>
                                            <span>
                                                <strong class="text-slate-800 dark:text-slate-100"><?php echo esc_html($bug['bug_title']); ?>:</strong>
                                                <?php echo esc_html($bug['bug_description']); ?>
                                            </span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else : ?>
                                <p class="text-slate-600 dark:text-slate-400 text-sm italic">No active development items or bugs at this time.</p>
                            <?php endif; ?>
                        </section>

                    <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                    // Fallback if no changelog exists
                    ?>

                    <section class="gradient-border bg-slate-50 dark:bg-slate-700/30 rounded-r-2xl p-8 border-l-4">
                        <div class="flex items-center gap-3 mb-6">
                            <h2 class="text-sm font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Active Development &amp; Bugs</h2>
                        </div>
                        <p class="text-slate-600 dark:text-slate-400 text-sm italic">No active development items or bugs at this time.</p>
                    </section>

                <?php endif; ?>

                <!-- Roadmap -->
                <section>
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-8 flex items-center gap-2">
                        <svg class="w-5 h-5 ddc-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Future Roadmap
                    </h2>

                    <?php
                    // Query roadmap items
                    $roadmap_items = new WP_Query(array(
                        'post_type'      => 'roadmap_item',
                        'posts_per_page' => -1, // Get all items
                        'orderby'        => 'menu_order date',
                        'order'          => 'ASC',
                        'post_status'    => 'publish',
                    ));

                    if ($roadmap_items->have_posts()) :
                    ?>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <?php while ($roadmap_items->have_posts()) : $roadmap_items->the_post();
                                $description = get_field('roadmap_description');
                            ?>
                                <div class="p-5 border border-slate-100 dark:border-slate-700 rounded-2xl card-hover bg-white dark:bg-slate-800 shadow-sm transition-colors duration-300">
                                    <p class="font-bold text-slate-800 dark:text-slate-100 mb-1 text-base"><?php the_title(); ?></p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-normal"><?php echo esc_html($description); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php
                        wp_reset_postdata();
                    else :
                    ?>
                        <div class="p-8 bg-slate-50 dark:bg-slate-700/30 rounded-xl text-center">
                            <p class="text-slate-600 dark:text-slate-400 text-sm mb-4">No roadmap items planned yet.</p>
                            <?php if (current_user_can('edit_posts')) : ?>
                                <a href="<?php echo admin_url('post-new.php?post_type=roadmap_item'); ?>"
                                    class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                    Add First Roadmap Item
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- Submission Form -->
                <section id="submit-feedback" class="mt-12 pt-12 border-t border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        Submit Feedback
                    </h2>
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-8">
                        Report bugs or request features. Only available for @designindc.com team members.
                    </p>

                    <?php echo roadmap_submission_messages(); ?>

                    <form method="post" action="" class="space-y-6">
                        <?php wp_nonce_field('roadmap_submission_form', 'roadmap_submission_nonce'); ?>

                        <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                            <!-- Name -->
                            <div>
                                <label for="submitter_name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Your Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="submitter_name"
                                    name="submitter_name"
                                    required
                                    class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white dark:bg-slate-700 dark:text-white placeholder-slate-400"
                                    placeholder="Eduard">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="submitter_email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                    Email (@designindc.com) <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="submitter_email"
                                    name="submitter_email"
                                    required
                                    pattern=".*@designindc\.com$"
                                    class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white dark:bg-slate-700 dark:text-white placeholder-slate-400"
                                    placeholder="eduard@designindc.com">
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1.5">Must be a @designindc.com email address</p>
                            </div>
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="submission_type" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="submission_type"
                                name="submission_type"
                                required
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white dark:bg-slate-700 dark:text-white">
                                <option value="bug">🐛 Bug Report</option>
                                <option value="feature">✨ Feature Request</option>
                            </select>
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="submission_title" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="submission_title"
                                name="submission_title"
                                required
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-sm bg-white dark:bg-slate-700 dark:text-white placeholder-slate-400"
                                placeholder="Brief summary of the issue or feature">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="submission_description" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="submission_description"
                                name="submission_description"
                                required
                                rows="6"
                                class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition resize-y text-sm bg-white dark:bg-slate-700 dark:text-white placeholder-slate-400"
                                placeholder="Provide detailed information about the bug or feature request..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pt-2">
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                <span class="text-red-500">*</span> Required fields
                            </p>
                            <button
                                type="submit"
                                name="roadmap_submit"
                                class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Submit Feedback
                            </button>
                        </div>
                    </form>
                </section>
            </div>





        </div>

</div>

</main>
</div>

<?php
get_footer();
