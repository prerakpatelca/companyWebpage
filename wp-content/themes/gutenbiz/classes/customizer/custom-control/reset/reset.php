<?php
/**
* Customizer Reset
*
* @since 1.0.0
*
* @package Gutenbiz WordPress
*/

if ( class_exists( 'WP_Customize_Control' ) ) :

    class Gutenbiz_Customizer_Reset extends WP_Customize_Control {
        
        /**
         * The values for reseting
         *
         * @since  1.0.0
         * @access public
         * @var    array
         *
         * @package Gutenbiz WordPress Theme
         */
        public $reset_settings = array();

        /**
         *
         * @since  1.0.0
         * @access public
         * @var    bool
         *
         * @package Gutenbiz WordPress Theme
         */
        public $wp_customize = null;

        /**
         * The control type.
         *
         * @since  1.0.0
         * @access public
         * @var    string
         *
         * @package Gutenbiz WordPress Theme
         */
        public $type = 'reset';

        /**
         * The constructor
         *
         * @since  1.0.0
         * @access public
         *
         * @package Gutenbiz WordPress Theme
         */
        public function __construct( $customize, $control_id, $args ) {
            
            $this->reset_settings = $args[ 'settings' ];
            unset( $args[ 'settings'] );
            parent::__construct( $customize, $control_id, $args );

            add_action( 'customize_controls_print_scripts', array( $this, 'scripts' ) );
            add_action( 'wp_ajax_customizer_reset', array( $this, 'ajax_customizer_reset' ) );
           
            $this->wp_customize = $customize;
        }

        /**
         * Enqueue control related scripts/styles.
         *
         * @since  1.0.0
         * @access public
         *
         * @package Gutenbiz WordPress Theme
         */
        public function scripts(){

            wp_localize_script( Gutenbiz_Helper::with_prefix( 'customize-js' ), 'CUSTOMIZERRESET', array(
                'nonce'   => array(
                    'reset' => wp_create_nonce( 'customizer-reset' ),
                ),
                'confirm' => esc_html__( 'This action is not reversible! Are you sure to reset these settings?', 'gutenbiz' )
            ));
        }

        /**
         * Adds style and button
         *
         * @since  1.0.0
         * @access public
         * @return void
         *
         * @package Gutenbiz WordPress Theme
         */
        public function render_content() {
            ?>
            <style>
                .customizer-reset{
                    border-radius: 3px;
                    background: #eeeeee;
                    display: inline-block;
                    padding: 10px 25px;
                    border: 1px solid #cecbcb;
                    cursor: pointer;
                    outline: none;
                }
                .customizer-reset:hover{
                    background: #e8e8e8;
                }
            </style>
                <p><i><?php echo esc_html( $this->description ); ?> </i></p>
            <button class="customizer-reset" >
                <?php echo esc_html( $this->label ); ?>
            </button>
            <?php
        }

        /**
         * Ajax control
         *
         * @since  1.0.0
         * @access public
         *
         * @package Gutenbiz WordPress Theme
         */
        public function ajax_customizer_reset() {
            
            if ( ! $this->wp_customize->is_preview() ) {
                wp_send_json_error( 'not_preview' );
            }

            if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
                wp_send_json_error( 'invalid_nonce' );
            }

            $this->reset_settings[] = 'header_textcolor';
            $this->reset_settings[] = 'background_color';
           
            # remove theme_mod settings registered in customizer
            foreach ( $this->reset_settings as $setting ) {
                remove_theme_mod( $setting );
            }

            wp_send_json_success();
        }
    }
    
endif;

Gutenbiz_Customizer::add_custom_control( array(
    'type'     => 'reset',
    'class'    => 'Gutenbiz_Customizer_Reset',
    'sanitize' => false,
    'register_control_type' => false
));