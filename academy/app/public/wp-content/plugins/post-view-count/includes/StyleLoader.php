<?php 

namespace PostViewCount;

class StyleLoader {
    private $plugin_dir;
    
    public function __construct( $plugin_dir ) { 
        $this->plugin_dir = $plugin_dir;

        // enqueue stylesheet
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_view_count_style' ) );
    }

    public function enqueue_view_count_style() {
        wp_enqueue_style( 'view_count_style', $this->plugin_dir . 'assets/PostViewCount.css' );
    }
}