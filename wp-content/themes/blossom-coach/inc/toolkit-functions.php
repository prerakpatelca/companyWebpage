<?php
/**
 * Toolkit Filters
 *
 * @package Blossom_Coach
 */
 
if( ! function_exists( 'blossom_coach_featured_page_img_align' ) ) :
    function blossom_coach_featured_page_img_align(){
        $array = array(
            'right' => esc_html__( 'Right', 'blossom-coach' ),
            'left'  => esc_html__( 'Left', 'blossom-coach' ),
        );
        return $array;    
    }
    endif;
add_filter( 'bttk_img_alignment', 'blossom_coach_featured_page_img_align' );

if( ! function_exists( 'blossom_coach_testimonial_image_size' ) ) :
    function blossom_coach_testimonial_image_size(){
        return 'thumbnail';
    }
endif;
add_filter( 'icon_img_size', 'blossom_coach_testimonial_image_size' );

if( ! function_exists( 'blossom_coach_default_cta_color' ) ) :
    function blossom_coach_default_cta_color(){
        return '#88ced0';
    }
endif;
add_filter( 'bttk_cta_bg_color', 'blossom_coach_default_cta_color' );

if( ! function_exists( 'blossom_coach_portfolio_single_image' )  ) :
    function blossom_coach_portfolio_single_image(){
        return 'blossom-coach-fullwidth';
    }
endif;
add_filter( 'bttk_single_portfolio_image', 'blossom_coach_portfolio_single_image' );

if( ! function_exists( 'blossom_coach_portfolio_related_image' ) ) :
    function blossom_coach_portfolio_related_image(){
        return 'blossom-coach-blog';
    }
endif;
add_filter( 'bttk_related_portfolio_image', 'blossom_coach_portfolio_related_image' );

if( ! function_exists( 'blossom_coach_portfolio_header' ) ) :
    function blossom_coach_portfolio_header(){
        global $post;
        echo '<header class="page-header"><h1 class="page-title">' . esc_html( $post->post_title ) . '</h1></header>';
    }
endif;
add_action( 'bttk_before_portfolios', 'blossom_coach_portfolio_header' );

if( ! function_exists( 'blossom_coach_newsletter_bg_image_size' ) ) :
    function blossom_coach_newsletter_bg_image_size(){
        return 'full';
    }
endif;
add_filter( 'bt_newsletter_img_size', 'blossom_coach_newsletter_bg_image_size' );

if( ! function_exists( 'blossom_coach_ad_image' ) ) :
    function blossom_coach_ad_image(){
        return 'full';
    }
endif;
add_filter( 'bttk_ad_img_size', 'blossom_coach_ad_image' );

if( ! function_exists( 'blossom_coach_newsletter_bg_color' ) ) :
    function blossom_coach_newsletter_bg_color(){
        return '#88ced0';
    }
endif;
add_filter( 'bt_newsletter_bg_color', 'blossom_coach_newsletter_bg_color' );


if( ! function_exists( 'blossom_coach_author_image' ) ) :
    function blossom_coach_author_image(){
        return 'blossom-coach-blog';
    }
endif;
add_filter( 'author_bio_img_size', 'blossom_coach_author_image' );