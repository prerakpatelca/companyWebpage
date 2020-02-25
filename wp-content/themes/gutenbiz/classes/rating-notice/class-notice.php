<?php
/**
 * Rating notice
 *
 * @since 1.0.3
 *
 * @package Gutenbiz WordPress Theme
 */

class Gutenbiz_Rating extends Gutenbiz_Helper{

	function __construct(){
		# assets enqueue
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'notice_scripts' ) );

		# theme rating message
		if( 'dismiss_notice' !== get_transient( 'rating_notice' ) ){
			add_action( 'admin_notices', array( __CLASS__, 'display_rating_notice' ), 20 );
		}
		# ajax call
		add_action( 'wp_ajax_rating_notice', array( __CLASS__, 'rating_notice' ) );
	}

	/**
	 * Enqueue required css and js
	 *
	 * @static
	 * @access public
	 * @since 1.0.1
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public static function notice_scripts(){
		$scripts = array(
			array(
			    'handler' => 'rating-script',
			    'script'  => 'classes/rating-notice/assets/rating.js',
			    'minified' => false,
			    'localize'	=> array(
			    	'key'	=> 'gutenbiz_rate_notice',
			    	'data'	=> array(  
			    		'admin_url'	=> admin_url( 'admin-ajax.php' )
			    	),
			    )
			),
		);

		self::enqueue( $scripts );
	}

	/**
	 * Display rating notice
	 *
	 * @static
	 * @access public
	 * @since 1.0.3
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public static function display_rating_notice(){
		get_template_part( 'classes/rating-notice/templates/admin', 'rating' );
	}

	/**
	 * Set time to show rating notice
	 *
	 * @static
	 * @access public
	 * @since 1.0.3
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public static function rating_notice() {
		set_transient( 'rating_notice', 'dismiss_notice', 3*MONTH_IN_SECONDS );
	}
}

new Gutenbiz_Rating;