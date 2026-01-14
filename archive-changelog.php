<?php

/**
 * Archive Template for Changelog CPT
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
                    Version History
                </h1>
                <p class="text-slate-500 dark:text-slate-400 font-semibold tracking-widest uppercase text-xs">
                    All Changelog Releases
                </p>
            </header>

            <div class="p-8 sm:p-12 space-y-8">

                <?php
                // Custom query to sort by release_date field
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                $changelog_query = new WP_Query(array(
                    'post_type'      => 'changelog',
                    'posts_per_page' => 10,
                    'paged'          => $paged,
                    'meta_key'       => 'release_date',
                    'orderby'        => 'meta_value',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                ));

                if ($changelog_query->have_posts()) :
                ?>

                    <?php while ($changelog_query->have_posts()) : $changelog_query->the_post();
                        $version_number = get_field('version_number');
                        $release_date = get_field('release_date');
                        $web_enhancements = get_field('web_enhancements');
                        $mobile_features = get_field('mobile_features');
                    ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class('border border-slate-200 dark:border-slate-700 rounded-2xl p-6 sm:p-8 hover:shadow-lg transition-all'); ?>>

                            <!-- Version Header -->
                            <header class="mb-6 pb-4 border-b border-slate-100 dark:border-slate-700">
                                <div class="flex items-center justify-between flex-wrap gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                                            <?php echo esc_html($version_number ? $version_number : get_the_title()); ?>
                                        </h2>
                                    </div>
                                    <?php if ($release_date) : ?>
                                        <time datetime="<?php echo esc_attr($release_date); ?>" class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                                            <?php echo date('F j, Y', strtotime($release_date)); ?>
                                        </time>
                                    <?php else : ?>
                                        <time datetime="<?php echo get_the_date('c'); ?>" class="text-sm text-slate-500 dark:text-slate-400 font-medium">
                                            <?php echo get_the_date('F j, Y'); ?>
                                        </time>
                                    <?php endif; ?>
                                </div>
                            </header>

                            <!-- Features Grid -->
                            <div class="grid md:grid-cols-2 gap-6">

                                <!-- Web Enhancements -->
                                <?php if ($web_enhancements && is_array($web_enhancements) && count($web_enhancements) > 0) : ?>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-700 dark:text-slate-200 mb-3 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                            Web Enhancements
                                        </h3>
                                        <ul class="space-y-3 text-slate-600 dark:text-slate-300 text-sm">
                                            <?php foreach ($web_enhancements as $enhancement) : ?>
                                                <li class="flex gap-2">
                                                    <span class="text-blue-500 dark:text-blue-400 font-bold">#</span>
                                                    <span>
                                                        <strong><?php echo esc_html($enhancement['feature_title']); ?>:</strong>
                                                        <?php echo esc_html($enhancement['feature_description']); ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Mobile Features -->
                                <?php if ($mobile_features && is_array($mobile_features) && count($mobile_features) > 0) : ?>
                                    <div>
                                        <h3 class="text-base font-bold text-slate-700 dark:text-slate-200 mb-3 flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                            Mobile Features
                                        </h3>
                                        <ul class="space-y-3 text-slate-600 dark:text-slate-300 text-sm">
                                            <?php foreach ($mobile_features as $feature) : ?>
                                                <li class="flex gap-2">
                                                    <span class="text-blue-500 dark:text-blue-400 font-bold">#</span>
                                                    <span>
                                                        <strong><?php echo esc_html($feature['feature_title']); ?>:</strong>
                                                        <?php echo esc_html($feature['feature_description']); ?>
                                                    </span>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <!-- Active Bugs (if exists) -->
                            <?php
                            $active_bugs = get_field('active_bugs');
                            if ($active_bugs && is_array($active_bugs) && count($active_bugs) > 0) :
                            ?>
                                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                                    <h3 class="text-base font-bold text-slate-700 dark:text-slate-200 mb-3 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                        Active Development & Bugs
                                    </h3>
                                    <ul class="space-y-3 text-slate-600 dark:text-slate-300 text-sm">
                                        <?php foreach ($active_bugs as $bug) : ?>
                                            <li class="flex gap-2">
                                                <span class="text-orange-500 font-bold">●</span>
                                                <span>
                                                    <strong><?php echo esc_html($bug['bug_title']); ?>:</strong>
                                                    <?php echo esc_html($bug['bug_description']); ?>
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <!-- Full Content (if exists) -->
                            <?php if (get_the_content()) : ?>
                                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-700 prose max-w-none text-slate-600 dark:text-slate-300">
                                    <?php the_content(); ?>
                                </div>
                            <?php endif; ?>

                        </article>

                    <?php endwhile; ?>

                    <!-- Pagination -->
                    <?php
                    // Pagination for custom query
                    echo paginate_links(array(
                        'total'     => $changelog_query->max_num_pages,
                        'current'   => max(1, $paged),
                        'mid_size'  => 2,
                        'prev_text' => __('← Newer', 'roadmap'),
                        'next_text' => __('Older →', 'roadmap'),
                        'type'      => 'plain',
                    ));

                    // Reset postdata
                    wp_reset_postdata();
                    ?>

                <?php else : ?>

                    <div class="text-center py-12">
                        <div class="p-6 bg-blue-50 dark:bg-blue-900/30 rounded-full inline-block mb-4">
                            <svg class="w-12 h-12 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-2">
                            <?php esc_html_e('No Changelogs Yet', 'roadmap'); ?>
                        </h2>
                        <p class="text-slate-600 dark:text-slate-400 mb-6">
                            <?php esc_html_e('Start documenting your releases by creating your first changelog.', 'roadmap'); ?>
                        </p>
                        <?php if (current_user_can('edit_posts')) : ?>
                            <a href="<?php echo admin_url('post-new.php?post_type=changelog'); ?>"
                                class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">
                                Create First Changelog
                            </a>
                        <?php endif; ?>
                    </div>

                <?php endif; ?>

                <!-- Back to Home -->
                <div class="text-center pt-8 border-t border-slate-100 dark:border-slate-700">
                    <a href="<?php echo esc_url(home_url('/')); ?>"
                        class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Home
                    </a>
                </div>

            </div>

        </div>

    </main>
</div>

<?php
get_footer();
