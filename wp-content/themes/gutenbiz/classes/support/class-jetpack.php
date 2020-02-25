<?php
/**
 * Activate Jetpack Plugin Support
 *
 * @since 1.0.1
 *
 * @package Gutenbiz WordPress theme
 */
class Support_Jetpack extends Gutenbiz_Helper{
	/**
	 * constructor
	 *
	 * @since 1.0.1
	 *
	 * @package Gutenbiz WordPress Theme
	 */
	public function __construct(){
		add_action( 'after_setup_theme', array( __CLASS__ , 'jetpack_infinity_scroll' ) );
	}

	/**
	* Jetpack Plugin support
	*
	* @static
	* @access public
	* @since  1.0.1
	* @return array
	*
	* @package Gutenbiz WordPress Theme
	*/
	public static function jetpack_infinity_scroll(){

		add_theme_support( 'infinite-scroll', array(
		    'container'      => 'load-more',
		    'footer_widgets' => false,
		    'wrapper'        => true,
		    'render'         => array( __CLASS__, 'infinite_scroll_render' ),
		) );
	}

	/**
	* Load more posts in infinity scroll
	*
	* @static
	* @access public
	* @since  1.0.1
	*
	* @package Gutenbiz WordPress Theme
	*/
	public static function infinite_scroll_render() {
	    while (have_posts()) {
	    	?>
		    <div class="<?php echo esc_attr( Gutenbiz_Theme::is_sidebar_active() ? 'col-md-6 col-lg-6' : 'col-md-4 col-lg-4' ); ?>">
		    	<?php
			        the_post();
			        get_template_part( 'templates/content/content' ); 
		        ?>
	        </div>
	    <?php }
	}
}

new Support_Jetpack();