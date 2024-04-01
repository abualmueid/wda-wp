<?php
/**
 * Plugin Name: Our First Plugin
 * Description: This is our first plugin
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 * Plugin URI: https://google.com
 */

echo 'hello world';

add_filter( 'the_content', 'ofp_change_content' );
add_filter( 'the_title', 'ofp_change_title' );
add_filter( 'excerpt_length', 'ofp_change_excerpt_length' );
add_action( 'wp_footer', 'ofp_add_footer_content' );

function ofp_change_content( $content ) {
    if( ! is_page() ) {
        return $content;
    }

    $id = get_the_ID();
    // $content = 'This is my content';
    $custom_content = '<div style="border: 3px solid red; padding: 10px" >';
    $custom_content .= '<p>This is custom content added under the post</p>';
    $custom_content .= '<p>Post ID: ' . $id . '</p>';
    $custom_content .= '</div>';
    
    $content .= $custom_content;

    return $content;
}

function ofp_change_title( $title ) {
    if ( is_admin( ) )
        return $title;

    $title = 'This is my title!';

    return $title;
}

function ofp_change_excerpt_length( $number ) {
    return 20;
}

function ofp_add_footer_content() {
    echo "<script>alert('Footer Content added!')</script>";
}

