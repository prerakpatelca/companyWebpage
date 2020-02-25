<?php
/**
* Register breadcrumb Options
*
* @return void
* @since 1.0.0
*
* @package Gutenbiz WordPress theme
*/
function gutenbiz_color_options(){	
	Gutenbiz_Customizer::set(array(
		# Theme option
		'panel' => 'panel',
		# Theme Option > color options
		'section' => array(
		    'id'       => 'color-section',
		    'title'    => esc_html__( 'Color Options' ,'gutenbiz' ),
		    'priority' => 5
		),
		'fields'  =>array(
			array(
				'id'      => 'primary-color',
				'label'   => esc_html__( 'Primary Color', 'gutenbiz' ),
				'default' => '#000000',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'body-paragraph-color',
				'label'   => esc_html__( 'Body Text Color', 'gutenbiz' ),
				'default' => '#5f5f5f',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'primary-menu-item-color',
				'label'   => esc_html__( 'Primary Menu Item color', 'gutenbiz' ),
				'default' => '#737373',
				'type'    => 'color-picker',
			),
			array(
				'id'   => 'line-1',
				'type' => 'horizontal-line',
			),
			array(
				'id'      => 'link-color',
				'label'   => esc_html__( 'Link Color', 'gutenbiz' ),
				'default' => '#145fa0',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'link-hover-color',
				'label'   => esc_html__( 'Link Hover Color', 'gutenbiz' ),
				'default' => '#737373',
				'type'    => 'color-picker',
			),
			array(
				'id'   => 'line-2',
				'type' => 'horizontal-line',
			),
			array(
				'id'      => 'sb-widget-title-color',
				'label'   => esc_html__( 'Sidebar Widget Title Color', 'gutenbiz' ),
				'default' => '#000000',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'sb-widget-content-color',
				'label'   => esc_html__( 'Sidebar Widget Content Color', 'gutenbiz' ),
				'default' => '#282835',
				'type'    => 'color-picker',
			),
			array(
				'id'   => 'line-3',
				'type' => 'horizontal-line',
			),
			array(
				'id'      => 'footer-title-color',
				'label'   => esc_html__( 'Footer Widget Title Color', 'gutenbiz' ),
				'default' => '#fff',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'footer-content-color',
				'label'   => esc_html__( 'Footer Widget Content Color', 'gutenbiz' ),
				'default' => '#a8a8a8',
				'type'    => 'color-picker',
			),
			array(
				'id'   => 'line-4',
				'type' => 'horizontal-line',
			),
			array(
				'id'      => 'footer-top-background-color',
				'label'   => esc_html__( 'Footer Background Color', 'gutenbiz' ),
				'default' => '#28292a',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'footer-copyright-background-color',
				'label'   => esc_html__( 'Footer Copyright Background Color', 'gutenbiz' ),
				'default' => '#0c0808',
				'type'    => 'color-picker',
			),
			array(
				'id'      => 'footer-copyright-text-color',
				'label'   => esc_html__( 'Footer Copyright Text Color', 'gutenbiz' ),
				'default' => '#ffffff',
				'type'    => 'color-picker',
			),
		),			
	));
}
add_action( 'init', 'gutenbiz_color_options' );