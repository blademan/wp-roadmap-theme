    <footer class="p-10 text-center border-t border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 transition-colors duration-300">
        <p class="text-slate-400 dark:text-slate-600 text-xs font-semibold italic tracking-wide">
            <?php
            printf(
                esc_html__('%1$s DDC APP &bull; %2$s', 'roadmap'),
                get_bloginfo('name'),
                date('Y')
            );
            ?>
        </p>

        <?php if (is_active_sidebar('footer-1')) : ?>
            <div class="footer-widgets mt-6">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        <?php endif; ?>
    </footer>

    </div><!-- #page -->

    <?php wp_footer(); ?>
    </body>

    </html>