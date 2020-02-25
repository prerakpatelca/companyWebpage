jQuery(document).ready(function($){
    /* Move widgets to their respective sections */
	wp.customize.section( 'sidebar-widgets-client' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-client' ).priority( '15' );
    wp.customize.section( 'sidebar-widgets-about' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-about' ).priority( '20' );
    wp.customize.section( 'sidebar-widgets-cta' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-cta' ).priority( '25' );
    wp.customize.section( 'sidebar-widgets-testimonial' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-testimonial' ).priority( '30' );    
    wp.customize.section( 'sidebar-widgets-service' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-service' ).priority( '35' );
    wp.customize.section( 'sidebar-widgets-simple-cta' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-simple-cta' ).priority( '45' );
    wp.customize.section( 'sidebar-widgets-contact' ).panel( 'frontpage_settings' );
	wp.customize.section( 'sidebar-widgets-contact' ).priority( '50' );
    
    //Scroll to section
    $('body').on('click', '#sub-accordion-panel-frontpage_settings .control-subsection .accordion-section-title', function(event) {
        var section_id = $(this).parent('.control-subsection').attr('id');
        scrollToSection( section_id );
    });    
});

function scrollToSection( section_id ){
    var preview_section_id = "banner_section";

    var $contents = jQuery('#customize-preview iframe').contents();

    switch ( section_id ){        
        case 'accordion-section-sidebar-widgets-client':
        preview_section_id = "client_section";
        break;
        
        case 'accordion-section-sidebar-widgets-about':
        preview_section_id = "about_section";
        break;
        
        case 'accordion-section-sidebar-widgets-cta':
        preview_section_id = "cta_section";
        break;
        
        case 'accordion-section-sidebar-widgets-testimonial':
        preview_section_id = "testimonial_section";
        break;
        
        case 'accordion-section-sidebar-widgets-service':
        preview_section_id = "service_section";
        break;
        
        case 'accordion-section-blog_section':
        preview_section_id = "blog_section";
        break;
        
        case 'accordion-section-sidebar-widgets-simple-cta':
        preview_section_id = "simple_cta_section";
        break;
        
        case 'accordion-section-sidebar-widgets-contact':
        preview_section_id = "contact_section";
        break;
    }

    if( $contents.find('#'+preview_section_id).length > 0 && $contents.find('.home').length > 0 ){
        $contents.find("html, body").animate({
        scrollTop: $contents.find( "#" + preview_section_id ).offset().top
        }, 1000);
    }
}

( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['pro-section'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

} )( wp.customize );