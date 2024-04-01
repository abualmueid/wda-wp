<?php

/**
 * Plugin Name: Our Second Plugin
 * Description: This is our second plugin
 * Version: 1.1.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 * Plugin URI: https://google.com 
 */

if( ! class_exists( 'Our_Second_Plugin' ) ) {
    class Our_Second_Plugin {
        public function __construct() {
            add_action( 'init',  array( $this, 'init') );
        }

        public function init() {
            add_filter( 'the_content', array( $this, 'change_content' ) );
            add_filter( 'the_title', array( $this, 'change_title' ) );
        }

        function change_content( $content ): mixed {
            if( is_page() ) {
                return $content;
            }
        
            $id = get_the_ID();
            // $content = 'This is my content';
            $custom_content = '<div style="border: 3px solid red; padding: 10px" >';
            $custom_content .= '<p>This is custom content added under the post using Class!</p>';
            $custom_content .= '<p>Post ID: ' . $id . '</p>';
            $custom_content .= '</div>';
            
            $content .= $custom_content;
        
            return $content;
        }
        
        function change_title( $title ) {
            if( is_admin(  ) ) 
                return $title;

            $title = 'This is my 2nd title using Class!';

            return $title;
        }
    }

    new Our_Second_Plugin();
}

