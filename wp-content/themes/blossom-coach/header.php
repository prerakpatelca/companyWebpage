<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Blossom_Coach
 */
    /**
     * Doctype Hook
     * 
     * @hooked blossom_coach_doctype
    */
    do_action( 'blossom_coach_doctype' );
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<?php 
    /**
     * Before wp_head
     * 
     * @hooked blossom_coach_head
    */
    do_action( 'blossom_coach_before_wp_head' );
    
    wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php

    wp_body_open();
    
    /**
     * Before Header
     * 
     * @hooked blossom_coach_page_start - 20 
    */
    do_action( 'blossom_coach_before_header' );
    
    /**
     * Header
     * 
     * @hooked blossom_coach_top_bar - 15
     * @hooked blossom_coach_header  - 20     
    */
    do_action( 'blossom_coach_header' );
    
    /**
     * Before Content
     * @hooked blossom_coach_blog_banner
    */
    do_action( 'blossom_coach_after_header' );
    
    /**
     * Content
     * 
     * @hooked blossom_coach_content_start
    */
    do_action( 'blossom_coach_content' );