<?php 

/**
 * Plugin Name: Custom Post Metabox
 * Plugin URI: https://google.com
 * Description: This is a plugin for managing custom post metaboxes for each post type
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 */ 

if ( ! class_exists( 'Custom_Post_Metabox' ) ) {
    class Custom_Post_Metabox {
        public function __construct() {
            add_action( 'init', array( $this, 'init' ) );
        }

        public function init() {
            add_action( 'add_meta_boxes', array( $this, 'add' ) );
            add_action( 'save_post', array( $this, 'save' ) );

            // require_once plugin_dir_path( __FILE__ ) . 'metabox-io.php';
            // new Metabox_IO();
        }

        // add method to add the metabox
        public function add() {
            add_meta_box(
                'wedevs_academy', // metabox id
                'weDevs Academy', // title
                array( $this, 'show' ), // callback to add metabox fields
                'course' // Post type(s) where the metabox should appear
            );
        }

        // html content to show in the metabox
        public function show() {
            $instructor_name = esc_html( get_post_meta( get_the_ID(), 'instructor_name', true ) );
            $course_type = esc_html( get_post_meta( get_the_ID(), 'course_type', true ) );
            wp_nonce_field( 'course_meta', 'course_meta_nonce' );
            
            ?>
            <label for="instructor_name">Instructor Name</label>
            <input type="text" name="instructor_name" id="instructor_name" value="<?php echo esc_attr( $instructor_name ); ?>">
            <br>
            <?php echo $instructor_name; ?>
            <br>
            <label for="course_type">Course Type</label><br>
            <label><input type="radio" name="course_type" value="online" <?php checked( $course_type, 'online' ); ?>>Online</label><br>
            <label><input type="radio" name="course_type" value="offline" <?php checked( $course_type, 'offline' ); ?>>Offline</label><br>
            <?php
            
            // echo 'hello world';
        }

        // save method to save the post meta
        public function save( $post_id ) {
            // checking nonce exists or not 

            if ( ! isset( $_POST[ 'course_meta_nonce' ] ) || 
                 ! wp_verify_nonce( $_POST[ 'course_meta_nonce' ], 'course_meta' ) ) {
                return;
            } 

            // checking user permission
            if ( ! current_user_can( 'edit_posts' ) ) {
                return;
            }

            $instructor_name = sanitize_text_field( $_POST[ 'instructor_name' ] );
            update_post_meta( $post_id, 'instructor_name', $instructor_name );

            $course_type = sanitize_text_field( $_POST[ 'course_type' ] );
            if ( in_array( $course_type, array( 'online', 'offline' ) ) ) {
                update_post_meta( $post_id, 'course_type', $course_type );
            }
        }
    }

    new Custom_Post_Metabox();
}