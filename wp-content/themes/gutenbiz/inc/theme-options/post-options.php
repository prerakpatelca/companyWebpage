<?php
/**
 * Create options for posts.
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress theme
 */

function gutenbiz_post_options(){  
    Gutenbiz_Customizer::set(array(
    	# Theme Options
    	'panel'   => 'panel',
    	# Theme Options > Page Options > Settings
    	'section' => array(
    		'id'    => 'post-options',
    		'title' => esc_html__( 'Post Options','gutenbiz' ),
    	),
    	'fields' => array(
            array(
                'id'      => 'post-category',
                'label'   =>  esc_html__( 'Show Categories', 'gutenbiz' ),
                'default' => 1,
                'type'    => 'toggle',
            ),
            array(
                'id'      => 'post-date',
                'label'   => esc_html__( 'Show Date', 'gutenbiz' ),
                'default' => 1,
                'type'    => 'toggle',
            ),
            array(
                'id'      => 'post-author',
                'label'   =>  esc_html__( 'Show Author', 'gutenbiz' ),
                'default' => 1,
                'type'    => 'toggle',
            ),
            array(
                'id'      => 'excerpt_length',
                'label'   => esc_html__( 'Excerpt Length', 'gutenbiz' ),
                'description' => esc_html__( 'Defaults to 10.', 'gutenbiz' ),
                'default' => 10,
                'type'    => 'number',
            ),
     	),
    ) );
}
add_action( 'init', 'gutenbiz_post_options' );