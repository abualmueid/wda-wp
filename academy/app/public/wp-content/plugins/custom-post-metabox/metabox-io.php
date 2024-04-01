<?php 

class Metabox_IO {
    public function __construct() {
        add_filter( 'rwmb_meta_boxes', array( $this, 'add' ) );
    }

    public function add( $meta_boxes ) {
        $meta_boxes[] = [
            'title'      => esc_html__( 'weDevs Academy', 'online-generator' ),
            'id'         => 'choose_instructor',
            'post_types' => 'course',
            'fields'     => [
                [
                    'type'       => 'radio',
                    'name'       => esc_html__( 'Choose Instructor', 'online-generator' ),
                    'id'         => 'choose_instructor',
                    'options'    => [
                        'mueid'  => esc_html__( 'Mueid', 'online-generator' ),
                        'rayhan' => esc_html__( 'Rayhan', 'online-generator' ),
                        'tareq'  => esc_html__( 'Tareq', 'online-generator' ),
                    ],
                    'std'        => 'Zonayed',
                ],
            ],
        ];
    
        return $meta_boxes;
    }
}

