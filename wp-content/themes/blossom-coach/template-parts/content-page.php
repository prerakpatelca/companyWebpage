<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Coach
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
        /**
         * @hooked blossom_coach_entry_header   - 15
         * @hooked blossom_coach_post_thumbnail - 20
        */
        do_action( 'blossom_coach_before_page_entry_content' );
    
        /**
         * @hooked blossom_coach_entry_content - 15
         * @hooked blossom_coach_entry_footer  - 20
        */
        do_action( 'blossom_coach_page_entry_content' );    
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
