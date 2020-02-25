<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Blossom_Coach
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<section class="error-404 not-found">
				<div class="page-content">
					<div class="error-num"><?php esc_html_e( '404', 'blossom-coach' ); ?></div>
					<p class="error-text"><?php esc_html_e( 'We\'re sorry but it looks like that page doesn\'t exist anymore.', 'blossom-coach' ); ?></p>
					<a class="bttn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Take me to the home page', 'blossom-coach' ); ?></a>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->
            
            <?php
            /**
             * @see blossom_coach_latest_posts
            */
            do_action( 'blossom_coach_latest_posts' );
            ?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();