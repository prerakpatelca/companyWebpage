<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Blossom_Coach
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="https://schema.org/Blog">
	<?php 
        /**
         * @hooked blossom_coach_post_thumbnail
        */
        do_action( 'blossom_coach_before_posts_entry_content' );
    ?>
    <div class="article-content-wrap">
    <?php
        /**
         * @hooked blossom_coach_entry_header  - 15
         * @hooked blossom_coach_entry_content - 20
         * @hooked blossom_coach_entry_footer  - 25
        */
        do_action( 'blossom_coach_posts_entry_content' );
    ?>
    </div><!-- .article-content-wrap -->
</article><!-- #post-<?php the_ID(); ?> -->
