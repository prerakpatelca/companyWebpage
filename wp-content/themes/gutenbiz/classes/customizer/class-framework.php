<?php
/**
 * Customizer framework for theme
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 * @since 1.0.0
 * @package Gutenbiz WordPress Theme
 */

if( !class_exists( 'Gutenbiz_Customizer' ) ){
	class Gutenbiz_Customizer extends Gutenbiz_Helper{

	   /**
		* The object instance.
		*
		* @static
		* @access private
		* @since 1.0.0
		* @var object
		*
		* @package Gutenbiz WordPress Theme 
		*/
		private static $instance;

		/**
		* The Field array
		*
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $fields = array();

		/**
		* The Customizer instance
		* 
		* @since  1.0.0
		* @access private
		* @var    object
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static $customize;

		/**
		* The defaults array
		* 
		* @since  1.0.0
		* @access private
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $partials = array();

		/**
		* Custom Section array
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $sections = array();

		private static $buffer = array();

		# Some Default sections ids in WordPress 
		public static $default_sections = array( 
			'title_tagline',
			'colors',
			'header_image',
			'background_image',
			'nav',
			'static_front_page',
		);

		/**
		* The Panel array
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $panels = array();

		/**
		* The Setting array
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $settings = array();

		/**
		* The Controls array
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $controls = array();

		/**
		* The defaults array
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $defaults = array();

		/**
		* Know weather client is using color control
		* 
		* @since  1.0.0
		* @access public
		* @var    bool
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $color_picker = false;

		/**
		* All errors occured in validation process are stored here.
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $errors = array();

		/**
		* Lives all the custom controls here.
		* 
		* @since  1.0.0
		* @access public
		* @var    array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static $custom_controls = array();

	   /**
		* Gets an instance of this object.
		* Prevents duplicate instances which avoid artefacts and improves performance.
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return object
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_instance() {
			if( !self::$instance ) {

				self::$instance = new self();
				add_action( 'admin_notices', array( self::$instance, 'errors' ) );
			}
			return self::$instance;
		}

		/**
		* Add custom controls to its array
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return object
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function add_custom_control( $control ){

			if( !is_array( $control ) ){
				$err = esc_html__( 'Invalid argument passed for Custom Control. Must be an array with "type" & "class" key.', 'gutenbiz' );
				self::add_error( $err );
				return;
			}

			$flag = true;
			if( !isset( $control[ 'type' ] ) ){
				$err = esc_html__( 'Custom Control must contain "type" key ( type of control ).', 'gutenbiz' );
				self::add_error( $err );
				$flag = false;
			}

			if( !isset( $control[ 'class' ] ) ){
				$err = esc_html__( 'Custom Control must contain "class" key ( name of custom class ).', 'gutenbiz' );
				self::add_error( $err );
				$flag = false;
			}		

			if( !isset( $control[ 'sanitize' ] ) ){
				$err = esc_html__( 'Custom Control must contain "sanitize" key ( a callback function ).', 'gutenbiz' );
				self::add_error( $err );
				$flag = false;
			}
			
			if( $flag ){
				self::$custom_controls[ $control[ 'type' ] ] = array(
					'class'    => $control[ 'class' ],
					'sanitize' => isset( $control[ 'sanitize' ] ) ? $control[ 'sanitize' ] : false,
					'register_control_type' => isset( $control[ 'register_control_type' ] ) ? $control[ 'register_control_type' ] : true
				);
			}
		}

	   /**
		* The Setter function
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return object
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function set( $args ){

			do_action( self::with_prefix( 'customizer_before_set', '_' ), self::get_instance() );
			
			self::validate_argument( $args );

			if( count( self::$errors ) > 0 ){
				return;
			}

			$panel_id = false;
			if( isset( $args[ 'panel' ] ) ){

				$panel = $args[ 'panel' ];

				# adds prefix to the panel id
				if( is_array( $panel ) ){
					if( isset( $panel[ 'prefix' ] ) && $panel[ 'prefix' ] === false ){
						$panel_id = $panel[ 'id' ];
					}else{
						$panel_id = self::with_prefix( $panel[ 'id' ] );
					}
				}else{
					$panel_id = self::with_prefix( $panel );
				}

				if( is_array( $panel ) && !array_key_exists( $panel_id, self::$panels ) ){
					self::$panels[ $panel_id ] = self::get_panel_arg( $panel );
				}
			}

			# adds prefix to the section id
			$prefix_on_section = true;
			if( isset( $args[ 'section' ][ 'prefix' ] ) ){
				$prefix_on_section =  $args[ 'section' ][ 'prefix' ];
			}
			if( $prefix_on_section ){
				$section_id = self::with_prefix( $args[ 'section' ][ 'id' ] );
			}else{
				$section_id = $args[ 'section' ][ 'id' ];
			}

			if( !in_array( $section_id, self::$default_sections ) ){
				self::$sections[ $section_id ] = self::get_section_arg( $panel_id, $args[ 'section' ] );
			}

			foreach( $args[ 'fields' ] as $field ){

				if( isset( $field[ 'id' ] ) ){

					$field_id = self::with_prefix( $field[ 'id' ] );

					# Store it for future
					# This variable might be useful for custom controls
					self::$fields[ $field[ 'type' ] ][] = $field;

					if( array_key_exists( $field_id, self::$settings ) ){
						/* translators: %s: name of field id that user feed */
						$msg = sprintf( esc_html__( 'Field with ID: %s already exists.', 'gutenbiz' ), $field[ 'id' ] );
						self::add_error( $msg );
					}

					if( isset( $field[ 'default' ] ) ){
						self::$defaults[ $field_id ] = $field[ 'default' ];
					}

					$field[ 'id' ] = $field_id;
					self::$settings[ $field_id ] = self::get_setting_arg( $field );
					self::$controls[ $field_id ] = self::get_control_arg( $args[ 'section' ], $field, $prefix_on_section );

					if( 'color' == $field[ 'type' ] ){
						self::$color_picker = true;
					}

					if( isset( $field[ 'partial' ] ) ){
						self::$partials[ $field_id ] = self::get_partial_arg( $field[ 'partial' ] );
					}
				}
			}

			do_action( self::with_prefix( 'customizer_after_set', '_'), self::get_instance() );
		}

	   /**
		* Checks wheather the arguments are eligible for customizer
		*
		* Adds error if invalid arguments
		* @static
		* @access private
		* @param arrau
		* @since 1.0.0
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static function validate_argument( $args ){

			if( !is_array( $args ) ){

				$msg = esc_html__( 'You must pass array as an argument in set method.', 'gutenbiz' );
				self::add_error( $msg, 2 );

				return;
			}

			if( !isset( $args[ 'section' ] ) ){

				$msg = esc_html__( 'No section found.', 'gutenbiz' );
				self::add_error( $msg, 2 );

				return;
			}

			if( !is_array( $args[ 'section' ] ) ){

				$msg = sprintf( 
					'%s <strong><em>%s</em></strong>. %s',
					esc_html__( 'Invalid argument', 'gutenbiz' ),	
					esc_html__( 'section', 'gutenbiz' ),
					esc_html__( 'Must be a an array with atleast an id, title...', 'gutenbiz' )
				);

				self::add_error( $msg, 2 );

			}elseif( !isset( $args[ 'section' ][ 'id' ] ) ){

				$msg = esc_html__( 'Section id is missing.', 'gutenbiz' );
				self::add_error( $msg, 2 );
			}

			if( !isset( $args[ 'fields' ] ) ){

				$msg = esc_html__( 'Fields are missing.', 'gutenbiz' );
				self::add_error( $msg, 2 );

			}elseif( !is_array( $args[ 'fields' ] ) ){

				$msg = sprintf( 
					'%s <strong><em>%s</em></strong>. %s',
					esc_html__( 'Invalid argument', 'gutenbiz' ),	
					esc_html__( 'fields', 'gutenbiz' ),
					esc_html__( 'Must be a an array', 'gutenbiz' )
				);

				self::add_error( $msg );
			}
		}

	   /**
		* Adds Errors in a static variable
		*
		* @static
		* @access private
		* @param string
		* @since 1.0.0
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function add_error( $msg, $n = 1 ){
			$trace = debug_backtrace();
			$msg = sprintf( '%s<div>%s</div>', $msg, $trace[ $n ][ 'file' ] . ' ' . $trace[ $n ][ 'line' ] );
			self::$errors[] =$msg;
		}

	   /**
		* Adds values in the buffer
		*
		* @static
		* @access public
		* @param string
		* @since 1.0.0
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function add_buffer( $key, $val ){
			self::$buffer[ $key ] = $val;
		}

	   /**
		* Retrieve value from buffer
		*
		* @static
		* @access public
		* @param string
		* @since 1.0.0
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_buffer( $key, $default = false ){
			return isset( self::$buffer[ $key ] ) ? self::$buffer[ $key ] : $default;
		}

	   /**
		* Print errors in dashboard
		*
		* @static
		* @access public
		* @since 1.0.0
		* @param boolean
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function errors( $get = false ){
			if( count( self::$errors ) > 0 ){
				if( $get )
					ob_start();
				?>
				<div class="error">
					<?php foreach ( self::$errors as $key => $value ): ?>
						<p>
							<?php  
								echo sprintf( '<strong>%s</strong> %s', 
									esc_html__( 'Gutenbiz Customizer:', 'gutenbiz' ),
									esc_html( $value ) 
								);  
							?>
						</p>
					<?php endforeach; ?>
				</div>
				<?php
				if( $get ){
					$data = ob_get_clean();
					return $data;
				}
			}
		}

	    /**
		* Retrives all default values
		* 
		* @access public
		* @since  1.0.0
		* @return array
		*
		* @package Gutenbiz WordPress Theme
		*/
	    public static function get_defaults(){ 
	    	$def = apply_filters(  self::with_prefix( 'customizer_get_defaults', '_' ), self::$defaults, self::get_instance() );
	    	return $def;
	    }

	    /**
		* Retrives all default value by id
		* 
		* @access public
		* @since  1.0.0
		* @return string|int|bool
		*
		* @package Gutenbiz WordPress Theme
		*/
	    public static function get_default( $id ){
	    	$def = self::get_defaults();
	    	return $def[ $id ];
	    }

		/**
		* Sanitization function for numbers.
		*
		* @access public
		* @since 1.0.0
		* @return number
		*
		* @package Gutenbiz WordPress Theme
		*/
	    public static function sanitize_number( $input, $setting ){
	    	$sanitized_text = sanitize_text_field( $input );
	    	# If the input is an number, return it; otherwise, return the default
	    	return ( is_numeric( $sanitized_text ) ? $sanitized_text : $setting->default );
	    }

	    /**
	    * Sanitization function for blank.
	    *
	    * @access public
	    * @since 1.0.0
	    * @return number
	    *
	    * @package Gutenbiz WordPress Theme
	    */
	    public static function sanitize_number_blank( $val ){
	    	return is_numeric( $val ) ? $val : '';
	    }

		/**
		* Sanitization function for checkbox.
		*
		* @access public
		* @since 1.0.0
		* @return boolean
		*
		* @package Gutenbiz WordPress Theme
		*/
	    public static function sanitize_checkbox( $checked ) {
	    	return ( ( isset( $checked ) && true === $checked ) ? true : false );
	    }

	    /**
	    * Sanitization function for select.
	    *
	    * @access public
	    * @since 1.0.0
	    * @return string
	    *
	    * @package Gutenbiz WordPress Theme
	    */
	    public static function sanitize_choice( $input, $setting ){
	    	# Ensure input is a slug.
	    	$input = sanitize_key( $input );
	    	# Get list of choices from the control associated with the setting.
	    	$choices = $setting->manager->get_control( $setting->id )->choices;

	    	# If the input is a valid key, return it; otherwise, return the default.
	    	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	    }    

	    /**
	    * Sanitization function for hex color.
	    *
	    * @access public
	    * @since 1.0.0
	    * @return string
	    *
	    * @package Gutenbiz WordPress Theme
	    */
	    public static function sanitize_hex_color( $input, $setting ){    	# Ensure input is a slug.
	    	$input = sanitize_hex_color( $input );
	    	
	    	# If $input is a valid hex value, return it; otherwise, return the default.
	    	$return = !is_null( $input ) ? $input : $setting->default;
	    	
	    	return $return;
	    }

	    /**
	    * Sanitization function for rgba.
	    *
	    * @access public
	    * @param  string $color
	    * @since 1.0.0
	    * @return string
	    *
	    * @package Gutenbiz WordPress Theme
	    */
	    public static function sanitize_rgba( $color ) {
	        if ( '' === $color ){
	        	return '';
	        }

	        # If string does not start with 'rgba', then treat as hex
	        # sanitize the hex color and finally convert hex to rgba
	        if ( false === strpos( $color, 'rgba' ) ) {
	            return sanitize_hex_color( $color );
	        }

	        # By now we know the string is formatted as an rgba color so we need to further sanitize it.
	        $color = str_replace( ' ', '', $color );
	        sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
	        return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
	    }

	    /**
		* Retrives value by id
		* 
		* @access public
		* @param  string $id
		* @return string | false
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get( $id ){
			$defaults = self::get_defaults();

			if( isset( $defaults[ $id ] ) ){
				$default = $defaults[ $id ];
			}else{
				$default = false;
			}

			return get_theme_mod( $id, $default );
		}

	    /**
		* Returns Sanitization function
		* 
		* @since  1.0.0
		* @access private
		* @param  string $type
		* @return string
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static function get_sanitize_callback( $type ){

			$fn = '';
			switch ( $type ) {
				case 'text':
					$fn = 'sanitize_text_field';
				break;

				case 'url':
					$fn = 'esc_url_raw';
				break;

				case 'email':
					$fn = 'sanitize_email';
				break;

				case 'number':
					$fn = array( __CLASS__ , 'sanitize_number' );
				break;

				case 'checkbox':
					$fn = array( __CLASS__ , 'sanitize_checkbox' );
				break;

				case 'select':
				case 'radio':
					$fn = array( __CLASS__ , 'sanitize_choice' );
				break;

				case 'textarea':
					$fn = 'esc_textarea';
				break;

				case 'color':
					$fn = array( __CLASS__ , 'sanitize_hex_color' );
				break;

				case 'dropdown-pages':
					$fn = 'absint';
				break;

				default:
					if( array_key_exists( $type, self::$custom_controls ) ){
						$sanitize_callback = self::$custom_controls[ $type ][ 'sanitize' ];
						if( $sanitize_callback ){
							$fn = $sanitize_callback;
						}
					}
				break;
			}

			return apply_filters( self::with_prefix( 'customizer_sanitizer', '_' ), $fn, $type );
		}

	    /**
		* Returns args for panels
		* 
		* @since  1.0.0
		* @access private
		* @param  array $panel
		* @return array
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static function get_panel_arg( $panel ){
			
			$args = array(
			    'title' => empty( $panel[ 'title' ] ) ?
			     esc_html__( 'No Title Specified.', 'gutenbiz' ) : 
			     esc_html__( 'Theme Options','gutenbiz' ),
			);

			if( isset( $panel[ 'description' ] ) ){
				$args[ 'description' ] = $panel[ 'description' ];
			}

			if( isset( $panel[ 'priority' ] ) ){
				$args[ 'priority' ] = $panel[ 'priority' ];
			}

			if( isset( $panel[ 'active_callback' ] ) ) {
	            $args[ 'active_callback' ] = $panel[ 'active_callback' ];
	        }

	        if( isset( $panel[ 'theme_supports' ] ) ) {
	            $args[ 'theme_supports' ] = $panel[ 'theme_supports' ];
	        }

	        if( isset( $panel[ 'capability' ] ) ) {
	            $args[ 'capability' ] = $panel[ 'capability' ];
	        }

	        return apply_filters( self::with_prefix( 'customizer_get_panel_arg', '_' ), $args, $panel );
		}

	    /**
		* Returns args for settings
		* 
		* @since  1.0.0
		* @access public
		* @param  array $field
		* @return array
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_setting_arg( $field ){
			$args = array();

			if( isset( self::$defaults[ $field[ 'id' ] ] ) )
				$args[ 'default' ] = self::$defaults[ $field[ 'id' ] ];
			else
				$args[ 'default' ] = '';

			if( isset( $field[ 'setting_type' ] ) || !empty( $field[ 'setting_type' ] ) ){
				$args[ 'type' ] = $field[ 'setting_type' ];
			}

			if( isset( $field[ 'capability' ] ) && !empty( $field[ 'capability' ] ) ){
				$args[ 'capability' ] = $field[ 'capability' ];
			}

			if( isset( $field[ 'theme_supports' ] ) && !empty( $field[ 'theme_supports' ] ) ){
				$args[ 'theme_supports' ] = $field[ 'theme_supports' ];
			}

			if(  isset($field['partial']) &&  isset( $field['partial']['selector'] ) ){
				$args[ 'transport' ] = 'postMessage' ;
			}elseif( isset( $field[ 'transport' ] ) || !empty( $field[ 'transport' ] ) ) {
				$args[ 'transport' ] = $field[ 'transport' ];
			}

			if( isset( $field[ 'sanitize_callback' ] ) && !empty( $field[ 'sanitize_callback' ] ) ){
				$args[ 'sanitize_callback' ] = $field[ 'sanitize_callback' ];
			}else{
				$args[ 'sanitize_callback' ] = self::get_sanitize_callback( $field[ 'type' ] );
			}

			if( isset( $field[ 'sanitize_js_callback' ] ) && !empty( $field[ 'sanitize_js_callback' ] ) ){
				$args[ 'sanitize_js_callback' ] = $field[ 'sanitize_js_callback' ];
			}

			return apply_filters( self::with_prefix( 'customizer_get_setting_arg', '_' ), $args, $field );
		}

	    /**
		* Returns args for control
		* 
		* @since  1.0.0
		* @access private
		* @param  array $panel
		* @param  array $field
		* @return array
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static function get_control_arg( $section, $field, $prefix_on_section = true ){
			$args = array();

			if( isset( $field[ 'type' ] ) && !empty( $field[ 'type' ] ) ){
				$args[ 'type' ] = $field[ 'type' ];
			}

			if( isset( $field[ 'label' ] ) && !empty( $field[ 'label' ] ) ){
				$args[ 'label' ] = $field[ 'label' ];
			}

			if( isset( $field[ 'description' ] ) && !empty( $field[ 'description' ] ) ){
				$args[ 'description' ] = $field[ 'description' ];
			}

			if( is_array( $section ) && isset( $section[ 'id' ] ) ){
				$args[ 'section' ] = $prefix_on_section ? self::with_prefix( $section[ 'id' ] ) : $section[ 'id' ];
			}

			if( isset( $field[ 'priority' ] ) && !empty( $field[ 'priority' ] ) ){
				$args[ 'priority' ] = $field[ 'priority' ];
			}

			if( isset( $field[ 'active_callback' ] ) ) {
	            $args[ 'active_callback' ] = self::with_prefix( $field[ 'active_callback' ], '_' );
	        }

			if( isset( $field[ 'settings' ] ) && !empty( $field[ 'settings' ] ) ){
				$args[ 'settings' ] = $field[ 'settings' ];
			}

			if( isset( $field[ 'choices' ] ) && is_array( $field[ 'choices' ] ) ){
				$args[ 'choices' ] = $field[ 'choices' ];
			}

			if( isset( $field[ 'height' ] ) && !empty( $field[ 'height' ] ) ){
				$args[ 'height' ] = $field[ 'height' ];
			}

			if( isset( $field[ 'width' ] ) && !empty( $field[ 'width' ] ) ){
				$args[ 'width' ] = $field[ 'width' ];
			}

			if( isset( $field[ 'input_attrs' ] ) && !empty( $field[ 'input_attrs' ] ) ){
				$args[ 'input_attrs' ] = $field[ 'input_attrs' ];
			}

			return apply_filters( self::with_prefix( 'customizer_get_control_arg', '_' ), $args, $section, $field );
		}

	    /**
		* Returns args for partials
		* 
		* @since  1.0.0
		* @access private
		* @param  array $partial
		* @return array
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static function get_partial_arg( $partial ){
			$args = array();

			if( isset( $partial[ 'type' ] ) && !empty( $partial[ 'type' ] ) ){
				$args[ 'type' ] = $partial[ 'type' ];
			}

			if( isset( $partial[ 'selector' ] ) && !empty( $partial[ 'selector' ] ) ){
				$args[ 'selector' ] = $partial[ 'selector' ];
			}

			if( isset( $partial[ 'settings' ] ) && !empty( $partial[ 'settings' ] ) ){
				$args[ 'settings' ] = $partial[ 'settings' ];
			}

			if( isset( $partial[ 'primary_setting' ] ) && !empty( $partial[ 'primary_setting' ] ) ){
				$args[ 'primary_setting' ] = $partial[ 'primary_setting' ];
			}

			if( isset( $partial[ 'capability' ] ) && !empty( $partial[ 'capability' ] ) ){
				$args[ 'capability' ] = $partial[ 'capability' ];
			}

			if( isset( $partial[ 'render_callback' ] ) && !empty( $partial[ 'render_callback' ] ) ){
				$args[ 'render_callback' ] = $partial[ 'render_callback' ];
			}else{
				$args[ 'render_callback' ] = array( self::$instance, 'render_partial' );
			}

			if( isset( $partial[ 'container_inclusive' ] ) && !empty( $partial[ 'container_inclusive' ] ) ){
				$args[ 'container_inclusive' ] = $partial[ 'container_inclusive' ];
			}

			if( isset( $partial[ 'fallback_refresh' ] ) && !empty( $partial[ 'fallback_refresh' ] ) ){
				$args[ 'fallback_refresh' ] = $partial[ 'fallback_refresh' ];
			}

			return apply_filters( self::with_prefix( 'customizer_get_partial_arg', '_' ), $args, $partial );
		}

		/**
		* adds Customizer's sections.
		* 
		* @since  1.0.0
		* @access private
		* @link   https://codex.wordpress.org/Class_Reference/WP_Customize_Manager/add_section 
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		private static function get_section_arg( $panel_id = false, $section ){
			$args = array(
				'title' => empty( $section[ 'title' ] ) ? esc_html__( 'No Title Specified.', 'gutenbiz' ) : $section[ 'title' ],
			);

			if( isset( $section[ 'priority' ] ) ){
				$args[ 'priority' ] = $section[ 'priority' ];
			}

			if( isset( $section[ 'section' ] ) ){
				$args[ 'section' ] = $section[ 'section' ];
			}

			if( isset( $section[ 'description' ] ) ){
				$args[ 'description' ] = $section[ 'description' ];
			}

			if( isset( $section[ 'active_callback' ] ) ){
				$args[ 'active_callback' ] = $section[ 'active_callback' ];
			}

			if( $panel_id ){
				$args[ 'panel' ] = $panel_id;
			}

			return apply_filters( self::with_prefix( 'customizer_get_section_arg', '_' ), $args, $panel_id, $section );
		}

		/**
		* Equeue necessary scripts or styles for customizer
		* 
		* @since  1.0.0
		* @access public
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function scripts(){
			if( self::$color_picker ){
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script( 'wp-color-picker');
			}
		}

		/**
		* Register panels, sections, controls and settings
		* 
		* @since  1.0.0
		* @param  object ( $wp_customize )
		* @access public
		* @return void
		*/
		public static function register( $wp_customize ){

 			do_action(  self::with_prefix( 'customize_register_start', '_' ), self::get_instance(), $wp_customize );

			if( count( self::$errors ) > 0 ){
				if( is_customize_preview() ){
					wp_die( self::errors( true ) );
				}
				return;
			}

			add_action( 'admin_enqueue_scripts', array( self::get_instance(), 'scripts' ) );
			foreach( self::$custom_controls as $type => $args ){
				if( $args[ 'register_control_type' ] === true ){
					$wp_customize->register_control_type( $args[ 'class' ] );
				}
			}
			foreach( self::$panels as $id => $args ){
				$wp_customize->add_panel( $id, $args );
			}

			foreach( self::$sections as $id => $args ){
				$wp_customize->add_section( $id, $args );
			}

			foreach( self::$settings as $id => $args ){

				$wp_customize->add_setting(
					$id , array_merge( $args, array( 'sanitize_callback', $args[ 'sanitize_callback' ] ) ) 
				);

				if( isset( self::$controls[ $id ] ) ){
					$control = self::$controls[ $id ];

					self::add_control( $wp_customize, $id, $control );
				}
			}
			foreach( self::$partials as $id => $args ){
				$wp_customize->selective_refresh->add_partial( $id, $args );
			}

			do_action(  self::with_prefix( 'customize_register_end', '_' ), self::get_instance(), $wp_customize );	

		}

		public static function add_control( $wp_customize, $id, $control ){
			switch( $control[ 'type' ] ){

				case 'color':

					unset( $control[ 'type' ] );
					$wp_customize->add_control( new WP_Customize_Color_Control( 
						$wp_customize, 
						$id, 
						$control
					) );

					break;

				case 'file':
				
					unset( $control[ 'type' ] );
					$wp_customize->add_control( new WP_Customize_Upload_Control( 
						$wp_customize, 
						$id, 
						$control
					) );

					break;	

				case 'image':

					$wp_customize->add_control( new WP_Customize_Image_Control(
						$wp_customize, 
						$id, 
						$control
			        ) );

					break;

				default:

					if( array_key_exists( $control[ 'type' ], self::$custom_controls ) ){
						
						$class = self::$custom_controls[ $control[ 'type' ] ][ 'class' ];
						unset( $control[ 'type' ] ); 
						$wp_customize->add_control( new $class( $wp_customize, $id, $control ) );
					}else{
						$wp_customize->add_control( $id, $control );
					}

				break;
			}
		}

		/**
		* Callback function of selective refresh.
		* 
		* @since  1.0.0
		* @param  object ( $object )
		* @access public
		* @return string
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function render_partial( $object ){
			echo esc_html( self::get( $object->id ) );
		}
	}
}

add_action( 'customize_register', array( Gutenbiz_Customizer::get_instance(), 'register' ) );

if( !function_exists( 'gutenbiz_get' ) ):
	/**
	 * Retrieve customizer option
	 *
	 * @param  string ( $id )
	 * @return string
	 * @since 1.0.0
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	function gutenbiz_get( $id ){
		$id = Gutenbiz_Helper::with_prefix( $id );
		return Gutenbiz_Customizer::get( $id );
	}

endif;