<?php 

namespace PostViewCount;

class Shortcode {
    public function __construct() {
        // register shortcode
        add_shortcode( 'view_count', array( $this, 'view_count_shortcode' ) );

        // add shortcode column
        add_filter( 'manage_posts_columns', array( $this, 'add_shortcode_column' ) );

        // add shortcode column data
        add_action( 'manage_posts_custom_column', array( $this, 'add_shortcode_column_data' ), 10, 2 ); 
    }     

    public function view_count_shortcode( $atts ) { 
        // check if the current user can view post counts
        if ( ! current_user_can( 'manage_options' ) ) {
            return; 
        }

        // get the attributes from the shortcode
        $attributes = shortcode_atts( [
            'id' => get_the_ID()
        ], $atts );
    
        $post_id = intval( $attributes['id'] ); // Sanitize input
        $view_count = get_post_meta( $post_id, 'view_count', true );
        
        // html markup for view count
        $output = '<div class="view-count-container">';
        $output .= '<div class="view-count">';
        $output .= '<h2>Post Views</h2>';
        $output .= '<p>Total Views</p>';
        $output .= '<h1>' . esc_html( $view_count ) . '</h1>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    public function add_shortcode_column( $columns ) {
        $columns['shortcode'] = 'Shortcode';

        return $columns;
    }

    public function add_shortcode_column_data( $column, $post_id ) {
        if ( $column == 'shortcode' ) {
            echo "[view_count id='" . esc_attr( $post_id ) . "']"; // Escape and sanitize output
        }
    }
}