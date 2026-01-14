<?php

/**
 * The main template file
 * 
 * @package Roadmap
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="max-w-4xl mx-auto bg-white dark:bg-slate-800 shadow-xl rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700 transition-colors duration-300">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('p-8 sm:p-12 border-b border-slate-100 dark:border-slate-700 last:border-b-0 transition-colors duration-300'); ?>>
                        <header class="entry-header mb-6">
                            <?php
                            if (is_singular()) :
                                the_title('<h1 class="entry-title text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">', '</h1>');
                            else :
                                the_title('<h2 class="entry-title text-2xl font-bold text-slate-800 dark:text-white mb-2"><a href="' . esc_url(get_permalink()) . '" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">', '</a></h2>');
                            endif;
                            ?>

                            <div class="entry-meta text-slate-500 dark:text-slate-400 text-sm">
                                <time datetime="<?php echo get_the_date('c'); ?>">
                                    <?php echo get_the_date(); ?>
                                </time>
                                <?php if (get_post_type() !== 'page') : ?>
                                    <span class="mx-2">&bull;</span>
                                    <span><?php the_author(); ?></span>
                                <?php endif; ?>
                            </div>
                        </header>

                        <div class="entry-content prose dark:prose-invert max-w-none text-slate-600 dark:text-slate-300">
                            <?php
                            if (is_singular()) :
                                the_content();
                            else :
                                the_excerpt();
                            endif;
                            ?>
                        </div>
                    </article>

                <?php endwhile; ?>

                <?php
                // Pagination
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => __('&larr; Previous', 'roadmap'),
                    'next_text' => __('Next &rarr;', 'roadmap'),
                    'class'     => 'p-8',
                ));
                ?>

            <?php else : ?>

                <div class="p-8 sm:p-12 text-center">
                    <h1 class="text-2xl font-bold text-slate-800 dark:text-white mb-4">
                        <?php esc_html_e('Nothing Found', 'roadmap'); ?>
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400">
                        <?php esc_html_e('It seems we can&rsquo;t find what you&rsquo;re looking for.', 'roadmap'); ?>
                    </p>
                </div>

            <?php endif; ?>

        </div>

    </main>
</div>

<?php
get_footer();
