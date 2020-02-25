<?php
/**
 * Template part for displaying the rating notice
 *
 * @since 1.0.3
 *
 * @package Gutenbiz WordPress Theme
 */
?>
<div class="notice notice-info is-dismissible" id="gutenbiz-rating-notice">
    <div class="notice-image">
		<div class="notice-content">
			<div class="notice-heading">
				<?php esc_html_e( 'Hello! Seems like you have used gutenbiz theme to build this website — Thanks a ton!', 'gutenbiz' ); ?>
			</div>
			<?php esc_html_e( 'Could you please do us a BIG favor and give it a 5-star rating on WordPress? This would boost our motivation and help other users make a comfortable decision while choosing the gutenbiz theme.', 'gutenbiz' ); ?>
			<br/>
			<div class="gutenbiz-review-notice-container">
				<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/gutenbiz/reviews/#new-post' ) ?>" class="gutenbiz-notice-close button-primary" target="_blank">
					<?php esc_html_e( 'Ok, you deserve it', 'gutenbiz' ); ?>
				</a>
				<i class="dashicons dashicons-calendar"></i>
				<button class="gutenbiz-notice-close btn">
					<?php esc_html_e( 'Nope, maybe later', 'gutenbiz' ); ?>
				</button>
				<i class="dashicons dashicons-smiley"></i>
				<button class="gutenbiz-notice-close btn">
					<?php esc_html_e( 'I already did', 'gutenbiz' ) ?>
				</button>
			</div>
		</div>
	</div>
</div>