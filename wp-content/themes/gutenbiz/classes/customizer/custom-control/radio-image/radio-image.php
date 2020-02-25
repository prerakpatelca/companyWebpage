<?php

/**
 * Customizer Control: gutenbiz-radio-image.
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress theme
 */

# Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}
/**
 * Radio image customize control.
 *
 * @since  1.0.0
 * @access public
 */
class Gutenbiz_Customize_Control_Radio_Image extends WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public $type = 'radio-image';

	/**
	 * Enqueue control related scripts/styles.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public function enqueue() {
		wp_enqueue_script( 'jquery-ui-button' );
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

		// We need to make sure we have the correct image URL.
		foreach ( $this->choices as $value => $args )
			$this->choices[ $value ]['url'] = esc_url( sprintf( $args['url'], get_template_directory_uri(), get_stylesheet_directory_uri() ) );

		$this->json['choices'] = $this->choices;
		$this->json['link']    = $this->get_link();
		$this->json['value']   = $this->value();
		$this->json['id']      = $this->id;
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @access public
	 * @since 1.0.0
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public function content_template() { ?>

		<# if ( ! data.choices ) {
			return;
		} #>

		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<div class="buttonset layout-options">

			<# for ( key in data.choices ) { #>
				<div class="layout">
					<input type="radio" value="{{ key }}" name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}-{{ key }}" {{{ data.link }}} <# if ( key === data.value ) { #> checked="checked" <# } #> />

					<label for="{{ data.id }}-{{ key }}">
						<span class="screen-reader-text">{{ data.choices[ key ]['label'] }}</span>
						{{{ data.choices[ key ]['svg'] }}}
					</label>
				</div>
			<# } #>

		</div><!-- .buttonset -->
	<?php }
}

gutenbiz_Customizer::add_custom_control( array(
    'type'     => 'radio-image',
    'class'    => 'Gutenbiz_Customize_Control_Radio_Image',
    'sanitize' => array( 'Gutenbiz_Customizer', 'sanitize_number' ),
));