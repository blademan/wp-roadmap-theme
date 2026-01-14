# 🚀 Roadmap WordPress Theme

**Version 1.0.0**

A modern, high-performance WordPress theme designed specifically for SaaS products, startups, and developers to showcase their **Changelogs**, **Roadmaps**, and **Release Notes**.

Built with a "Zero-Config" philosophy, this theme automatically sets up your environment, cleans up the WordPress admin, and populates sample data instantly upon activation.

---

## ✨ Key Features

### 🎨 Design & UX
*   **Global Dark Mode**: A persistent, system-aware dark mode that works across every page. Includes a sticky toggle and smooth CSS transitions.
*   **Tailwind CSS**: Styled with utility-first CSS for rapid UI development and easy customization.
*   **Responsive**: Mobile-first architecture using the Inter font family for maximum readability.

### 🛠️ Architecture
*   **Automated Setup**: Instantly creates "Home", "Thank You" pages, and sets the reading settings on activation.
*   **Smart Seeding**: Automatically populates your site with a sample Changelog (v1.0.13) and Roadmap items so you never start with a blank screen.
*   **Clean Admin**: Aggressively cleans the WordPress Dashboard by removing:
    *   "Posts" (Blog)
    *   "Comments"
    *   "Media Library"
    *   Unused Dashboard Widgets
    *   Admin Bar Bloat
*   **No Gutenberg**: Disables the Block Editor globally to ensure data integrity via structured Custom Fields.

### 🧩 Dynamic Content
*   **Changelog CPT**: specialized post type for releases with Version, Date, Enhancements, and Bugs.
*   **Roadmap CPT**: Kanban-style cards for future feature planning.
*   **Secure Custom Fields Integration**: leveraging the SCF plugin for robust data management.

---

## 📋 Requirements

*   **WordPress Core**: 6.0 or higher.
*   **PHP**: 7.4 or higher.
*   **Plugin**: **[Secure Custom Fields](https://wordpress.org/plugins/secure-custom-fields/)** (Required).
    *   *Note: The theme relies on this plugin for all dynamic data. Please install it BEFORE activating the theme.*

---

## 🚀 Installation

### Option 1: Fresh Installation (Recommended)
1.  **Install Plugin**: Go to `Plugins > Add New` and install/activate **Secure Custom Fields**.
2.  **Upload Theme**: Go to `Appearance > Themes > Add New > Upload` and upload the `roadmap.zip`.
3.  **Activate**: Click **Activate**.
4.  **Done!**: The theme will automatically:
    *   Create your pages.
    *   Seed sample content.
    *   Redirect you to the clean dashboard.

### Option 2: Updating/Existing Site
*   Upload the theme folder to `/wp-content/themes/roadmap`.
*   Ensure the SCF plugin is active.
*   If you want to reset/re-seed content, you can use the hidden seeder tool if enabled in `inc/changelog-seeder.php`.

---

## 📂 Project Structure

```text
roadmap/
├── assets/                  # Compiled assets
│   ├── js/main.js          # Dark mode logic & UI interactions
│   └── css/                # Styles
├── inc/                     # Core Functionality
│   ├── acf-fields.php      # Custom Field Definitions (PHP)
│   ├── admin-cleanup.php   # Admin UI cleaning & hardening
│   ├── changelog-seeder.php # Auto-content generator
│   └── smtp-config.php     # Email configuration
├── template-parts/          # Reusable UI components
├── front-page.php           # The main App Dashboard / Home
├── archive-changelog.php    # Version History List
├── functions.php            # Theme bootloader
└── style.css                # Theme metadata
```

---

## 🎨 Customization

### Changing Brand Colors
The primary brand color is **#0066cc** (DesigninDC Blue).
To change it, update the `tailwind.config` object in `functions.php`:

```php
tailwind.config = {
    theme: {
        extend: {
            colors: {
                "ddc-blue": "#YOUR_HEX_CODE",
            }
        }
    }
}
```

### Adding New Fields
Edit `inc/acf-fields.php` to add new repeater fields or text inputs to the Changelog or Roadmap post types.

---

## 🤖 AI Workflow

This theme follows the **AI WordPress Blueprint** workflow found in `.agent/workflows/ai-wordpress-blueprint.md`. It is designed to be maintained and expanded by AI agents or developers following strict strict modular patterns.

---

## 📝 License

Licensed under the GPL v2 or later.
Designed by **DesigninDC**.
