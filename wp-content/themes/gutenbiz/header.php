<?php
/**
 * The Header for our theme.
 *
 * @since 1.0.0 
 *
 * @package Gutenbiz WordPress theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
 	<meta charset="<?php bloginfo( 'charset' ); ?>">
 	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
 	<?php wp_head(); ?>
</head>
<body <?php Gutenbiz_Helper::schema_body( 'body' ); body_class(); ?> >
	<?php
		//wp_body_open hook from WordPress 5.2
		if ( function_exists( 'wp_body_open' ) ) {
		    wp_body_open();
		}
	?>
<?php  

	do_action( Gutenbiz_Helper::with_prefix( 'after_body', '_' ) ); 

	do_action( Gutenbiz_Helper::with_prefix( 'before_header', '_' ) ); 
	
	do_action( Gutenbiz_Helper::with_prefix( 'header', '_' ) ); 

	do_action( Gutenbiz_Helper::with_prefix( 'after_header', '_' ) );

	           
