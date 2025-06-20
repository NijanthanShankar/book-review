=== Book Reviews Manager ===
Contributors: Nijanthan Shankar
Tags: books, reviews, ratings, shortcode, custom post type
Requires at least: 5.6
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple yet elegant WordPress plugin that allows you to create, manage, and display book reviews on your website with a modern card layout and star rating system.

== Description ==

**Book Reviews Manager** is a powerful and user-friendly plugin designed to help you create and showcase book reviews on your WordPress website. Whether you're running a book blog, library website, or literary magazine, this plugin provides all the tools you need to present professional-looking book reviews.

= Key Features =

* **Custom Post Type**: Dedicated book review post type for organized content management
* **Star Rating System**: Visual 5-star rating display for quick review assessment
* **Shortcode Support**: Display reviews anywhere on your site using simple shortcodes
* **Responsive Design**: Modern card-based layout that looks great on all devices
* **Customizable Display**: Control number of columns and review limits
* **Clean Interface**: Intuitive admin interface for easy review management
* **Translation Ready**: Full localization support for multilingual websites

= Perfect For =

* Book bloggers and reviewers
* Library websites
* Literary magazines
* Educational institutions
* Book clubs and reading communities

= Shortcode Usage =

Display all reviews:
`[book_reviews]`

Customize display with columns and limits:
`[book_reviews columns="3" limit="6"]`

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin dashboard
2. Navigate to Plugins → Add New
3. Search for "Book Reviews Manager"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Upload the plugin folder to `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Start adding book reviews through the new "Book Reviews" menu item

== Frequently Asked Questions ==

= How do I add a new book review? =

After activation, you'll see "Book Reviews" in your WordPress admin menu. Click "Add New" to create your first review. Fill in the book title, author, rating (1-5 stars), and your review content.

= Can I display reviews on any page or post? =

Yes! Use the `[book_reviews]` shortcode anywhere you want to display your reviews. You can customize the display using parameters like `columns` and `limit`.

= Is the plugin responsive? =

Absolutely! The plugin includes responsive CSS that ensures your book reviews look great on desktop, tablet, and mobile devices.

= Can I customize the appearance? =

Yes, the plugin is designed with customization in mind. You can override the default styles in your theme's CSS file or create a custom stylesheet.

= Does it work with page builders? =

Yes, the shortcode works with popular page builders like Elementor, Gutenberg, and others that support WordPress shortcodes.

== Screenshots ==

1. Book Reviews admin interface - easy review management
2. Single book review display with star ratings
3. Grid layout showing multiple reviews
4. Mobile responsive design
5. Shortcode integration in posts/pages

== Changelog ==

= 1.0.0 =
* Initial release
* Custom post type for book reviews
* Star rating system
* Shortcode functionality
* Responsive grid layout
* Translation ready
* Admin interface for review management

== Upgrade Notice ==

= 1.0.0 =
Initial release of Book Reviews Manager. Install to start managing your book reviews professionally.

== Developer Information ==

= Custom Post Type =
* Post Type: `book_review`
* Supports: title, editor, excerpt, thumbnail

= Meta Fields =
* Book Name
* Author
* Rating (1-5 scale)
* Reviewer

= Hooks and Filters =
The plugin provides various hooks for developers to extend functionality. Check the documentation for a complete list.

= Template Override =
You can override plugin templates by copying them to your theme's `book-reviews/` directory.

== Support ==

For support, feature requests, or bug reports, please visit our support forum or contact us through the plugin's official page.

== Credits ==

This plugin was developed with accessibility and user experience in mind.