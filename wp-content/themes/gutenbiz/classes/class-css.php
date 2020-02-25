<?php
/**
 * Adds CSS to the theme
 *
 * @since 1.0.0
 * @package Gutenbiz WordPress Theme
 */
if( !class_exists( 'Gutenbiz_Css ' ) ):
	class Gutenbiz_Css extends Gutenbiz_Helper{

	   /**
		* Store arrays of css and selectors
		*
		* @static
		* @access protected
		* @since 1.0.0
		* @package Gutenbiz WordPress Theme
		*/
		protected static $styles = array( 'xs' => array(), 'sm' => array(), 'md' => array() );

		public function __construct(){
			add_action( 'wp_head', array( __CLASS__, 'print_styles' ), 99 );
		}

	   /**
		* Add styes to the array
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return null
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function add_styles( $style, $device = 'md' ){
			self::$styles[ $device ][] = $style;
		}

		protected static function get_css_unit( $prop ){
			switch( $prop ){

				case 'font-size':
				case 'margin-top':
				case 'margin-bottom':
				case 'margin-left':
				case 'margin-right':
				case 'padding-top':
				case 'padding-bottom':
				case 'padding-left':
				case 'padding-right':
				case 'border-radius':
				case 'border-width':
				case 'border-top-width':
				case 'min-height':
				case 'max-height':
					return 'px';
				case 'max-width':
					return 'px !important';
				default:
					return;
			}
		}
		
		/**
		 * Generates the css for theme
		 *
		 * @static
		 * @access protected
		 * @since 1.0.0
		 * @return null
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		
		protected static function generate_css( $dynamic_css ){
			
			if( count( $dynamic_css ) <= 0 )
				return;

			foreach( $dynamic_css as $css ){
				echo ( $css[ 'selector' ] ); ?>{
					<?php
						foreach( $css[ 'props' ] as $prop => $setting ){

							$unit = false;
							if( is_array( $setting ) ){
								$value = isset( $setting[ 'value' ] ) ? $setting[ 'value' ] : '';
								$unit  = $setting[ 'unit' ];

							}else{
								$value = gutenbiz_get( $setting );
								if( 'font-family' == $prop ){
									$value = esc_attr( self::get_font( $value ) ).", sans-serif";
								}elseif( 'content' == $prop ){
									$value = '"\\'. esc_attr( $value ).'"';
								}else{
									$value = esc_attr( $value );
								}
							}

							if( '' !== $value ){
								$unit = $unit ? $unit : self::get_css_unit( $prop );
								echo $prop . ': ' . $value . $unit . ';';
							}
						}
					?>
				}
			<?php
			}
		}

		/**
		* Print all the  styes scripts
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return null
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function process_css( $styles ){
			if( count( $styles ) > 0 ){
				foreach( $styles as $style ){
					self::generate_css( $style );
				}
			}
		}

		/**
		* Print all the  styes scripts
		*
		* @static
		* @access public
		* @since 1.0.0
		* @return null
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function print_styles(){
			?>
			<style type="text/css" media="all" id="<?php echo esc_attr( self::with_prefix( 'styles' ) ) ?>">
				<?php self::process_css( self::$styles[ 'md' ] ); ?>

				@media (max-width: <?php echo esc_html( is_customize_preview() ? 720 : 992 ) ?>px) {
					<?php self::process_css( self::$styles[ 'sm' ] ); ?>
				}

				@media (max-width: <?php echo esc_html( is_customize_preview() ? 320 : 767 ) ?>px) {
					<?php self::process_css( self::$styles[ 'xs' ] ); ?>
				}
			</style>
			<?php
		}
	}
endif;

new Gutenbiz_Css();