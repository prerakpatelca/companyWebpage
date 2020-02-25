<?php
/**
 * Template part for displaying inner banner in pages
 *
 * @since 1.0.0
 * 
 * @package Gutenbiz WordPress Theme
 */
?>
<div class="<?php echo esc_attr( Gutenbiz_Helper::get_inner_banner_class() ); ?>" <?php Gutenbiz_Helper::the_header_image(); ?>> 
	<div class="container">
		<?php
			Gutenbiz_Helper::the_inner_banner();
			Gutenbiz_Helper::the_breadcrumb();
		?>
	</div>
</div>
