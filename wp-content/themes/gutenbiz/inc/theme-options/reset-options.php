<?php
/**
 * Resets all the value of customizer
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress Theme
 */

if( !function_exists( 'gutenbiz_get_setting_id' ) ):
	add_action( 
		Gutenbiz_Helper::with_prefix( 'customize_register_start', '_' ), 
		'gutenbiz_get_setting_id', 30, 2 );
	/**
	* Get all the setting id to reset the data.
	*
	* @return array
	* @since 1.0.0
	*
	* @package Gutenbiz WordPress theme
	*/
	function gutenbiz_get_setting_id( $instance, $wp_customize ) {
		
		Gutenbiz_Customizer::set(array(
			# Theme option
			'panel' => 'panel',
			# Theme Option > Reset options
			'section' => array(
			    'id'    => 'reset-section',
			    'title' => esc_html__( 'Reset Options' ,'gutenbiz' ),
			),
			'fields' => array(
				array(
				    'id' 	      => 'reset-options',
				    'type'        => 'reset',
				    'settings'    => array_keys( $instance::$settings ),
				    'label'       => esc_html__( 'Reset', 'gutenbiz' ),
				    'description' => esc_html__( 'Reseting will delete all the data. Once reset, you will not be able to get back those data.', 'gutenbiz' ),
				),
			),
		) );
	}
endif;
