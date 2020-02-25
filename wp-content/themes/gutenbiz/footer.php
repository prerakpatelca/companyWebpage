<?php
/**
 * The template for displaying the footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress theme
 */
?>
	<section class="site-footer footer-area">
		<?php 
			if( !apply_filters( Gutenbiz_Helper::with_prefix( 'disable_footer_widget', '_' ), false ) ): ?>
			    <footer <?php Gutenbiz_Helper::schema_body( 'footer' ); ?> class="footer-top-section">
			        <div class="footer-widget">
			            <div class="container">
			                <div class="row">
			                 	<?php
			                 		$num_footer = gutenbiz_get( 'layout-footer' );
			                 		for( $i = 1; $i <= $num_footer ; $i++ ){ ?>
			                 			<?php if ( is_active_sidebar( Gutenbiz_Helper::with_prefix( 'footer_sidebar', '_' ) . '_' . $i ) ) : ?>
					                 		<aside class="col footer-widget-wrapper py-5">
					                 	    	<?php dynamic_sidebar( Gutenbiz_Helper::with_prefix( 'footer_sidebar', '_' ) . '_' . $i ); ?>
					                 		</aside>
				                 		<?php endif; ?>
			                 	<?php } ?>
			                </div>
			            </div>
			        </div>
			    </footer>
		 	<?php endif;
		?>
	    <!-- footer divider line -->
	    <div class="footer-divider w-100"></div>
	    <footer <?php Gutenbiz_Helper::schema_body( 'footer' ); ?> class="footer-bottom-section py-3">
	        <div class="container-fluid">
	             <!-- footer bottom section -->
	             <div class="row justify-content-between">
	                <div class="col-xs-12 col-sm-4">
	                 	<span id="<?php echo esc_attr( Gutenbiz_Helper::with_prefix( 'copyright' ) ); ?>">
		                 	<?php
		                 		$footer_text = gutenbiz_get( 'footer-copyright-text' );
		                 		echo esc_html( $footer_text );
		                 	?>
	                 	</span>	                 	
	                </div>
	                <div class="col-xs-12 col-sm-4 credit-link">
						<?php esc_html_e( 'Created By:' , 'gutenbiz' ) ?>
						<a href="<?php echo esc_url( '//www.risethemes.com' ); ?>" target="_blank">
							<?php esc_html_e( 'Rise Themes', 'gutenbiz' ); ?>	                     		
						</a>
	                </div>
	            </div> <!-- footer-bottom -->
	        </div><!-- container -->
	    </footer><!-- footer- copyright -->
	</section><!-- section -->
	
	<?php do_action( Gutenbiz_Helper::with_prefix( 'after_footer', '_') ); ?>
 </body>
 <?php wp_footer(); ?>
 </html>