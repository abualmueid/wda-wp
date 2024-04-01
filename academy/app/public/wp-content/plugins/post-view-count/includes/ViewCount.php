<?php 

namespace PostViewCount;
 
class ViewCount {
    public function __construct() {
       // action to count view
       add_action( 'wp_head', array( $this, 'count_view' ) );

       // add view count column
       add_filter( 'manage_posts_columns', array( $this, 'add_view_count_column' ) );

       // add view count column data
       add_action( 'manage_posts_custom_column', array( $this, 'add_view_count_column_data' ), 10, 2 ); 

       // add sortable column
       add_filter( 'manage_edit-post_sortable_columns', array( $this, 'add_view_count_sortable_column' ) );
    }

    public function add_view_count_column( $columns ) {
        $columns['view_count'] = 'View Count';

        return $columns;
    }

    public function add_view_count_column_data( $column, $post_id ) {
        if ( $column == 'view_count' ) {
            echo esc_html( get_post_meta( $post_id, 'view_count', true ) );
        }
    }

    public function count_view() {
        if ( is_single() ) {
            $view_count = get_post_meta( get_the_ID(), 'view_count', true );
            $view_count = $view_count ? $view_count : 0;
            $view_count++;

            update_post_meta( get_the_ID(), 'view_count', $view_count );
        }
    }

    public function add_view_count_sortable_column( $columns ) {
        $columns['view_count'] = 'View Count';

        return $columns;
    }
}