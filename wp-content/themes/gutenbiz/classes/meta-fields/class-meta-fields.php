<?php 
/**
 * Provides a framework for creating post types, taxonomies and meta field
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress Theme
 */

# Make a separate class for Registering and dealing with custom post types.
if( !class_exists( 'Gutenbiz_Meta_Fields' ) ):
	class Gutenbiz_Meta_Fields extends Gutenbiz_Helper{
		
		/**
		* Stores Post Type Name.
		* 
		* @since  1.0.0
		* @access public
		* @var    string
		*
		* @package Gutenbiz WordPress Theme
		*/
		public $post_type;

		/**
		* Stores info about meta boxes added by user.
		* 
		* @since  1.0.0
		* @access public
		* @var    object
		*
		* @package Gutenbiz WordPress Theme
		*/
		public $meta_boxes = array();

		/**
		 * constructor
		 *
		 * @since 1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function __construct( $name ){
		    
		    parent::__construct();

		    # Initializing Variables
		    $this->post_type = self::uglify( $name ); 

		    # Listen for the save post hook
		    add_action( 'save_post', array( $this, 'save' ) );
		}

		/**
		 * Get default value for meta box
		 *
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function get_value( $value, $field ){
			if( empty( $value ) && is_array( $field ) && isset( $field[ 'default' ] ) ){
				$value = $field[ 'default' ];
			}
			return $value;
		}

		public static function label( $field ){

			if( !isset( $field[ 'label' ] ) )
				return;
			?>
			<label class="components-base-control__label" for="<?php echo esc_attr( $field[ 'id' ] ); ?>">
				<?php echo esc_html( $field[ 'label' ] ); ?>
			</label>
			<?php
		}

		public static function description( $field ){
			if( !isset( $field[ 'description' ] ) )
				return;
			?>
			<p>
				<i>
					<?php echo esc_html( $field[ 'description'] ); ?>
				</i>
			</p>
			<?php
		}

		/**
		 * Renders the html for respective type
		 *
		 * @static
		 * @access public
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function render_field( $field ){

			if( !( is_array( $field ) && isset( $field[ 'type' ] ) ) )
				return;

			$id    = $field[ 'id' ];
			$value = $field[ 'value' ];

			$placeholder = '';
			if( isset( $field[ 'placeholder'] ) ){
				$placeholder = $field[ 'placeholder'];
			}
			echo '<div class="components-base-control">';
			switch( $field[ 'type' ] ){

				case 'radio':
					?>
					<div class="components-base-control__field <?php echo esc_attr( self::get_class( 'meta-radio' ) ); ?>">
						<?php  
							self::label( $field );
							self::description( $field );
							foreach( $field[ 'choices' ] as $key => $option ):
						?>
								<div>
									<input 
										id="<?php echo esc_attr( $key ); ?>"
										type="radio"
										name="<?php echo esc_attr( $id ); ?>"
										value="<?php echo esc_attr( $key ); ?>" 
										<?php checked( $key, $value ); ?> 
									>
									<label for="<?php echo esc_attr( $key ); ?>">
										<?php echo esc_html( $option ); ?>
									</label>
								</div>
						<?php endforeach; ?>		
					</div>
					<?php
				break;

				case 'select':

					?>
					<div class="components-base-control__field <?php echo esc_attr( self::get_class( 'meta-select' ) ); ?>">
						<?php  
							self::label( $field );
							self::description( $field );
						?>
						<select class="components-select-control__input" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id ); ?>">
							<?php foreach( $field[ 'choices' ] as $key => $option ): ?>
								<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $value ); ?> >
									<?php echo esc_html( $option ); ?>
								</option>
							<?php endforeach; ?>	
						</select>
					</div>	
					<?php
				break;

				case 'checkbox':
					?>
					<div class="components-base-control__field <?php echo esc_attr( self::get_class( 'meta-checkbox' ) ); ?>">
						<input 
							type="checkbox" 
							id="<?php echo esc_attr( $id ); ?>" 
							name="<?php echo esc_attr( $id ); ?>" 
							<?php checked( 'on', $value, true ); ?>
						>
						<?php  
							self::label( $field );
							self::description( $field );
						?>
					</div>
					<?php
				break;
				default:
					?>
					<div class="components-base-control__field <?php echo esc_attr( self::get_class( 'meta-text' ) ); ?>">
						<?php  
							self::label( $field );
							self::description( $field );
						?>
						<input 
							id="<?php echo esc_attr( $id ); ?>"
							type="<?php echo esc_attr( $field[ 'type' ] ); ?>" 
							class="components-text-control__input" 
							value="<?php echo esc_attr( $value ); ?>" 
							name="<?php echo esc_attr( $id ); ?>" 
							placeholder="<?php echo esc_attr( $placeholder ) ?>"
						>
					</div>
					<?php
				break;
			}
			echo '</div>';
		}

		/**
		 * Returns the sanitized value
		 *
		 * @access public
		 * @return string
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public static function sanitize( $field ){

			$value = $field[ 'value' ];

			switch( $field[ 'type' ] ){
			    
				case 'radio':
				case 'select':
				case 'checkbox':
				    $value = sanitize_key( $value );
				break;

				default:
					$value = wp_kses_post( $value );
				break;
			}

			return $value;
		}

		/**
		 * Stores all the meta boxes into the array and add it for registration.
		 *
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function add_meta_box( $title, $fields = array(), $context = 'side', $priority = 'default' ){
			
			add_action( 'load-post.php', array( $this, 'init_metabox' ) );
			add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );

			$boxes = array(
				'id'       => self::uglify( $title ),
				'title'    => self::beautify( $title ),
				'fields'   => $fields,
				'context'  => $context,
				'priority' => $priority
			);

			$this->meta_boxes[] = $boxes;
		}

		public function init_metabox(){
			add_action( 'add_meta_boxes', array( $this, 'register_meta_box' ) );
		}

		/**
		 * Registers all the meta boxes from the array.
		 *
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function register_meta_box(){
			if( is_array( $this->meta_boxes ) ){
				foreach( $this->meta_boxes as $meta ){
					add_meta_box( 
						$meta[ 'id' ], 
						$meta[ 'title' ], 
						array( $this, 'render_meta_box' ), 
						$this->post_type, 
						$meta[ 'context' ], 
						$meta[ 'priority' ], 
						$meta[ 'fields' ] 
					);
				}
			}
		}

		/**
		 * Displayes the meta box.
		 *
		 * @access public
		 * @return void
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function render_meta_box( $post, $box ){

			if( !is_array( $box[ 'args' ] ) )
				return;
			wp_nonce_field( self::with_prefix( 'meta_nonce' ), self::with_prefix( 'name_meta_nonce' ) );
			?>
			<div class="<?php echo esc_attr( self::get_class( 'meta-box-wrapper' ) ); ?>">
				<?php 
					$count = 0; 
					foreach( $box[ 'args' ] as $id => $field ): 
						$id = self::with_prefix( self::uglify( $id ) );
				?>
					<div id="<?php echo esc_attr( $id ); ?>-wrapper" class="components-base-control__field <?php echo esc_attr( self::get_class( 'meta-box-item' ) ); ?>">
						<?php 
							$field[ 'id' ]    = $id;
							$field[ 'post' ]  = $post;
							$v = get_post_meta( $post->ID, $id, true );
							$field[ 'value' ] = self::get_value( $v, $field );
							self::render_field( $field );
						?>
					</div>
				<?php 
					$count++; 
					endforeach; 
				?>
			</div>
			<?php
		}

		/**
		 * Action when the post or page get updated or saved.
		 *
		 * @access public
		 * @return object
		 * @since  1.0.0
		 *
		 * @package Gutenbiz WordPress Theme
		 */
		public function save( $post_id ){
	      	
	      	$p = wp_unslash( $_POST );
	      	$is_autosave    = wp_is_post_autosave( $post_id );
			$is_revision    = wp_is_post_revision( $post_id );

			if ( $is_autosave || $is_revision || empty( $p ) || ! isset(  $p[ self::with_prefix( 'name_meta_nonce' ) ] ) || ! wp_verify_nonce( $p[ self::with_prefix( 'name_meta_nonce' ) ], self::with_prefix( 'meta_nonce' ) ) ) {
				return;
			}

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			//Don't update on Quick Edit
			if (defined('DOING_AJAX') ) {
				return $post_id;
			}

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}

			if ( $this->post_type === $p[ 'post_type' ] ) {

				# do stuff
				foreach( $this->meta_boxes as $meta ){
					foreach( $meta[ 'fields' ] as $id => $field){

						$id = self::with_prefix( $id );
						$value = self::sanitize( array(
							'type'  => $field[ 'type' ],
							'value' => $p[ $id ]
						));

						update_post_meta( $post_id, $id, $value );
					}
				}
			}
		}
	}
endif;