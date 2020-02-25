<?php
/**
 * ------------------------------------------------------
 *  Require framework.php file
 * ------------------------------------------------------
 *
 * @since 1.0.0
 *
 * @package Guternbiz WordPress Theme
 */

class Gutenbiz_Customizer_Loader extends Gutenbiz_Helper{

	public function __construct(){

		add_action( 'customize_controls_enqueue_scripts', array( $this, 'script' ), 99	);

		$path = '/classes/customizer/';
		require self::get_theme_path( $path . 'class-framework.php' );

		# Custom Control
		$path .= 'custom-control/';
		require self::get_theme_path( $path . 'toggle/toggle.php'						);
		require self::get_theme_path( $path . 'radio-image/radio-image.php' 			);
		require self::get_theme_path( $path . 'slider/slider.php' 						);
		require self::get_theme_path( $path . 'icon-select/icon-select.php' 			);
		require self::get_theme_path( $path . 'buttonset/buttonset.php' 				);
		require self::get_theme_path( $path . 'color-picker/color-picker.php'			);
		require self::get_theme_path( $path . 'reset/reset.php'							);
		require self::get_theme_path( $path . 'horizontal-line/horizontal-line.php'		);
		require self::get_theme_path( $path . 'range/range.php'							);
	}

	/**
	 * Enqueue the style and scripts used in customizer
	 *
	 * @static
	 * @access public
	 * @return object
	 * @since  1.0.0
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public static function script(){

		$scripts = array(
			array(
		        'handler'    => self::with_prefix( 'customize-js' ),
		        'script'     => 'assets/js/customizer.js',
		        'dependency' => array( 'jquery', 'customize-base', 'jquery-ui-slider' ),
		    ),
			array(
		        'handler' => self::with_prefix( 'customize-css' ),
		        'style'   => 'assets/css/customizer.css',
		    ),
		);

		self::enqueue( $scripts );

		wp_localize_script( self::with_prefix( 'customize-js' ), 'gutenbizColorPalette',
			array( 
				'colorPalettes' => array(
					'#000000',
					'#ffffff',
					'#dd3333',
					'#dd9933',
					'#eeee22',
					'#81d742',
					'#1e73be',
					'#8224e3',
				)
		 	)
		);
	}
}

new Gutenbiz_Customizer_Loader();
