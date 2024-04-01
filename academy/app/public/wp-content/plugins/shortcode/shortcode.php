<?php 

/**
 * Plugin Name: Shortcode
 * Plugin URI: https://google.com
 * Description: This is a plugin for managing shortcode in WordPress Eco System
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 */ 

if ( ! class_exists ( 'Shortcode' ) ) {
    class Shortcode {
        public function __construct() {
            add_action( 'init', array( $this, 'init' ) );
        }

        public function init() {
            // register shortcode to greet
            add_shortcode( 'greet', array( $this, 'greet' ) );

            // register shortcode to greeting
            add_shortcode( 'greetings', array( $this, 'greetings' ) );

            // register shortcode to say hello
            add_shortcode( 'hello', array( $this, 'hello' ) );

            // register shortcode for parent-child
            add_shortcode( 'parent', array( $this, 'parent' ) );
            add_shortcode( 'child', array( $this, 'child' ) );

            // register shortcode for video
            add_shortcode( 'video', array( $this, 'video' ) );

            // register shortcode for xkcd comic
            add_shortcode( 'xkcd', array( $this, 'xkcd' ) );

            // register custom post type called Time
            $this->register_time_cpt();

            // add custom time column for shortcode
            add_filter( 'manage_time_posts_columns',  array( $this, 'add_time_column' ));

            // add custom time column data 
            add_action( 'manage_time_posts_custom_column', array( $this, 'add_time_column_data' ), 10, 2 );

            // add time metabox
            add_action( 'add_meta_boxes', array( $this, 'add_time_meta_box' ) );

            // save time metabox data
            add_action( 'save_post', array( $this, 'save_time_meta_box_data' ) );

            // register shortcode for time cpt
            add_shortcode( 'time', array( $this, 'time_shortcode' ) );
        }

        public function greet() {
            return '<p>Hello World</p>';
        }

        public function greetings( $atts ) {
            $attributes = shortcode_atts( 
                [
                    'name' => 'Mueid Vai',
                    'greeting' => 'Good Afternoon' 
                ], // default values
                $atts
             );

            // return "<p>Good Morning, {$attributes['name']}!</p>";
            return "<p>{$attributes['greeting']}, {$attributes['name']}!</p>";
        }

        public function hello( $atts, $content = null ) {
            $attributes = shortcode_atts(
                [
                    'name' => 'Hasin Vai'
                ], // default values
                $atts
            );
            
            return "<p>Hello, {$attributes['name']}. {$content}!</p>";
        }

        public function parent( $atts, $content = null ) {
            $content = do_shortcode( $content );

            return "<div style='border: 1px solid red; padding: 10px'>This is parent content {$content}</div>";
        }

        public function child( $atts, $content = null ) {
            return "<div style='border: 1px solid green; padding: 10px'>{$content}</div>";
        }

        public function video( $atts ) {
            $attributes = shortcode_atts( [
                'type'   => 'youtube',
                'id'     => '12345',
                'width'  => '500',
                'height' => '400'
            ], $atts );

            $attributes['type'] = sanitize_text_field( $attributes['type'] );
            $attributes['id'] = esc_attr( $attributes['id'] );
            $attributes['width'] = esc_attr( $attributes['width'] );
            $attributes['height'] = esc_attr( $attributes['height'] );

            if ( $attributes['type'] == 'youtube' ) {
                return "<p><iframe width='{$attributes['width']}' height='{$attributes['height']}' src='https://www.youtube.com/embed/ZS8NmARBnPM?si=4ykNJY9KLUlvIt_f' frameborder='0'></iframe></p>";
            } elseif ( $attributes['type'] == 'vimeo' ) {
                return "<p><iframe width='{$attributes['width']}' height='{$attributes['height']}' src='https://player.vimeo.com/video/{$attributes['id']}' frameborder='0'></iframe></p>"; 
            } else {
                return '<p>Invalid Video Type</p>';
            }
        }

        public function xkcd( $atts ) {
            $attributes = shortcode_atts( [
                'comic' => '936'
            ], $atts );

            $response = wp_remote_get( "https://xkcd.com/{$attributes['comic']}/info.0.json" );
            $body = wp_remote_retrieve_body( $response );
            $data = json_decode( $body, true );

            $image = esc_url( $data['img'] );
            $title = esc_attr( $data['title'] );
            $alt = esc_attr( $data['alt'] );

            return "<p><img src='{$image}' title='{$title}' alt='{$alt}'></p>";
        }

        public function register_time_cpt() {
            $labels = [
                "name" => esc_html__( "Time", "twentytwentyfour" ),
                "singular_name" => esc_html__( "Time", "twentytwentyfour" ),
                "add_new" => esc_html__( "Add New Time", "twentytwentyfour" ),
            ];

            $args = [
                "label" => esc_html__( "Time", "twentytwentyfour" ),
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
                "rewrite" => [ "slug" => "time", "with_front" => true ],
                "query_var" => true,
                "supports" => [ "title", "editor", "thumbnail" ],
                "show_in_graphql" => false,
            ];

            register_post_type( 'time', $args );
        }

        public function add_time_column( $columns ) {
            $columns['shortcode'] = 'Shortcode';
            
            return $columns;
        }

        public function add_time_column_data( $column, $post_id ) {
            if ( $column == 'shortcode' ) {
                echo "[time id='{$post_id}']";
            }
        }

        public function add_time_meta_box() {
            add_meta_box(
                'time', // metabox id
                'Time', // title
                array( $this, 'show_time_meta_box' ), // callback to add metabox fields
                'time' // Post type(s) where the metabox should appear
            );
        }

        public function show_time_meta_box( $post ) {
            wp_nonce_field( 'time_meta_box', 'time_meta_box_nonce' );

            // Retrieve existing values for fields
            $my_timezone = get_post_meta($post->ID, 'timezone', true);
            $country = get_post_meta($post->ID, 'country', true);
            $city = get_post_meta($post->ID, 'city', true);
            ?>
            <p>
                <label for="timezone">Timezone:</label>
                <select name="timezone" id="timezone">
                    <option value="GMT">GMT</option>
                    <option value="CET">CET</option>
                    <option value="CEST">CEST</option>
                    <option value="EST">EST</option>
                    <option value="PST">PST</option>
                    <option value="GMT+1">GMT+1</option>
                    <option value="GMT+2">GMT+2</option>
                    <option value="GMT+3">GMT+3</option>
                    <option value="GMT+4">GMT+4</option>
                    <option value="GMT+5">GMT+5</option>
                    <option value="GMT+6">GMT+6</option>

                    <?php 
                    $timezones = timezone_identifiers_list();
                    foreach ($timezones as $timezone) {
                        echo "<option value='{$timezone}' " . selected($timezone, $my_timezone, false) . ">{$timezone}</option>";
                    }
                    ?>
                </select>
            </p>

            <p>
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" value="<?php echo esc_attr( $country ); ?>">
            </p>

            <p>
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo esc_attr( $city ); ?>">
            </p> 
            <?php
        }

        public function save_time_meta_box_data( $post_id ) {
            // Check if nonce is set 
            if ( ! isset( $_POST['time_meta_box_nonce'] ) ) {
                return;
            }

            // verify nonce
            if ( ! wp_verify_nonce( $_POST['time_meta_box_nonce'], 'time_meta_box' ) ) {
                return;
            }

            // check user permission
            if ( ! current_user_can( 'edit_posts' ) ) {
                return;
            }

            // save timezone, country, city metabox data
            
            if ( isset( $_POST['timezone'] ) ) {
                update_post_meta( $post_id, 'timezone', sanitize_text_field( $_POST['timezone'] ) );
            }

            if ( isset( $_POST['country'] ) ) {
                update_post_meta( $post_id, 'country', sanitize_text_field( $_POST['country'] ) );
            }

            if ( isset( $_POST['city'] ) ) {
                update_post_meta( $post_id, 'city', sanitize_text_field( $_POST['city'] ) );
            }
        }

        public function time_shortcode( $atts ) {
            $attributes = shortcode_atts( [
                'id' => ''
            ], $atts                
            );
            
            if ( empty( $attributes['id'] ) ) {
                return '<p>Please provide a valid post id!</p>';
            } else {
                $timezone = esc_attr( get_post_meta( $attributes['id'], 'timezone', true ) );
                $country = esc_attr( get_post_meta( $attributes['id'], 'country', true ) );
                $city = esc_attr( get_post_meta( $attributes['id'], 'city', true ) );

                $time = new DateTime( 'now', new DateTimeZone( $timezone ) );

                return "<p>Time in {$city}, {$country} is {$time->format('Y-m-d H:i:s')}</p>";
            }
        }
    }

    new Shortcode();
}