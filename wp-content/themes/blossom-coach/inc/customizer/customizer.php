<?php
/**
 * Blossom Coach Theme Customizer
 *
 * @package Blossom_Coach
 */

/**
 * Requiring customizer panels & sections
*/
$blossom_coach_panels = array( 'info', 'site', 'appearance', 'layout', 'general', 'frontpage', 'footer' );

foreach( $blossom_coach_panels as $p ){
    require get_template_directory() . '/inc/customizer/' . $p . '.php';
}

/**
 * Sanitization Functions
*/
require get_template_directory() . '/inc/customizer/sanitization-functions.php';

/**
 * Active Callbacks
*/
require get_template_directory() . '/inc/customizer/active-callback.php';

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function blossom_coach_customize_preview_js() {
	wp_enqueue_script( 'blossom-coach-customizer', get_template_directory_uri() . '/inc/js/customizer.js', array( 'customize-preview' ), BLOSSOM_COACH_THEME_VERSION, true );
}
add_action( 'customize_preview_init', 'blossom_coach_customize_preview_js' );

function blossom_coach_customize_script(){
    wp_enqueue_style( 'blossom-coach-customize', get_template_directory_uri() . '/inc/css/customize.css', array(), BLOSSOM_COACH_THEME_VERSION );
    wp_enqueue_script( 'blossom-coach-customize', get_template_directory_uri() . '/inc/js/customize.js', array( 'jquery', 'customize-controls' ), BLOSSOM_COACH_THEME_VERSION, true );
}
add_action( 'customize_controls_enqueue_scripts', 'blossom_coach_customize_script' );