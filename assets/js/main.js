/**
 * Roadmap Theme Scripts
 * 
 * @package Roadmap
 */

(function () {
    'use strict';

    // Smooth scroll for anchor links
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('a[href^="#"]');

        links.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');

                if (href !== '#' && href !== '#0') {
                    const target = document.querySelector(href);

                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Add animation on scroll (optional enhancement)
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        // Observe sections for fade-in effect
        // Observe sections for fade-in effect
        document.querySelectorAll('section').forEach(section => {
            observer.observe(section);
        });

        // Dark Mode Toggle Logic
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        if (themeToggleBtn) {
            // Check for saved theme preference or default to light mode
            const currentTheme = localStorage.getItem('theme') || 'light';

            // Set initial state
            if (currentTheme === 'dark') {
                document.documentElement.classList.add('dark');
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleBtn.classList.add('bg-slate-700', 'text-yellow-300');
                themeToggleBtn.classList.remove('bg-white', 'text-slate-800');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleBtn.classList.add('bg-white', 'text-slate-800');
                themeToggleBtn.classList.remove('bg-slate-700', 'text-yellow-300');
            }

            // Click handler
            themeToggleBtn.addEventListener('click', function () {
                // Toggle icons
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // Toggle dark mode
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    themeToggleBtn.classList.add('bg-white', 'text-slate-800');
                    themeToggleBtn.classList.remove('bg-slate-700', 'text-yellow-300');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    themeToggleBtn.classList.add('bg-slate-700', 'text-yellow-300');
                    themeToggleBtn.classList.remove('bg-white', 'text-slate-800');
                }
            });
        }
    });

})();
