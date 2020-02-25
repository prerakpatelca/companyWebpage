<?php
/**
 * Blossom Coach Dynamic Styles
 * 
 * @package Blossom_Coach
*/

function blossom_coach_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = blossom_coach_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Nunito' );
    $secondary_fonts = blossom_coach_get_fonts( $secondary_font, 'regular' );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Nunito', 'variant'=>'700' ) );
    $site_title_fonts     = blossom_coach_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 45 );
    
    echo "<style type='text/css' media='all'>"; ?>
    
    /*Typography*/
    body,
    button,
    input,
    select,
    optgroup,
    textarea, section[class*="-section"] .widget_blossom_client_logo_widget .widget-title, .blog-section article .entry-meta, 
    .btn-link, .widget.widget_blossomthemes_stat_counter_widget .widget-title, .single .entry-meta, 
    .portfolio-text-holder .portfolio-img-title {
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;
    }
    
    .site-title, 
    .site-title-wrap .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
    }
    
    /*Typography*/
    h1, h2, h3, h4, h5, h6, 
    section[class*="-section"] .widget .widget-title,
section[class*="-section"] .widget_blossomtheme_featured_page_widget .section-subtitle,
.section-title, .comment-body b.fn, .comment-body .reply .comment-reply-link, .single .navigation .nav-links, 
.site-header .header-search label.screen-reader-text, .btn-readmore, .btn-readmore:visited, .bttk-testimonial-holder .name, 
.pricing-block .price, .entry-meta, #primary .widget_blossomtheme_featured_page_widget .section-subtitle, 
.widget_blossomthemes_stat_counter_widget .hs-counter, .widget_bttk_description_widget .bttk-team-holder .name, 
.bttk-team-inner-holder-modal .name, .page-header .subtitle, .dropcap, .error-404 .error-num, .error-404 a.bttn, 
.related-portfolio-title {
		font-family: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
	}
    <?php if( blossom_coach_is_woocommerce_activated() ) { ?>
    	.woocommerce div.product .product_title,
    	.woocommerce div.product .woocommerce-tabs .panel h2{
			font-family: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
    	}    
    <?php } ?>
           
    <?php echo "</style>";
}
add_action( 'wp_head', 'blossom_coach_dynamic_css', 99 );

/**
 * Function for sanitizing Hex color 
 */
function blossom_coach_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
*/
function blossom_coach_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}