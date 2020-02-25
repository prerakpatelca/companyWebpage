<?php
/**
 * Blossom Coach Customizer Partials
 *
 * @package Blossom_Coach
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function blossom_coach_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function blossom_coach_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

if( ! function_exists( 'blossom_coach_get_phone' ) ) :
/**
 * Display header phone
*/
function blossom_coach_get_phone(){
    return esc_html( get_theme_mod( 'phone' ) );    
}
endif;

if( ! function_exists( 'blossom_coach_get_email' ) ) :
/**
 * Display header email
*/
function blossom_coach_get_email(){
    return esc_html( get_theme_mod( 'email' ) );    
}
endif;

if( ! function_exists( 'blossom_coach_get_blog_title' ) ) :
/**
 * Display blog section title
*/
function blossom_coach_get_blog_title(){
    return esc_html( get_theme_mod( 'blog_section_title', __( 'Latest Articles', 'blossom-coach' ) ) );    
}
endif;

if( ! function_exists( 'blossom_coach_get_blog_section_read_more' ) ) :
/**
 * Display blog section readmore button
*/
function blossom_coach_get_blog_section_read_more(){
    return esc_html( get_theme_mod( 'blog_readmore', __( 'Read More', 'blossom-coach' ) ) );    
}
endif;

if( ! function_exists( 'blossom_coach_get_blog_section_view_all_btn' ) ) :
/**
 * Display blog section viewall button
*/
function blossom_coach_get_blog_section_view_all_btn(){
    return esc_html( get_theme_mod( 'blog_view_all', __( 'See More Posts', 'blossom-coach' ) ) );
}
endif;

if( ! function_exists( 'blossom_coach_get_read_more' ) ) :
/**
 * Display blog readmore button
*/
function blossom_coach_get_read_more(){
    return esc_html( get_theme_mod( 'read_more_text', __( 'Continue Reading', 'blossom-coach' ) ) );    
}
endif;

if( ! function_exists( 'blossom_coach_get_related_title' ) ) :
/**
 * Display blog readmore button
*/
function blossom_coach_get_related_title(){
    return get_theme_mod( 'related_post_title', __( 'You may also like...', 'blossom-coach' ) );
}
endif;

if( ! function_exists( 'blossom_coach_get_footer_copyright' ) ) :
/**
 * Footer Copyright
*/
function blossom_coach_get_footer_copyright(){
    $copyright = get_theme_mod( 'footer_copyright' );
    echo '<span>';
    if( $copyright ){
        echo wp_kses_post( $copyright );
    }else{
        esc_html_e( '&copy; Copyright ', 'blossom-coach' );
        echo date_i18n( esc_html__( 'Y', 'blossom-coach' ) );
        echo ' <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>. ';
        esc_html_e( 'All Rights Reserved. ', 'blossom-coach' );
    }
    echo '</span>'; 
}
endif;