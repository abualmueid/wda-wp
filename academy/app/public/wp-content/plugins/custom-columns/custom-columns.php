<?php 
/**
 * Plugin Name: Custom Columns
 * Plugin URI: https://google.com
 * Description: This is a plugin for managing custom columns in the screen area
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 */

class Custom_Columns {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
    }

    public function init() {
        // For Posts

        add_filter( 'manage_posts_columns', [ $this, 'increase_posts_columns' ] );
        add_action( 'manage_posts_custom_column', [ $this, 'change_posts_custom_column_data' ], 10, 2 );

        add_filter( 'manage_posts_columns', [ $this, 'add_id_column' ] );
        add_action( 'manage_posts_custom_column', [ $this, 'add_id_column_data'], 10, 2 );

        add_filter( 'manage_edit-post_sortable_columns', [ $this, 'add_sortable_column' ] );

        // For pages

        add_filter( 'manage_pages_columns', [ $this, 'increase_posts_columns' ] );
        add_action( 'manage_pages_custom_column', [ $this, 'change_posts_custom_column_data' ], 10, 2 );

        add_filter( 'manage_pages_columns', [ $this, 'add_id_column' ] );
        add_action( 'manage_pages_custom_column', [ $this, 'add_id_column_data'], 10, 2 );

        add_filter( 'manage_edit-page_sortable_columns', [ $this, 'add_sortable_column' ] );

        // For view count

        add_filter( 'manage_posts_columns', array( $this, 'add_view_count_column' ) );
        add_action( 'manage_posts_custom_column', array( $this, 'add_view_count_column_data' ), 10, 2 );
        
        // For count view
        add_action( 'wp_head', array( $this, 'count_view' ) );

        // display view count in post content
        // add_filter( 'the_content', array( $this, 'display_view_count' ) );

        // user registration column
        add_filter( 'manage_users_columns', array( $this, 'add_user_reg_column' ) );
        add_action( 'manage_users_custom_column', array( $this, 'user_reg_column_data' ), 10, 3 );
    }

    // just adding thumbnail column in the columns array
    // public function change_posts_columns( $columns ) {
    //     $columns['thumbnail'] = 'Thumbnail';
    //     error_log( print_r( $columns, true ) );

    //     return $columns;
    // }

    public function increase_posts_columns( $columns ) {
        // adding thumbnail column just after the title column

        $new_columns = [];

        foreach ( $columns as $key => $value ) {
            if ( $key == 'title' ) {
                $new_columns['title'] = $value;
                $new_columns['thumbnail'] = 'Thumbnail';
            } else {
                $new_columns[$key] = $value;
            }
        }

        error_log( print_r( $new_columns, true ) );

        return $new_columns;
    }

    public function change_posts_custom_column_data( $column, $post_id ) {
        if ( $column == 'thumbnail' ) {
            if ( has_post_thumbnail( $post_id ) ) {
                // echo 'has thumbnail';
                echo get_the_post_thumbnail( $post_id, [50, 50] );
                
            }
        }

        // if ( $column == 'id' ) {
        //     echo $post_id;
        // }
    }

    public function add_id_column( $columns ) {
        // Adding id column before the title column

        $new_columns = [];

        foreach ( $columns as $key => $value ) {
            if ( $key == 'cb' ) {
                $new_columns['cb'] = $value;
                $new_columns['id'] = 'ID';
            } else {
                $new_columns[$key] = $value;
            }
        }

        error_log( print_r( $new_columns, true ) );

        return $new_columns;
    }

    public function add_id_column_data( $column, $post_id ) {
        if ( $column == 'id' ) {
            echo $post_id;
        }
    }

    public function add_sortable_column( $columns ) {
        $columns['id'] = 'ID';
        $columns['view_count'] = 'View Count';

        error_log( print_r( $columns, true ) );

        return $columns;
    }

    public function add_view_count_column( $columns ) {
        $columns['view_count'] = 'View Count';

        return $columns;
    }

    public function add_view_count_column_data( $column, $post_id ) {
        if( $column == 'view_count' ) {
            // update_post_meta( get_the_ID(), 'view_count', 0 );
            echo get_post_meta( $post_id, 'view_count', true );
        }   
    }

    public function count_view() {
        if ( is_single() ) {
            // delete_post_meta( get_the_ID(), 'view_count' );
            $view_count = get_post_meta( get_the_ID(), 'view_count', true );
            $view_count = $view_count ? $view_count : 0; 
            $view_count++;
            
            update_post_meta( get_the_ID(), 'view_count', $view_count );
        }
    }

    public function add_user_reg_column( $columns ) {
        $columns['user_registered'] = 'Registered Date';

        return $columns;
    }

    public function user_reg_column_data( $value, $column, $user_id ) {
        if ( $column == 'user_registered' ) {
            $user = get_user_by( 'id', $user_id );
            $date = $user->user_registered;
            return $date;

            // error_log( print_r( $user, true ) );
        }
    }
    /*
    public function display_view_count( $content ) {
        if ( is_single() ) {
            $view_count = get_post_meta( get_the_ID(), 'view_count', true );
            $view_count = $view_count ? $view_count : 0; 
            $view_count++;
            
            $custom_content = '<div style="border: 3px solid orange; padding: 10px;">';
            $custom_content .= '<p>Post ID: ' . get_the_ID()  . '</p>';
            $custom_content .= '<p>View Count: ' . $view_count++  . '</p>';
            $custom_content .= '</div>';
            $content .= $custom_content;

            update_post_meta( get_the_ID(), 'view_count', $view_count );
        }

        return $content;
    }
    */
}

new Custom_Columns();

