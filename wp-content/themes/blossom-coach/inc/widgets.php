<?php
/**
 * Blossom Coach Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Blossom_Coach
 */

function blossom_coach_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'blossom-coach' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'blossom-coach' ),
        ),
        'client'   => array(
            'name'        => __( 'Client Section', 'blossom-coach' ),
            'id'          => 'client', 
            'description' => __( 'Add "Blossom: Client Logo" widget for client section.', 'blossom-coach' ),
        ),
        'about'   => array(
            'name'        => __( 'About Section', 'blossom-coach' ),
            'id'          => 'about', 
            'description' => __( 'Add "Blossom: Featured Page" widget for about section.', 'blossom-coach' ),
        ),
        'cta' => array(
            'name'        => __( 'Call To Action Section', 'blossom-coach' ),
            'id'          => 'cta', 
            'description' => __( 'Add "Blossom: Call To Action" widget for call to action section.', 'blossom-coach' ),
        ),
        'testimonial' => array(
            'name'        => __( 'Testimonial Section', 'blossom-coach' ),
            'id'          => 'testimonial', 
            'description' => __( 'Add "Blossom: Testimonial" widget for testimonial section.', 'blossom-coach' ),
        ),
        'service' => array(
            'name'        => __( 'Service Section', 'blossom-coach' ),
            'id'          => 'service', 
            'description' => __( 'Add "Blossom: Icon Text" widget for service section.', 'blossom-coach' ),
        ),
        'simple-cta' => array(
            'name'        => __( 'Simple Call To Action Section', 'blossom-coach' ),
            'id'          => 'simple-cta', 
            'description' => __( 'Add "Blossom: Call To Action" widget for simple call to action section.', 'blossom-coach' ),
        ),
        'contact' => array(
            'name'        => __( 'Contact Section', 'blossom-coach' ),
            'id'          => 'contact', 
            'description' => __( 'Add "Blossom: Contact" widget & "Text" widget for Contact section.', 'blossom-coach' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'blossom-coach' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'blossom-coach' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'blossom-coach' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'blossom-coach' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'blossom-coach' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'blossom-coach' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'blossom-coach' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'blossom-coach' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name"><span>',
    		'after_title'   => '</span></h2>',
    	) );
    }
}
add_action( 'widgets_init', 'blossom_coach_widgets_init' );