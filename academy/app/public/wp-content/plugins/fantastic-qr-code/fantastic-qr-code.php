<?php 

/**
 * Plugin Name: Fantastic QR Code
 * Description: This qr code will help users to return back to the source where it's located
 * Version: 1.0.0
 * Author: Abu Al Mueid
 * Author URI: https://github.com/abualmueid
 * Plugin URI: https://google.com
 */

 if( ! class_exists( 'Fantastic_Qr_Code' ) ) {
    class Fantastic_Qr_Code {

        private $color = 'ff0000';
        private $size = '150';

        public function __construct() {
            add_action( 'init', array( $this, 'init' ) );
        }

        public function init() {
            // add_filter( 'the_content', array( $this, 'add_qr_code' ), 99 );
            // add_filter( 'the_content', array( $this, 'add_qr_code' ) );

            // $this->color = apply_filters( 'fqc_qr_code_color',  $this->color ); 
            // $this->size = apply_filters( 'fqc_qr_code_size', $this->size );

            // For Query Data

            require_once plugin_dir_path( __FILE__ ) . 'query-data.php';

            new Query_Data();
        }

        public function add_qr_code( $content ) {

            $current_link = esc_url( get_permalink() );
            
            $custom_content = '<div style="border: 3px solid orange; padding: 10px;">';
            $custom_content .= "<img src='https://api.qrserver.com/v1/create-qr-code/?color={$this->color}&data={$current_link}&size={$this->size}x{$this->size}' alt='' title='' />";
            $custom_content .= '<p>Current link: ' . $current_link  . '</p>';
            $custom_content .= '</div>';

            $content .= $custom_content;

            return $content;
        }
    }
 }

 new Fantastic_Qr_Code();