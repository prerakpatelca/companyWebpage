<?php
/**
 * Comtent for header
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress Theme
 */ ?>
<div class="gutenbiz-bottom-header-wrapper">
	<div class="container">
		<section class="gutenbiz-bottom-header">

			<div class="gutenbiz-header-search">
				<?php get_search_form(); ?>
				<button type="button" class="close gutenbiz-toggle-search">
					<i class="fa fa-times" aria-hidden="true"></i>
				</button>
			</div>
			
			<div class="site-branding">
				<div>
					<?php
					the_custom_logo();
					if ( is_front_page() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) :
						?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="gutenbiz-navigation-n-options">
				<nav class="gutenbiz-main-menu" id="site-navigation">
					<?php Gutenbiz_Helper::get_menu( 'primary', true ); ?>
				</nav> 			
				<?php do_action( Gutenbiz_Helper::with_prefix( 'after_primary_menu', '_' ) ); ?>
			</div>				
		 
		</section>

	</div>
</div>
<!-- nav bar section end -->