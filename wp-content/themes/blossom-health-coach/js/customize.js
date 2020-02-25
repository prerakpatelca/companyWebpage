jQuery(document).ready(function($){
    /* Move widgets to their respective sections */
    wp.customize.section( 'sidebar-widgets-service' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-service' ).priority( '15' );
    wp.customize.section( 'sidebar-widgets-about' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-about' ).priority( '20' );
    wp.customize.section( 'sidebar-widgets-cta' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-cta' ).priority( '25' );
    wp.customize.section( 'sidebar-widgets-testimonial' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-testimonial' ).priority( '30' );  
	wp.customize.section( 'sidebar-widgets-client' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-client' ).priority( '35' );     
    wp.customize.section( 'sidebar-widgets-simple-cta' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-simple-cta' ).priority( '45' );
    wp.customize.section( 'sidebar-widgets-contact' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-contact' ).priority( '50' );
});