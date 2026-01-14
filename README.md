# Roadmap WordPress Theme

A modern, professional WordPress theme for showcasing changelogs, development progress, and roadmap planning.

## Features

- **Clean, Modern Design**: Built with Tailwind CSS and Inter font
- **Custom Post Types**: 
  - Changelogs for tracking releases
  - Roadmap Items for future planning
- **Responsive Layout**: Mobile-first design that works on all devices
- **Dashboard Widget**: Quick access to theme statistics and management
- **Auto Page Creation**: Automatically creates essential pages on activation
- **Widget Ready**: Sidebar and footer widget areas
- **SEO Optimized**: Semantic HTML5 markup

## Requirements

- WordPress 6.0 or higher
- **Secure Custom Fields (SCF)** Plugin (Required for dynamic fields)

## Installation

1. **Install Plugin**: Go to Plugins > Add New, search for "Secure Custom Fields" and install/activate it.
2. **Upload Theme**: Upload the `roadmap.zip` file via Appearance > Themes > Add New > Upload Theme.
3. **Activate**: Activate the theme.
4. **Setup**: The theme will automatically:
   - Create a "Home" page and set it as the Front Page.
   - Create a "Thank You" page.
   - Register the necessary Custom Post Types (Changelogs, Roadmap).

## Customization

### Brand Colors
The theme uses `#0066cc` as the primary brand color. You can customize this in:
- `style.css` (CSS variables)
- `front-page.php` (inline styles)

### Custom Post Types
- **Changelogs**: Manage version releases and updates
- **Roadmap Items**: Plan and display future features

### Widget Areas
- **Sidebar**: Main sidebar widget area
- **Footer**: Footer widget area

## Development

### File Structure
```
roadmap/
├── assets/
│   ├── css/
│   ├── js/
│   │   └── main.js
│   └── images/
├── inc/
├── template-parts/
├── functions.php
├── style.css
├── header.php
├── footer.php
├── index.php
├── front-page.php
└── screenshot.png
```

### Technologies Used
- Tailwind CSS (CDN)
- Google Fonts (Inter)
- Vanilla JavaScript
- WordPress 6.0+

## Future Enhancements

Following the HTML to WordPress Conversion Workflow, future phases will include:

- **Phase 3**: ACF integration for dynamic content management
- **Phase 4**: Template parts for reusable components
- **Phase 5**: Form handling, SEO schema, and security hardening
- **Phase 6**: White labeling and admin customization

## Support

For support and customization requests, contact DesigninDC.

## License

This theme is licensed under the GPL v2 or later.

## Credits

- Design: DesigninDC
- Tailwind CSS: https://tailwindcss.com
- Google Fonts: https://fonts.google.com
