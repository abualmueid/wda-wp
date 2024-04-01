# 'Post View Count' WordPress Plugin

This plugin will record the number of views a post has received. It will not only display the view count for each post in the admin post list using a custom column named 'View Count' but also provide a shortcode that accepts a post ID and returns the view count for the post with this ID.

## Installation

1. Download the plugin folder named `post-view-count`.
2. Upload the `post-view-count` folder to the `wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin through the WordPress admin dashboard.

## Usage

Once the plugin is activated, it will start recording the number of views for each post automatically. You can view the total view count for each post in the admin post list screen. The view count column is sortable, allowing you to sort posts based on their view count.

To display the view count for a specific post in your content or template, use the `[view_count]` shortcode with the post ID as an attribute. For example: 

`[view_count id="123"]`. Replace `123` with the ID of the post for which you want to display the view count. You can also see the shortcode with post id in the post admin list. Just copy and paste it in your post content.


## Features

### Basic

- Automatically records the number of views for each post.
- Adds a custom admin column to display the view count for each post in the WordPress dashboard.
- Allows sorting of posts by view count in the admin post list.
- Provides a shortcode to display the view count for individual posts in post content or custom templates.

### Extra

- Provides a custom admin column to show the exact shortcode with post id which needs to be added in the post content.
- Provides custom CSS styling along with media query support to make the outlook of the post view count better.

## Development

The **Post View Count** plugin is developed following WordPress best practices and guidelines. It uses post meta to store the view count for each post and hooks into WordPress actions and filters to implement its functionality.

To contribute to the development of this plugin or report issues, please visit the [GitHub repository](https://github.com/abualmueid/post-view-count).

## License

This plugin is released under the [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html) license. You are free to modify and distribute it according to the terms of the license.

---

If you have any questions, suggestions, or need support, feel free to contact us at support@abualmueid.me. We hope you find the **Post View Count** plugin useful for tracking the popularity of your WordPress posts!