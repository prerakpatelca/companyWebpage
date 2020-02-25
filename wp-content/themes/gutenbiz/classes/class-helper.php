<?php
/**
 * A helper class for theme
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress Theme
 */
if( !class_exists( 'Gutenbiz_Helper' ) ):
	class Gutenbiz_Helper{

		public static $object_counter = 0;

		/**
		 * Prefix for theme
		 *
		 * @return string
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		
		public static function get_prefix(){
			return GUTENBIZ_PREFIX;
		}

		/**
		 * Constructor of helper
		 *
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function __construct(){	

			# Prevent from calling it multiple times
			if( self::$object_counter == 0 ){

				# enqueue script for admin end
				add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );

				# get the active class of navigation bar
				add_filter( 'nav_menu_css_class', array( __CLASS__ , 'get_nav_active_class' ) );
				# check if SEO plugin is active and add the primary category
				add_filter( 'get_the_categories', array( __CLASS__ , 'modify_catgories' ) );
				# the excerpt length defination 
				add_filter( 'excerpt_length', array( __CLASS__, 'custom_excerpt_length' ) );

				# excerpt more defination
				add_filter( 'excerpt_more', array( __CLASS__, 'excerpt_more' ) );

				# add skip to content markup for accessibility
				add_action( self::with_prefix( 'after_body', '_' ), array( __CLASS__, 'skip_content' ) );

				# add preloader
				add_action( self::with_prefix( 'after_body', '_' ), array( __CLASS__, 'the_preloader' ) );
				
				# add open tag for header
				add_action( self::with_prefix( 'header', '_' ), array( __CLASS__, 'before_header' ), 5 );

				# add closing tag for header
				# makek sure this function executes at last
				add_action( self::with_prefix( 'header', '_' ), array( __CLASS__, 'after_header' ), 99 );

				# display tag
				add_action( 'after_setup_theme', array( __CLASS__, 'setup' ) );

				self::$object_counter++;
			}		
		}		

		/**
		 * print open tag for header
		 *
		 * @since 1.0.0
		 * @return string
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function before_header(){
			?>
			<header id="masthead" <?php self::schema_body( 'header' ); ?> class="<?php echo esc_attr( self::with_prefix( 'site-header' ) ) ?>">
			<?php
		}

		/**
		 * print close tag for header
		 *
		 * @since 1.0.0
		 * @return string
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function after_header(){
			?>
			</header>
			<?php
		}		

		/**
		 * print markup for skip to content
		 *
		 * @since 1.0.0
		 * @return string
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function skip_content(){
			?>
			<a class="skip-link screen-reader-text" href="#content">
				<?php esc_html_e( 'Skip to content', 'gutenbiz' ); ?>
			</a>
			<?php
		}

		/**
		 * Inner banner image
		 *
		 * In page or post feature image will appear and if home page is latest
		 * blog page then the image can be controlled from customizer 
		 *
		 * @return string
		 * @return boolean
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function the_header_image(){

			if( !is_attachment() && ( is_single() || is_page() ) && has_post_thumbnail() ){
				$src = get_the_post_thumbnail_url( get_the_ID(), 'full' );
			}elseif( has_header_image() ){
				$src = get_header_image();
			}

			if( isset( $src ) ){
				echo 'style="background-image: url( '. esc_url( $src ) .' )"';
			}
		}

		/**
		 * get string with a prefix
		 *
		 * @since 1.0.0
		 * @return string
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function with_prefix( $content, $append = '-', $prepend = '', $imploder = ' ' ){
			if( is_array( $content ) ){

				$prefix_cls = array();
				foreach( $content as $c ){
					$prefix_cls[] = $prepend . self::get_prefix() . $append . trim( $c );
				}
				return implode( $imploder, $prefix_cls );
			}else{
				return $prepend . self::get_prefix() . $append . trim( $content );
			}
		}

		public static function with_prefix_selector( $content ){
			return str_replace( '%s', '.' . self::get_prefix(), $content );
		}

		/**
		 * Adds unique text in the excerpt
		 *
		 * @return string
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */		
		public static function excerpt_more( $text = false ){
			if( is_admin() ){
				return $text;
			}
			return '%' . self::get_prefix() . '-readmore%';
		}

		/**
		* Adds prefix to the classes
		*
		* @static
		* @access public
		* @since  1.0.0
		* @return string
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_class( $cls ){
			if( is_array( $cls ) ){
				foreach ($cls as $class) {
					$prefix_cls[] = self::get_prefix() . '-' . $class;
				}
				return implode( ' ', $prefix_cls );
			}else{
				return self::get_prefix() . '-' . $cls;
			}
		}

		/**
		 * Get the comment number of post
		 *
		 * @since 1.0.0
		 * @return void
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_comment_number(){
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="gutenbiz-comments">';
				comments_popup_link(
					'<i class="fa fa-comment"></i> '.esc_html__( 'Leave a comment', 'gutenbiz' ),		
					'<i class="fa fa-comment"></i> '.esc_html__( '1 response', 'gutenbiz' ),
					'<i class="fa fa-comments"></i> % '. esc_html__( 'responses' , 'gutenbiz' )
				);
				echo '</span>';
			}
		}		

		/**
		* Setup Theme
		*
		* @static
		* @access public
		* @since  1.0.0
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function setup(){
			# header options
			add_theme_support( 'custom-header', apply_filters( self::with_prefix( 'custom_header_args', '_') , array(
				'default-text-color' => '000000',
				'width'              => 1366,
				'height'             => 400,
				'flex-height'        => true,
				'wp-head-callback'   => array( __CLASS__, 'header_style' ),
				'default-image'      => '',
			)));
		}

		/**
		 * Enqueue styles and scripts on admin end
		 *
		 * @static
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function admin_scripts(){

			$scripts = array(
			    array(
			        'handler'  => self::with_prefix( 'admin-css' ),
					'style'    => 'assets/css/admin.css',
					'minified' => false
			    ),
			);
			self::enqueue( $scripts );
		}

		/**
		* Add custom header
		*
		* @static
		* @access public
		* @since  1.0.0
		* @return void
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function header_style(){
			
			$header_text_color = get_header_textcolor();
			/*
			 * If no custom options for text are set, let's bail.
			 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
			 */
			if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
				return;
			}
			$style = array();

			if ( ! display_header_text() ){
				$style[] = array(
					'selector' => '.site-title, .site-description',
					'props' => array(
						'position' => array(
							'value' => 'absolute',
							'unit'  => ''
						),
						'clip' => array(
							'value' => 'rect(1px, 1px, 1px, 1px)',
							'unit'  => ''
						)
					)
				);
			}else{
				
				$style[] = array(
					'selector' => '.site-branding .site-title a, .site-branding .site-description',
					'props' => array(
						'color' => array(
							'value' => '#' . esc_attr( $header_text_color ),
							'unit'  => ''
						),
					)
				);
			}

			Gutenbiz_Css::add_styles( $style );
		}

		/**
		 * get post meta by Post ID
		 *
		 * @link https://developer.wordpress.org/reference/functions/get_post_meta/
		 * @return string || integer || array
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_meta( $meta_key = false, $post_id = null,  $single = true  ){
			if( $meta_key ){
				$meta_key = self::with_prefix( $meta_key );
				if( !is_front_page() && is_home() ){
					$post_id = get_option( 'page_for_posts' );
				}else{
					$post_id = $post_id ? $post_id : get_the_ID();
				}
				return get_post_meta( $post_id, $meta_key, $single );
			}
		}

		/**
		 * Get uri of given file
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_theme_uri( $file ){
			return get_theme_file_uri( $file );
		}
		/**
		 * Get path of given file
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_theme_path( $file ){
			return get_theme_file_path( $file );
		}

		/**
		 * Adds schema tags to the body classes.
		 *
		* @static
		* @access public
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		 */
		public static function schema_body( $type ) {
			switch ($type) {
				case 'body' :	
					# Check conditions.
					$is_blog = ( is_home() || is_archive() || is_attachment() || is_tax() || is_single() ) ? true : false;

					# Set up default itemtype.
					$itemtype = 'WebPage';

					# Get itemtype for the blog.
					$itemtype = ( $is_blog ) ? 'Blog' : $itemtype;

					# Get itemtype for search results.
					$itemtype = ( is_search() ) ? 'SearchResultsPage' : $itemtype;
					# Get the result.
					$result = apply_filters( self::with_prefix( 'schema_body_itemtype', '_'), $itemtype );

					# Return our HTML.
					echo apply_filters( self::with_prefix( 'schema_body', '_'), "itemtype='https://schema.org/" . esc_attr( $result ) . "' itemscope='itemscope' " );
				break;

				case 'header' :
					echo apply_filters( self::with_prefix( 'schema_header', '_'), "itemtype='https://schema.org/WPHeader' itemscope='itemscope' role='banner' " );
				break;

				case 'footer' :
				echo apply_filters( self::with_prefix( 'schema_footer', '_'), "itemtype='https://schema.org/WPFooter' itemscope='itemscope' role='contentinfo'" );
				break;

				case 'article':
					echo apply_filters( self::with_prefix( 'schema_article', '_'), "itemtype='https://schema.org/CreativeWork' itemscope='itemscope'" );
				break;

				default :
			}
		}

		/**
		 * Include given files
		 *
		 * @static
		 * @access public
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function include( $name, $dir="classes", $prefix="class" ){

			$prefix = empty( $prefix ) ? '' : $prefix . '-';
			
			$path = self::get_theme_path( '/' . $dir . '/' . $prefix );
			if( is_array( $name ) ){
				foreach( $name as $file ){
					require_once  $path . $file . '.php';
				}
			}else{
				require_once $path . $name . '.php';
			}
		}

		/**
		 * Enqueue scripts or styles
		 *
		 * @static
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function enqueue( $scripts ){ 

		    # Do not enqueue anything if no array is supplied.
		    if( ! is_array( $scripts ) ) return;

		    $scripts = apply_filters( self::with_prefix( 'block_scripts', '_') , $scripts );
		    $assets_version = self::get_assets_version();
		    foreach ( $scripts as $script ) {

		        # Do not try to enqueue anything if handler is not supplied.
		        if( ! isset( $script[ 'handler' ] ) )
		            continue;

		        $version = null;
		        if( isset( $script[ 'version' ] ) ){
		            $version = $script[ 'version' ];
		        }

		        $minified = isset( $script[ 'minified' ] ) ? $script[ 'minified' ] : true;
		        # Enqueue each vendor's style
		        if( isset( $script[ 'style' ] ) ){

		            $path = isset( $script[ 'absolute' ] ) ? $script[ 'style' ] : self::get_theme_uri( $script[ 'style' ] );

		            $dependency = array();
		            if( isset( $script[ 'dependency' ] ) ){
		                $dependency = $script[ 'dependency' ];
		            }

	            	if( 'production' == $assets_version && $minified ){
	            		$path = str_replace( '.css', '.min.css', $path );
	            	}
	           
		            wp_enqueue_style( $script[ 'handler' ], $path, $dependency, $version );

		        }

		        # Enqueue each vendor's script
		        if( isset( $script[ 'script' ] ) ){

		        	if( $script[ 'script' ] === true || $script[ 'script' ] === 1 ){
		        		wp_enqueue_script( $script[ 'handler' ] );
		        	}else{

			            $prefix = '';
			            if( isset( $script[ 'prefix' ] ) ){
			                $prefix = $script[ 'prefix' ];
			            }

			        	$path = '';
			        	if( isset( $script[ 'script' ] ) ){
			            	$path = self::get_theme_uri( $script[ 'script' ] );
			        	}

			            if( isset( $script[ 'absolute' ] ) ){
			                $path = $script[ 'script' ];
			            }

			            $dependency = array( 'jquery' );
			            if( isset( $script[ 'dependency' ] ) ){
			                $dependency = $script[ 'dependency' ];
			            }

			            $in_footer = true;

			            if( isset( $script[ 'in_footer' ] ) ){
			            	$in_footer = $script[ 'in_footer' ];
			            }

			            if( 'production' == $assets_version && $minified ){
			            	$path = str_replace( '.js', '.min.js', $path );
			            }
			            wp_enqueue_script( $prefix . $script[ 'handler' ], $path, $dependency, $version, $in_footer );

			            if( isset( $script['localize'] ) && count( $script['localize'] ) > 0 ) {
			            	wp_localize_script($prefix . $script[ 'handler' ] , $script['localize']['key'] , $script['localize']['data'] );
			            }
		        	}
		        }
		    }
		}

		/**
		* Get assets version (development || production)
		*
		* @static
		* @access public
		* @return string
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_assets_version(){
			return gutenbiz_get( 'assets-version' );
		}

		/**
		* Creats slug of the text 
		*
		* @static
		* @access public
		* @return string
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function uglify( $text, $condition = array() ){
			$defaults = array(
				'lowercase' => true,
				'separator' => '-',
			);
			# Parse incoming $args into an array and merge it with $defaults
			$args = wp_parse_args( $condition, $defaults );
			$text = str_replace ( ' ', $args[ 'separator' ] , $text );
			if( $args[ 'lowercase' ] ){
				$text = strtolower( $text );
			}			
			return $text;
		}

		/**
		 * Fallback for primary menu.
		 *
		 * @static
		 * @access public
		 * @return void
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function primary_menu_fb( $arg ) {
		    if( !$arg[ 'echo' ] ){
		        ob_start();
		    }
		    ?>
		    <ul>
		        <li>
		            <a href="<?php echo esc_url( home_url( '/' ) ) ?>"><?php esc_html_e( 'Home', 'gutenbiz' ) ?></a>
		        </li>
		    </ul>
		    <?php
		    if( !$arg[ 'echo' ] ){
		        $data = ob_get_contents();
		        ob_end_clean();
		        return $data;
		    }
		}

		/**
		* Returns wp nav
		*
		* @static
		* @access public
		* @return string
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_menu( $location = 'primary', $echo = false ){

		    $menu = null;

		    $args = array(
		        'theme_location' => $location,
		        'fallback_cb'    => false,
		        'echo'           => $echo,
		        'container'      => false
		    );
		    switch( $location ){

		        case 'primary':
		            $args[ 'fallback_cb' ] = array( __CLASS__, 'primary_menu_fb' );
		            $args[ 'menu_id' ] = 'primary-menu';
		            $args[ 'menu_class' ] = 'navigation clearfix';  
		        break;
		    }

	        $menu = wp_nav_menu(  $args );

		    if( ! $echo ){
		        return $menu;
		    } 
		}

		/**
		* The post Navigation
		*
		* @static
		* @access public
		* @return object
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function posts_navigation( $echo = true ) {
			$infinity_module_active = false;
			if( get_option( 'jetpack_active_modules' ) ){
				if( in_array( 'infinite-scroll', get_option( 'jetpack_active_modules' ) ) ){
					$infinity_module_active = true;
				}
			}
			# Previous/next page navigation.
			if( !$infinity_module_active || !Gutenbiz_Helper::is_active_plugin( 'jetpack' ) ){				
				the_posts_pagination(
					array(
						'mid_size'  => 2,
						'prev_text' => esc_html__( 'Previous', 'gutenbiz' ),
						'next_text' => esc_html__( 'Next', 'gutenbiz' ),
					)
				);
			}
		}

		/**
		* Pagination for the content seperated by page break.
		*
		* @static
		* @access public
		* @return object
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function post_content_navigation(){
			wp_link_pages( array(
				'before'      => '<div class="page-links">' . esc_html__( 'Pages:', 'gutenbiz' ),
                'after'       => '</div>',
                'link_before' => '<span class="page-number">',
                'link_after'  => '</span>'
			) );
		}

		/**
		* Pagination for single post in single page
		*
		* @static
		* @access public
		* @return object
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function single_post_navigation(){
			the_post_navigation( array(
				'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Previous Post', 'gutenbiz' ) . '</span><span class="nav-title">%title</span>',
				'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next Post', 'gutenbiz' ) . '</span><span class="nav-title">%title</span>',
			));
		}

		/**
		 * Displays an optional post thumbnail.
		 *
		 * Wraps the post thumbnail in an anchor element on index views, or a div
		 * element when on single views.
		 *
		 * @static
		 * @access public
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function post_thumbnail( $size = 'post-thumbnail' ) {
			if ( has_post_thumbnail() ) { ?>
				<figure class="post-thumbnail">
					<?php the_post_thumbnail( $size ); ?>
				</figure>
			<?php }
		}

		/**
		* Returns the permalink of Post day
		*
		* @since 1.0.0
		* @return url
		*
		* Gutenbiz WordPress Theme
		*/
		public static function get_day_link(){
			return get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d') );
		}

		/**
		 * Author image
		 *
		 * @static
		 * @access public
		 * @return void
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_author_image(){
			if( apply_filters( self::with_prefix( 'show_post_author', '_'), true ) ){
				$author_id = get_the_author_meta( 'ID' );
				printf(
					'<div class="author-image">
						<a class="url fn n" href="%1$s">
								<img src="%2$s">
						</a>
					</div>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr( get_avatar_url( $author_id, array( 'size'=> 40 ) ) )
				);
			}
		}
		/**
		 * Prints HTML with meta information about theme author.
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function posted_by(){
			if( apply_filters( self::with_prefix( 'show_post_author', '_' ), true ) ):
				printf(
					/* translators:1-author link, 2-author image link, 
					 * 3- author text, 4- author name.
					 */
					'<span class="author-text">
						%2$s
					</span>
					<a class="url fn n" href="%1$s">
						<span class="author">
							%3$s
						</span>
					</a>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_html__( 'By ', 'gutenbiz' ),
					esc_html( get_the_author() )
				);
			endif;
		}

		/**
		 * Prints HTML with meta information for the current post-date/time.
		 *
		 * @static
		 * @access public
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function the_date( $status = 'posted' ) {
			
			$show = apply_filters( self::with_prefix( 'show_post_date', '_' ), true );

			if( $show ):
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

				if( $status == 'updated'){
					if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
						$time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
					}				
				}

				$time_tag = sprintf(
					$time_string,
					esc_attr( get_the_date( DATE_W3C ) ),
					esc_html( get_the_date( get_option('date_format') ) ),
					esc_attr( get_the_modified_date( DATE_W3C ) ),
					esc_html( get_the_modified_date() )
				);

				printf(
					'<span class="posted-on">
						%2$s 
						<a href="%1$s" rel="bookmark">
							%3$s
						</a>
					</span>',
					esc_url( self::get_day_link() ),
					( 'posted' == $status ) ? esc_html__( 'On', 'gutenbiz' ) : esc_html__( 'Updated on', 'gutenbiz' ),
					$time_tag
				);
			endif;
		}

		/**
		 * Prints the category of the posts
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function the_category(){
			$show = apply_filters( self::with_prefix( 'show_post_category', '_'), true );
			if( $show ){ 
				the_category(); 
			}
		}
		
		/**
		 * edit link on post if user is logged in
		 *
		 * @return void
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function edit_link(){
			edit_post_link(
				sprintf(
					'%1$s<span class="screen-reader-text">%2$s</span>',
					esc_html__( 'Edit', 'gutenbiz' ),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
		}

		/**
		 * modify category if SEO plugin is active
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */		
		public static function modify_catgories( $categories ){

			# Check if Yoast Plugin is installed 
			# If yes then, get Primary category, set by Plugin
			if ( self::is_active_plugin( 'yoast' ) ){

			    # Show the post's 'Primary' category, if this Yoast feature is available, & one is set
			    $wpseo_primary_term = new WPSEO_Primary_Term( 'category', get_the_ID() );
			    $wpseo_primary_term = $wpseo_primary_term->get_primary_term();

			    $cat[0] = get_term( $wpseo_primary_term );

			    if ( !is_wp_error( $cat[0] ) ) {
			    	return $cat;
			    }
			}
			
			return $categories;
		}

		/**
		 * Get active class of the menu.
		 *
		 * @static
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		
		public static function get_nav_active_class ( $classes ) {
		    if ( in_array( 'current-menu-item', $classes ) ){
		        $classes[] = 'active';
		    }
		    return $classes;
		}

		/**
		 * Add action to display breadcrumb.
		 *
		 * @static
		 * @access public
		 * @return void
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function the_breadcrumb(){
			// Bail if Breadcrumb disabled
			if( apply_filters( self::with_prefix( 'show_breadcrumb', '_' ), true ) ): 
			    # Bail if Home Page
			    
			    $breadcrumb_args = array(
			        'container'   => 'div',
			        'show_browse' => false,
			    );
			    $classes = apply_filters( self::with_prefix( 'breadcrumb_classes', '_'), array( 'wrapper', 'wrap-breadcrumb' ) );
			    $classes = array_unique( $classes );
			    $classes = join( ' ', $classes );
			    ?>
			    <div id="<?php echo esc_attr( self::with_prefix( 'breadcrumb' ) ) ?>" class="<?php echo esc_attr( $classes ); ?>">
			    	<?php gutenbiz_breadcrumb_trail( $breadcrumb_args ); ?>
				</div><!-- #breadcrumb -->
			    <?php return;
			endif;
		}

		/**
		 * Add action to display inner banner
		 *
		 * @static
		 * @access public
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function the_inner_banner(){
			?>
			<div class="<?php echo esc_attr( self::with_prefix( 'inner-banner' ) ) ?>">
				<header class="entry-header">
					<?php 
						if( is_page() || is_singular() ){
							the_title( '<h1 class="entry-title">', '</h1>' );
						}elseif(  is_archive() ){
							the_archive_title( '<h2 class="entry-title">', '</h2>' );
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
						}elseif( is_home() ){
							# when home page is latest posts the custom title.
							$blog_title = apply_filters( self::with_prefix( 'blog_title', '_'), true );
							?>
							<h2 class="entry-title"><?php echo esc_html( $blog_title ) ?></h2>
							<?php
						}elseif(  is_search() ){
							get_search_form();
							/* translators: %s: search page result */ 
							?>
							<h2 class="entry-title">
								<?php 
									printf( 
										esc_html__( 'Search Results for: %s', 'gutenbiz' ), 
										'<span>' . get_search_query() . '</span>' 
									);
								?>
							</h2>
							<?php
						}
					?>
				</header><!-- .entry-header -->
			</div>			
		<?php }

		/**
		 * Add class position to display text in inner banner
		 *
		 * @static
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_inner_banner_class(){
		    $classes = apply_filters( self::with_prefix( 'inner_banner_classes', '_'), array( ) );
		    $classes = array_unique( $classes );
		    $classes = join( ' ', $classes );
		    return $classes;
		}

		/**
		 * Filter the except length to 20 words.
		 *
		 * @param int $length Excerpt length.
		 *
		 * @static
		 * @access public
		 * @return int (Maybe) modified excerpt length.
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function custom_excerpt_length( $length ) {
			$excerpt_length = apply_filters( self::with_prefix( 'excerpt_length', '_'), $length );
		    return $excerpt_length;
		}

		/**
		 * Adds the Preloader
		 *
		 * @static
		 * @access public
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function the_preloader(){
		 	# pre loader
		 	$show_preloader = apply_filters( self::with_prefix( 'show_preloader', '_'), true ); 
		 	if( $show_preloader ): ?>
				<div id="loader-wrapper">
				    <div id="loader"></div>
				</div>
			<?php endif;
		}

		/**
		 * Displays the theme tags
		 *
		 * @static
		 * @access public
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */		
		public static function display_tag_list(){
			$tags_list = get_the_tag_list( '', ', ' );
			if ( $tags_list ) {
				printf(
					/* translators: 1: posted in label, only visible to screen readers. 2: list of tags. */
					'<span class="tags-links"><span class="screen-reader-text">%2$s </span>%3$s</span>',
					esc_html__( 'Tags:', 'gutenbiz' ),
					esc_html( $tags_list )
				); // WPCS: XSS OK.
			}
		}

		/**
		 * Replace dash by space
		 *
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function beautify( $string ){
		    return ucwords( str_replace( '-', ' ', $string ) );
		}

		/**
		 * Check the plugin is active or not
		 *
		 * @static
		 * @access public
		 * @return boolean
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function is_active_plugin( $plugin_name ){
			switch( $plugin_name ){

				case 'woocommerce':
					return class_exists( 'WooCommerce' );
				break;

				case 'yoast':
					return class_exists( 'WPSEO_Primary_Term' );
				break;

				case 'jetpack':
					return class_exists( 'Jetpack' );
				break;
			}
			return false;
		}

		/**
		 * Get body font family.
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_font( $value ){
			$fonts = self::get_font_family();
			return  $fonts[ $value ];
		}

		/**
		* Font family used in Gutenbiz Theme
		*
		* @static
		* @access public
		* @return object
		* @since  1.0.0
		*
		* @package Gutenbiz WordPress Theme
		*/
		public static function get_font_family( ){
			return apply_filters( self::with_prefix( 'standard_fonts_array', '_'), array(
				'font-1'  => esc_html__( 'Lato', 'gutenbiz' ),
				'font-2'  => esc_html__( 'Oswald', 'gutenbiz' ),
				'font-3'  => esc_html__( 'Montserrat', 'gutenbiz' ),
				'font-4'  => esc_html__( 'Roboto', 'gutenbiz' ),  
				'font-5'  => esc_html__( 'Raleway', 'gutenbiz' ),  
				'font-6'  => esc_html__( 'Playfair Display', 'gutenbiz' ),  
				'font-7'  => esc_html__( 'Fjalla One', 'gutenbiz' ),  
				'font-8'  => esc_html__( 'Alegreya Sans', 'gutenbiz' ),
				'font-9'  => esc_html__( 'PT Sans Narrow', 'gutenbiz' ),
				'font-10' => esc_html__( 'Open Sans', 'gutenbiz' ),
				'font-11' => esc_html__( 'Poppins', 'gutenbiz' ),
			));
		}

		/**
		 * Google font url
		 *
		 * @static
		 * @access public
		 * @return string
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */		
		public static function get_google_font(){
			$google_fonts = array();
			$condition = array(
				'lowercase' => false,
				'separator' => '+',
			);
			
			$google_fonts[] = self::uglify( self::get_font( gutenbiz_get( 'body-font' ) ), $condition );
			$google_fonts[] = self::uglify( self::get_font( gutenbiz_get( 'heading-font' ) ), $condition );
			$google_fonts[] = self::uglify( self::get_font( gutenbiz_get( 'site-info-font' ) ), $condition );
			$fonts =  array_unique( $google_fonts );
			$fonts_weight = array(
				'Lato' => array(
					'100',
					'200',
					'300',
					'500'
				),
				'Open+Sans' => array(
					'100',
					'200',
					'300',
					'400'
				),
				'Montserrat' => array(
					'100',
					'200',
					'300',
				),
				'Poppins' => array(
					'400',
					'500',
					'600',
					'700',
					'800',
			));
			foreach ( $fonts as $value ) {
				if( isset( $fonts_weight[ $value ] ) ){
					$font_wt[] = $value.':'.implode( ',', $fonts_weight[ $value ] );
				}else{
					$font_wt[] = $value;
				}
			}

			if( $font_wt ){
				$fonts_url = add_query_arg(
					array( 
						'family' => implode( '|', $font_wt ),
					), '//fonts.googleapis.com/css' 
				);
			}
			return $fonts_url;
		}

		/**
		 * Get the title
		 *
		 * @return string
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_title( $link = true ){ ?>
			<h2 class="post-title">
				<?php if( $link ) : ?>
					<a href="<?php the_permalink();?>">
						<?php the_title(); ?>
					</a>
				<?php else : ?>
					<?php the_title() ?>
				<?php endif; ?>				
			</h2>
			<?php self::edit_link(); ?>
		<?php }

		/**
		 * Home page is latest post page
		 *
		 * @return string
		 * @return boolean
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function is_latest_post_page(){
			return ( is_front_page() && is_home() );
		}

		/**
		 * Home page is static page
		 *
		 * @return string
		 * @return boolean
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function is_static_front_page(){
			return ( is_front_page() && !is_home() );
		}

		/**
		 * display icons with respective post format
		 *
		 * @since 1.0.0
		 * @return void
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function post_format_icon(){
			switch ( get_post_format() ){

				case 'aside':
					$icon = 'fa fa-sitemap';
				break;

				case 'gallery':
					$icon = 'fa fa-file-image-o';
				break;

				case 'link':
					$icon = 'fa fa-link';
				break;

				case 'image':
					$icon = 'fa fa-picture-o';
				break;

				case 'quote':
					$icon = 'fa fa-quote-right';
				break;

				case 'status':
					$icon = 'fa fa-user';
				break;

				case 'video':
					$icon = 'fa fa-video-camera';
				break;

				case 'audio':
					$icon = 'fa fa-volume-up';
				break;

				default:
					$icon = false;
			}?>
			<?php if( $icon ): ?>
				<a class="<?php echo esc_attr( self::with_prefix( 'post-type-icon' ) ) ?>" href="<?php the_permalink() ?>">
					<i class="<?php echo esc_attr( $icon ) ?>"></i>
				</a>
			<?php endif; ?>
		<?php }						
	}
endif;