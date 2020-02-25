<?php
/**
 * Active Callback
 * 
 * @package Blossom_Coach
*/

if( ! function_exists( 'blossom_coach_banner_ac' ) ) :
/**
 * Active Callback for Banner Slider
*/
function blossom_coach_banner_ac( $control ){
    $banner      = $control->manager->get_setting( 'ed_banner_section' )->value();
    $slider_type = $control->manager->get_setting( 'slider_type' )->value();
    $control_id  = $control->id;
    
    if ( $control_id == 'header_image' && $banner == 'static_nl_banner' ) return true;
    if ( $control_id == 'header_video' && $banner == 'static_nl_banner' ) return true;
    if ( $control_id == 'external_header_video' && $banner == 'static_nl_banner' ) return true;
    if ( $control_id == 'banner_newsletter' && $banner == 'static_nl_banner' ) return true;
    
    if ( $control_id == 'slider_type' && $banner == 'slider_banner' ) return true;          
    if ( $control_id == 'slider_animation' && $banner == 'slider_banner' ) return true;
    
    if ( $control_id == 'slider_cat' && $banner == 'slider_banner' && $slider_type == 'cat' ) return true;
    if ( $control_id == 'no_of_slides' && $banner == 'slider_banner' && $slider_type == 'latest_posts' ) return true;
    
    return false;
}
endif;

if( ! function_exists( 'blossom_coach_blog_view_all_ac' ) ) :
/**
 * Active Callback for Blog View All Button
*/
function blossom_coach_blog_view_all_ac(){
    $blog = get_option( 'page_for_posts' );
    if( $blog ) return true;
    
    return false; 
}
endif;

if( ! function_exists( 'blossom_coach_breadcrumbs' ) ) :
/**
 * Active Callback for Breadcrumb.
*/
function blossom_coach_breadcrumbs(){
    $breadcrumb = get_theme_mod( 'ed_breadcrumb' , true );

    if( $breadcrumb ) return true;
    
    return false; 
}
endif;