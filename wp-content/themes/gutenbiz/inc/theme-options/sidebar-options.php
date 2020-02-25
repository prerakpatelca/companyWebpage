<?php
/**
 * Create options for sidebar.
 *
 * @since 1.0.0
 *
 * @package Gutenbiz WordPress theme
 */

/**
* Register sidebar Options
*
* @return void
* @since 1.0.0
*
* @package Gutenbiz WordPress theme
*/
function gutenbiz_sidebar_options(){
	Gutenbiz_Customizer::set(array(
		# Theme Options
		'panel'   => 'panel',
		# Theme Options >Sidebar Layout > Settings
		'section' => array(
			'id'     => 'sidebar-options',
			'title'  => esc_html__( 'Sidebar Options','gutenbiz' ),
		),
		'fields' => array(
			# sb - Sidebar
			array(
			    'id'      => 'sidebar-position',
			    'label'   => esc_html__( 'Sidebar Position' , 'gutenbiz' ),
			    'type'    => 'buttonset',
			    'default' => 'right-sidebar',
			    'choices' => array(
			        'left-sidebar'  => esc_html__( 'Left' , 'gutenbiz' ),
			        'right-sidebar' => esc_html__( 'Right' , 'gutenbiz' ),
			        'no-sidebar'    => esc_html__( 'None', 'gutenbiz' ),
			     )
			),
		),
	) );
}
add_action( 'init', 'gutenbiz_sidebar_options' );