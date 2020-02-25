<?php
/**
 * Inner banner options in customizer
 *
 * @return void
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress Theme
 */

function gutenbiz_inner_banner_options(){ 
	Gutenbiz_Customizer::set(array(
		# Theme Option > color options
		'section' => array(
		    'id'       => 'header_image',
		    'priority' => 27,
		    'prefix' => false,
		),
		'fields'  => array(
			array(
				'id'      	  => 'ib-blog-title',
				'label'   	  => esc_html__( 'Title' , 'gutenbiz' ),
				'description' => esc_html__( 'It is displayed when home page is latest posts.' , 'gutenbiz' ),
				'default' 	  => esc_html__( 'Latest Blog' , 'gutenbiz' ),
				'type'	  	  => 'text',
				'priority'    => 10,
			),
		    array(
		        'id'	  	  => 'ib-title-size',
		        'label'   	  => esc_html__( 'Font Size', 'gutenbiz' ),
		        'description' => esc_html__( 'The value is in px. Defaults to 40px.' , 'gutenbiz' ),
		        'default' => array(
		    		'desktop' => 40,
		    		'tablet'  => 32,
		    		'mobile'  => 32,
		    	),
				'input_attrs' =>  array(
		            'min'   => 1,
		            'max'   => 60,
		            'step'  => 1,
		        ),
		        'type' => 'slider',
		        'priority' => 20
		    ),
		    array(
		        'id'      => 'ib-title-color',
		        'label'   => esc_html__( 'Text Color' , 'gutenbiz' ),
		        'type'    => 'color-picker',
		        'priority' => 30
		    ),
		    array(
		    	'id' 	   => 'ib-background-color',
		    	'label'    => esc_html__( 'Overlay Color', 'gutenbiz' ),
		    	'default'  => '',
		    	'type' 	   => 'color-picker',
		    	'priority' => 40,
		    ),
		    array(
		        'id'      => 'ib-text-align',
		        'label'   => esc_html__( 'Alignment' , 'gutenbiz' ),
		        'type'    => 'buttonset',
		        'default' => 'banner-content-center',
		        'choices' => array(
		        	'banner-content-left'   => esc_html__( 'Left' , 'gutenbiz'   ),
		        	'banner-content-center' => esc_html__( 'Center' , 'gutenbiz' ),
		        	'banner-content-right'  => esc_html__( 'Right' , 'gutenbiz'  ),
		         ),
		        'priority' => 50
		    ),
			array(
			    'id'      => 'ib-image-attachment', 
			    'label'   => esc_html__( 'Image Attachment' , 'gutenbiz' ),
			    'type'    => 'buttonset',
			    'default' => 'banner-background-scroll',
			    'choices' => array(
			    	'banner-background-scroll'           => esc_html__( 'Scroll' , 'gutenbiz' ),
			    	'banner-background-attachment-fixed' => esc_html__( 'Fixed' , 'gutenbiz' ),
			    ),
		        'priority' => 60
			),
			array(
			    'id'      	=> 'ib-height',
			    'label'   	=> esc_html__( 'Height (px)', 'gutenbiz' ),
			    'type'    	=> 'slider',
	            'description' => esc_html__( 'The value is in px. Defaults to 420px.' , 'gutenbiz' ),
	            'default' => array(
	        		'desktop' => 420,
	        		'tablet'  => 420,
	        		'mobile'  => 420,
	        	),
	    		'input_attrs' =>  array(
	                'min'   => 1,
	                'max'   => 1000,
	                'step'  => 1,
	            ),
			),
		    'priority' => 70

		),
	) );
}
add_action( 'init', 'gutenbiz_inner_banner_options' );