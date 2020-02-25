<?php
/** 
 * Customizer Control: color
 *
 * @package Gutenbiz WordPress theme
 * @since   1.0.0
 */

# Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( class_exists( 'WP_Customize_Control' ) ) {

	class Gutenbiz_Customizer_Color_Control extends WP_Customize_Control {

		public $type = 'color-picker';

		/**
		 * Add support for palettes to be passed in.
		 *
		 * Supported palette values are true, false, or an array of RGBa and Hex colors.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var string
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public $palette;

		/**
		 * Add support for showing the opacity value on the slider handle.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var string
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public $show_opacity;

		/**
		 * Enqueue control related scripts/styles.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function enqueue() {
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );
		}

		/**
		 * Refresh the parameters passed to the JavaScript via JSON.
		 *
		 * @see WP_Customize_Control::to_json()
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function to_json() {
			parent::to_json();

			$this->json['default'] = $this->setting->default;
			$this->json['show_opacity'] = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';
			$this->json['value']       = $this->value();
			$this->json['link']        = $this->get_link();
			$this->json['id']          = $this->id;

		}

		/**
		 * An Underscore (JS) template for this control's content (but not its container).
		 *
		 * Class variables for this control class are available in the `data` JS object;
		 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
		 *
		 * @access protected
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		protected function content_template() { ?>
			<label>
				<# if ( data.label ) { #>
					<span class="customize-control-title">{{{ data.label }}}</span>
				<# } #>
				<# if ( data.description ) { #>
					<span class="description customize-control-description">{{{ data.description }}}</span>
				<# } #>
				<div>
					<input class="alpha-color-control" type="text"  value="{{ data.value }}" data-show-opacity="{{ data.show_opacity }}" data-default-color="{{ data.default }}" {{{ data.link }}} />
				</div>
			</label>
			<?php
		}
	}
}

gutenbiz_Customizer::add_custom_control( array(
    'type'     => 'color-picker',
    'class'    => 'Gutenbiz_Customizer_Color_Control',
    'sanitize' => array( 'Gutenbiz_Customizer', 'sanitize_rgba' ),
));