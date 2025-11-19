=== FM: Meta Data Manager for Post ===
Contributors: fmthecoder
Tags: meta editor, meta manager, edit meta, delete meta, post metadata
Requires at least: 5.8
Tested up to: 6.8
Stable tag: 1.0.1
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Manage and edit post meta data directly from the post edit screen — view, add, update, or delete meta fields instantly using AJAX without page reload.

== Description ==

**FM: Meta Data Manager for Post** gives developers and power users a fast, interactive way to manage post meta directly from the post edit screen.

- Instantly view all meta keys and values for any post, page, or custom post type.
- Edit, add, or delete meta values with a single click — no need for phpMyAdmin or custom code.
- Fully AJAX-powered interface for real-time updates without page reload.
- Works seamlessly with all post types.
- Lightweight, developer-friendly, and beautifully integrated into the WordPress admin.

Perfect for debugging, inspecting, or cleaning up post meta data.

> **Note:** This plugin is an independent open-source project created and maintained by the developer.  
> It is **not affiliated with, endorsed by, or dependent on any company or organization**.

== ⚠️ Warning / Disclaimer ==

Editing or deleting post meta directly can affect how your theme or plugins function.  
Before making any changes, **create a full database backup**.  
The developer is **not responsible for any data loss or site malfunction** caused by incorrect meta edits, additions, or deletions.

This tool is intended primarily for developers and advanced WordPress users who understand how post meta works.

== Features ==

* View all post meta data in a clean, sortable table.
* Add new meta keys and values directly.
* Edit existing meta values instantly with AJAX.
* Delete unused or old meta entries with one click.
* Real-time success and error messages (no page refresh).
* Works with posts, pages, and all custom post types.
* Clean and lightweight — loads only on post edit screens.
* Built with security in mind using WordPress nonces.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/fm-meta-data-manager-for-post` directory, or install it through the WordPress **Plugins** screen directly.
2. Activate the plugin through the **Plugins** menu in WordPress.
3. Edit any post, page, or custom post — you’ll see a **Meta Data Manager** box showing all meta fields.
4. You can now view, edit, delete, or add new meta data instantly.

== Screenshots ==

1. Meta Data Manager displaying all post meta in a clean table.
2. Inline editing of meta values with AJAX updates.
3. Adding new meta fields dynamically.
4. Deleting meta entries instantly with success notifications.

== Frequently Asked Questions ==

= Does it support custom post types? =
Yes, it supports all registered post types automatically.

= Can I add new meta keys and values? =
Yes! The plugin includes an “Add New Meta” section where you can add new key-value pairs instantly.

= Can I edit multiple meta keys with the same name? =
Yes, it displays all instances of each meta key and lets you edit or delete them individually.

= Is it safe to edit meta values directly? =
Yes, but be cautious — changing certain meta fields may affect plugin or theme functionality.

= Does it support user meta or term meta? =
Currently, it supports only post meta. Future updates may include user and term meta management.

== Changelog ==

= 1.0.1 =
Fixed the issues suggested by WP Team!

= 1.0.0 =
* Initial release.
* View, edit, delete, and add post meta directly.
* AJAX-powered updates and deletions.
* Instant success/error messages with no page reload.
* Works across all post types.

== Upgrade Notice ==

= 1.0.1 =
Fixed the issues suggested by WP Team!

= 1.0.0 =
First release — manage your post meta easily and instantly!

== License ==

This plugin is licensed under the GPLv2 or later.  
You can freely modify and redistribute it under the same license.
