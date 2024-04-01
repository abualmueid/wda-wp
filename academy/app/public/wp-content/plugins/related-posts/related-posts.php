<?php 

/**
 * Plugin Name: Related Posts
 * Description: This plugin will enhance user engagement by displaying related posts under the content of each post
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 * Plugin URI: https://github.com/abualmueid/wda-wp 
 */

if ( ! class_exists( 'Related_Posts' ) ) {
    class Related_Posts {
        private $posts_per_page = 5;

        public function __construct() {
            add_action( 'init', array( $this, 'init' ) );
        }

        public function init() {
            // filter to change the content of the post
            add_filter( 'the_content', array( $this, 'change_content' ) );

            // action to change the style of the related posts to be displayed
            add_action( 'wp_enqueue_scripts', array( $this, 'related_posts_enqueue_styles' ) );

            // custom hook to extend the plugin features for posts per page
            $this->posts_per_page = apply_filters( 'rp_posts_per_page', $this->posts_per_page );
        }

        public function change_content( $content ) {
            // get the category of the current post
            global $post;
            $categories = get_the_category( $post->ID );

            // storing the term ids
            $category_ids = [];
            foreach ( $categories as $category ) {
                $category_ids[] = $category->term_id;
            }

            // query related posts
            ob_start();

            $args = array( 
                'category__in'   => $category_ids, // match the categories
                'post__not_in'   => array( $post->ID ), // exclude the current post
                'posts_per_page' => $this->posts_per_page, // display maximum 5 related posts
                'orderby'        => 'rand' // shuffle the related posts
             );
            $query = new WP_Query( $args ); 

            // display related posts
            if ( $query->have_posts() ) {
                ?>
                <div class="container">
                    <h3 class="heading">Related Posts</h3>
                    <ul class="list">
                        <?php
                        while ( $query->have_posts() ) {
                            $query->the_post();
                            ?>
                            <li class="list-item">
                                <div class="content">
                                    <?php 
                                    if ( has_post_thumbnail() ) {
                                    ?>
                                        <div class="thumbnail">
                                            <img src="<?php echo esc_url( get_the_post_thumbnail_url( $post->ID, [100, 100] ) ); ?>">
                                        </div>
                                    <?php
                                    }  
                                    ?>
                                        <a class="title" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( get_the_title() ); ?></a>                          
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }

            wp_reset_postdata();

            $content .= ob_get_clean();

            return $content; 
        }

        public function related_posts_enqueue_styles() {
            $plugin_dir = plugin_dir_url( __FILE__ );

            wp_enqueue_style( 'styles', $plugin_dir . 'related-posts.css' );
        }
    }

    new Related_Posts();
}

// custom filter hook to change the number of posts per page
add_filter( 'rp_posts_per_page', 'rp_change_posts_per_page' );

function rp_change_posts_per_page( $number ) {
    return 5;
}
