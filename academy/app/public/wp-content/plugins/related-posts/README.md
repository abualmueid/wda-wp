# 'Related Posts' WordPress Plugin

The 'Related Posts' plugin enhances user engagement by displaying related posts under the content of each post. It aims to improve navigation within the website by offering readers additional relevant content based on the current post’s category.

## Installation

1. Download the plugin folder named `related-posts`.
2. Upload the `related-posts` folder to the `wp-content/plugins/` directory of your WordPress installation.
3. Activate the plugin through the WordPress admin dashboard.

## Usage

Once the plugin is activated, related posts will automatically be displayed under each post based on categories.

## Features

### Basic

- Retrieves the current post’s category.
- Queries and retrieves other posts that belong to the same category or categories.
- Shuffles the list of related posts.
- Displays a maximum of 5 related posts with a small thumbnail image under the current post.
- Ensures proper escaping when displaying post titles, content, and thumbnail images.

### Extra

- There is a custom hook named `rp_posts_per_page` through which users can change the number of related posts per page they want to see under each post.
- `related-posts.css` has been added to make the outlook of the related posts better and also it will make the view responsive for different screen sizes by the help of media query. 