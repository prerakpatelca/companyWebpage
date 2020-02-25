<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Gutenbiz WordPress Theme
 */

get_header(); ?>
<div class="container" id="content">
	<div class="row">
		<div class="<?php echo esc_attr( Gutenbiz_Theme::is_sidebar_active() ? 'col-md-8 col-lg-8' : 'col-md-12' ); ?> content-order">
			<div id="primary" class="content-area">
				<main id="main" class="site-main ">
				<?php if ( have_posts() ): ?>
					<div class="row" id="load-more">
						<?php woocommerce_content(); ?>							
					</div>
							
					<?php Gutenbiz_Helper::posts_navigation(); ?>
					
				<?php else: ?>
					<?php
						# If no content, include the "No posts found" template.
						get_template_part( 'templates/content/content', 'none' );
					?>
				<?php endif; ?>				
				</main><!-- .site-main -->
			</div><!-- .content-area -->
		</div>
		<?php Gutenbiz_Theme::the_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>