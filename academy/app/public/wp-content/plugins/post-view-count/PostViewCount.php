<?php 

/**
 * Plugin Name: Post View Count
 * Plugin URI: https://google.com
 * Description: This plugin will record the number of views a post has received. It will not only display the view count for each post in the admin post list using a custom column named 'View Count' but also provide a shortcode that accepts a post ID and returns the view count for the post with this ID.
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 */

require 'vendor/autoload.php';

if ( ! class_exists( 'PostViewCount' ) ) {
    class PostViewCount {
        public function __construct() {
            add_action( 'init', array( $this, 'init' ) );
        }

        public function init() {
            new PostViewCount\ViewCount();
            new PostViewCount\Shortcode();
            new PostViewCount\StyleLoader( plugin_dir_url( __FILE__ ) );
        }
    }

    new PostViewCount();
}