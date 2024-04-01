<?php 

/**
 * Plugin Name: Custom Post
 * Plugin URI: https://google.com
 * Description: This is a plugin for managing custom posts in the screen area
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 */ 

if ( ! class_exists( 'Custom_Post' ) ) {
    class Custom_Post {
        public function __construct() {
            add_action( 'init', array( $this, 'init' ) );
        }

        public function init() {
            $this->register_book_cpt();
            $this->register_genre_taxonomy();

            add_action( 'admin_menu', array( $this, 'add_chapters_submenu_under_books' ) );
        }

        // Add submenu page for 'Chapters' under 'Books'
        public function add_chapters_submenu_under_books() {
            add_submenu_page(
                'edit.php?post_type=book', // Parent slug
                'Chapters',                 // Page title
                'Chapters',                 // Menu title
                'manage_options',           // Capability
                'edit.php?post_type=chapter' // Menu slug
            );
        }

        public function register_genre_taxonomy() {
            register_taxonomy( 'genre', 'book', [
                'label'         => __( 'Genre' ),
                'hierarchical'  => true,
                // 'rewrite'       => [
                //     'slug' => 'genre' 
                // ]
            ] );
        }

        public function register_book_cpt() {
            
            /**
             * Post Type: Books.
             */
        
            $labels = [
                "name" => esc_html__( "Books", "twentytwentyfour" ),
                "singular_name" => esc_html__( "Book", "twentytwentyfour" ),
                "add_new" => esc_html__( "Add New Kitab", "twentytwentyfour" ),
            ];
        
            $args = [
                "label" => esc_html__( "Books", "twentytwentyfour" ),
                "labels" => $labels,
                "description" => "",
                "public" => false,
                "publicly_queryable" => true,
                "show_ui" => true,
                "show_in_rest" => true,
                "rest_base" => "",
                "rest_controller_class" => "WP_REST_Posts_Controller",
                "rest_namespace" => "wp/v2",
                "has_archive" => "chapters",
                "show_in_menu" => true,
                "show_in_nav_menus" => true,
                "delete_with_user" => false,
                "exclude_from_search" => false,
                "capability_type" => "post",
                "map_meta_cap" => true,
                "hierarchical" => false,
                "can_export" => false,
                "rewrite" => [ "slug" => "book", "with_front" => true ],
                "query_var" => true,
                "supports" => [ "title", "editor", "thumbnail" ],
                "show_in_graphql" => false,
            ];
        
            register_post_type( "book", $args );
        }
    }

    new Custom_Post();
}

