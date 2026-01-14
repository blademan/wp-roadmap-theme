# Changelog Management System - User Guide

## 📋 Overview

The Roadmap theme now includes a **dynamic changelog system** that allows you to manage version releases through WordPress. The front page automatically displays the **latest version**, while older versions are accessible through the version history archive.

---

## 🚀 Quick Start

### Prerequisites

1. **Install Advanced Custom Fields (ACF) Plugin**
   - Go to: Plugins → Add New
   - Search for: "Advanced Custom Fields"
   - Install and activate the plugin
   - The theme will automatically register the changelog fields

### Creating Your First Changelog

1. **Go to WordPress Admin** → Changelogs → Add New
2. **Fill in the fields**:
   - **Title**: Internal reference (e.g., "January 2026 Release")
   - **Version Number**: e.g., `v1.0.13`
   - **Release Date**: Select the release date
   - **Web Enhancements**: Click "Add Enhancement" and fill in:
     - Feature Title (e.g., "Pinned Messages")
     - Description (e.g., "High-priority info can now be starred.")
   - **Mobile Features**: Click "Add Feature" and fill in:
     - Feature Title (e.g., "Manual Unread")
     - Description (e.g., "Long-press to mark for follow-up.")
3. **Publish** the changelog

---

## 📊 How It Works

### Front Page Display

- **Shows**: Only the **latest published changelog**
- **Updates automatically**: When you publish a new changelog, it becomes the featured version
- **Includes**: "View All Version History" link to see older versions

### Version History Archive

- **URL**: `/changelog/` (automatically created)
- **Shows**: All published changelogs in reverse chronological order (newest first)
- **Features**:
  - Version number and release date
  - Web enhancements and mobile features
  - Clean card layout
  - Pagination for many versions

---

## 🎯 Workflow for New Releases

### Step 1: Prepare Content
Gather your release notes:
- Version number
- Release date
- List of web enhancements
- List of mobile features

### Step 2: Create Changelog
1. Go to: **Changelogs → Add New**
2. Enter the version number (e.g., `v1.0.14`)
3. Select the release date
4. Add web enhancements (click "Add Enhancement" for each item)
5. Add mobile features (click "Add Feature" for each item)

### Step 3: Publish
- Click **Publish**
- The front page will automatically update to show this new version
- Previous version moves to the version history archive

### Step 4: Verify
- Visit your homepage to see the new version
- Click "View All Version History" to confirm older versions are accessible

---

## 📝 Field Descriptions

### Version Number
- **Format**: `v1.0.13` or `1.0.13`
- **Purpose**: Displayed in the "Recently Shipped" heading
- **Required**: Yes

### Release Date
- **Format**: Date picker (displays as "January 10, 2026")
- **Purpose**: Shows when the version was released
- **Required**: Yes

### Web Enhancements (Repeater)
- **Feature Title**: Short name (e.g., "Pinned Messages")
- **Feature Description**: Brief explanation (e.g., "High-priority info can now be starred.")
- **Add Multiple**: Click "Add Enhancement" for each feature

### Mobile Features (Repeater)
- **Feature Title**: Short name (e.g., "Quick Reactions")
- **Feature Description**: Brief explanation (e.g., "Native double-tap for quick 👍.")
- **Add Multiple**: Click "Add Feature" for each feature

---

## 🎨 Customization Options

### Changing Section Titles

Edit `front-page.php` to change:
- "Web Enhancements" → Your preferred title
- "Mobile Features" → Your preferred title

### Adding More Categories

To add additional feature categories (e.g., "Backend Updates"):

1. Edit `inc/acf-fields.php`
2. Add a new repeater field similar to `web_enhancements`
3. Update `front-page.php` to display the new field
4. Update `archive-changelog.php` to show it in the archive

---

## 🔄 Version Management

### Latest Version
- **Determined by**: Most recent publish date
- **Display**: Front page only
- **Auto-updates**: Yes, when new changelog is published

### Older Versions
- **Access**: Via "View All Version History" link
- **Display**: Archive page (`/changelog/`)
- **Order**: Newest to oldest
- **Pagination**: Automatic (default: 10 per page)

### Draft Versions
- **Status**: Not visible on front-end
- **Purpose**: Prepare upcoming releases
- **Publish when ready**: Automatically becomes latest version

---

## 💡 Best Practices

### Version Numbering
- Use semantic versioning: `v1.0.13`
- Be consistent with format
- Include the "v" prefix for clarity

### Feature Descriptions
- Keep descriptions concise (1-2 sentences)
- Focus on user benefits
- Use action-oriented language

### Release Timing
- Publish changelogs immediately after deployment
- Use draft status for upcoming releases
- Schedule posts for future releases (WordPress feature)

### Content Organization
- Group related features together
- Separate web and mobile updates
- Prioritize most important features first

---

## 🛠️ Troubleshooting

### "No changelogs have been published yet" Message

**Cause**: No published changelogs exist  
**Solution**: Create and publish your first changelog

### ACF Fields Not Showing

**Cause**: ACF plugin not installed  
**Solution**: 
1. Go to Plugins → Add New
2. Search for "Advanced Custom Fields"
3. Install and activate

### Version Not Updating on Front Page

**Cause**: Changelog is in draft status  
**Solution**: Click "Publish" on the changelog post

### Features Not Displaying

**Cause**: Repeater fields are empty  
**Solution**: Click "Add Enhancement" or "Add Feature" and fill in the fields

---

## 📂 File Structure

```
roadmap/
├── inc/
│   └── acf-fields.php          # ACF field definitions
├── front-page.php              # Homepage (shows latest version)
├── archive-changelog.php       # Version history (all versions)
└── functions.php               # Includes ACF fields
```

---

## 🔗 URLs

- **Homepage**: `/` (shows latest version)
- **Version History**: `/changelog/` (all versions)
- **Admin - All Changelogs**: `/wp-admin/edit.php?post_type=changelog`
- **Admin - Add New**: `/wp-admin/post-new.php?post_type=changelog`

---

## 📈 Advanced Features

### Custom Post Status
You can use WordPress post statuses:
- **Draft**: Work in progress
- **Pending Review**: Ready for approval
- **Scheduled**: Publish at future date
- **Published**: Live on site

### Bulk Actions
- Edit multiple changelogs at once
- Quick edit for version numbers
- Bulk delete old versions

### Search & Filter
- Search changelogs by version number
- Filter by date
- Sort by various criteria

---

## 🎓 Example Workflow

### Scenario: Releasing v1.0.14

1. **Prepare** (1 week before release)
   - Create draft changelog
   - Add version number: `v1.0.14`
   - Add features as they're completed

2. **Review** (1 day before release)
   - Review all features
   - Proofread descriptions
   - Set release date

3. **Publish** (Release day)
   - Click "Publish"
   - Verify front page shows v1.0.14
   - Check v1.0.13 moved to archive

4. **Announce** (After publish)
   - Share changelog URL with team
   - Send release notes email
   - Update documentation

---

## 📞 Support

For questions or issues:
- Check this guide first
- Review ACF documentation: https://www.advancedcustomfields.com/resources/
- Contact your development team

---

**Last Updated**: January 10, 2026  
**Theme Version**: 1.0.0  
**Compatible with**: WordPress 6.0+, ACF 6.0+
