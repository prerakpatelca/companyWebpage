<?php
/**
 * Blossom Coach General Settings
 *
 * @package Blossom_Coach
 */

function blossom_coach_customize_register_general( $wp_customize ) {
	
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 85,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'blossom-coach' ),
            'description' => __( 'Customize Header, Social, SEO, Post/Page & Newsletter settings.', 'blossom-coach' ),
        ) 
    );
    
    
    /** Header Settings */
    $wp_customize->add_section(
        'header_settings',
        array(
            'title'    => __( 'Header Settings', 'blossom-coach' ),
            'priority' => 20,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Header Search */
    $wp_customize->add_setting( 
        'ed_header_search', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_header_search',
			array(
				'section'     => 'header_settings',
				'label'	      => __( 'Enable Header Search', 'blossom-coach' ),
                'description' => __( 'Enable to show Search button in header.', 'blossom-coach' ),
			)
		)
	);
    
    /** Enable Shopping Cart */
    $wp_customize->add_setting( 
        'ed_shopping_cart', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_shopping_cart',
			array(
				'section'         => 'header_settings',
				'label'	          => __( 'Shopping Cart', 'blossom-coach' ),
                'description'     => __( 'Enable to show Shopping cart in the header.', 'blossom-coach' ),
                'active_callback' => 'blossom_coach_is_woocommerce_activated'
			)
		)
	);
    
    /** Phone */
    $wp_customize->add_setting(
        'phone',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field', 
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'phone',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Phone', 'blossom-coach' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'phone', array(
        'selector'        => '.site-header .wrapper .top-left .phone',
        'render_callback' => 'blossom_coach_get_phone',
    ) );
    
    /** Email */
    $wp_customize->add_setting(
        'email',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_email',            
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'email',
        array(
            'type'    => 'text',
            'section' => 'header_settings',
            'label'   => __( 'Email', 'blossom-coach' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'email', array(
        'selector'        => '.site-header .wrapper .top-left .email',
        'render_callback' => 'blossom_coach_get_email',
    ) );
    
    if( blossom_coach_is_btnw_activated() ){
        /** Header Newsletter */
        $wp_customize->add_setting(
            'header_newsletter',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            'header_newsletter',
            array(
                'type'        => 'text',
                'section'     => 'header_settings',
                'label'       => __( 'Header Newsletter Shortcode', 'blossom-coach' ),
                'description' => __( 'Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'blossom-coach' ),
            )
        );
    }else{
        $wp_customize->add_setting(
    		'header_nl_note',
    		array(
    			'sanitize_callback' => 'wp_kses_post'
    		)
    	);
    
    	$wp_customize->add_control(
    		new Blossom_Coach_Note_Control( 
    			$wp_customize,
    			'header_nl_note',
    			array(
    				'section'     => 'header_settings', 
                    'label'       => __( 'Header Newsletter Shortcode', 'blossom-coach' ),   				
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Email Newsletter%2$s.', 'blossom-coach' ), '<a href="' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">', '</a>' ),
    			)
    		)
       );  
    }
    /** Header Settings Ends */
    
    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'blossom-coach' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_social_links',
			array(
				'section'     => 'social_media_settings',
				'label'	      => __( 'Enable Social Links', 'blossom-coach' ),
                'description' => __( 'Enable to show social links at header.', 'blossom-coach' ),
			)
		)
	);
    
    $wp_customize->add_setting( 
        new Blossom_Coach_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Blossom_Coach_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Control_Repeater(
			$wp_customize,
			'social_links',
			array(
				'section' => 'social_media_settings',				
				'label'	  => __( 'Social Links', 'blossom-coach' ),
				'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __( 'Font Awesome Icon', 'blossom-coach' ),
                        'description' => __( 'Example: fa-bell', 'blossom-coach' ),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __( 'Link', 'blossom-coach' ),
                        'description' => __( 'Example: http://facebook.com', 'blossom-coach' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'blossom-coach' ),
                    'field' => 'link'
                ),
                'choices'   => array(
                    'limit' => 10
                )                        
			)
		)
	);
    /** Social Media Settings Ends */
    
    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'blossom-coach' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Last Update Post Date */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_post_update_date',
			array(
				'section'     => 'seo_settings',
				'label'	      => __( 'Enable Last Update Post Date', 'blossom-coach' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'blossom-coach' ),
			)
		)
	);  

    /** Enable Breadcrumbs */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Coach_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Breadcrumb', 'blossom-coach' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'blossom-coach' ),
            )
        )
    );

    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'blossom-coach' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'blossom-coach' ),
            'active_callback' => 'blossom_coach_breadcrumbs'
        )
    ); 

    /** SEO Settings Ends */
    
    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __( 'Posts(Blog) & Pages Settings', 'blossom-coach' ),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );

    /** Prefix Archive Page */
    $wp_customize->add_setting( 
        'ed_prefix_archive', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Coach_Toggle_Control( 
            $wp_customize,
            'ed_prefix_archive',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Prefix in Archive Page', 'blossom-coach' ),
                'description' => __( 'Enable to hide prefix in archive page.', 'blossom-coach' ),
            )
        )
    );
    
    /** Blog Excerpt */
    $wp_customize->add_setting( 
        'ed_excerpt', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_excerpt',
			array(
				'section'     => 'post_page_settings',
				'label'	      => __( 'Enable Blog Excerpt', 'blossom-coach' ),
                'description' => __( 'Enable to show excerpt or disable to show full post content.', 'blossom-coach' ),
			)
		)
	);
    
    /** Excerpt Length */
    $wp_customize->add_setting( 
        'excerpt_length', 
        array(
            'default'           => 55,
            'sanitize_callback' => 'blossom_coach_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Slider_Control( 
			$wp_customize,
			'excerpt_length',
			array(
				'section'	  => 'post_page_settings',
				'label'		  => __( 'Excerpt Length', 'blossom-coach' ),
				'description' => __( 'Automatically generated excerpt length (in words).', 'blossom-coach' ),
                'choices'	  => array(
					'min' 	=> 10,
					'max' 	=> 100,
					'step'	=> 5,
				)                 
			)
		)
	);
    
    /** Read More Text */
    $wp_customize->add_setting(
        'read_more_text',
        array(
            'default'           => __( 'Continue Reading', 'blossom-coach' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'read_more_text',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Read More Text', 'blossom-coach' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'read_more_text', array(
        'selector' => '.entry-footer .btn-link',
        'render_callback' => 'blossom_coach_get_read_more',
    ) );
    
    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Blossom_Coach_Note_Control( 
			$wp_customize,
			'post_note_text',
			array(
				'section'	  => 'post_page_settings',
				'description' => __( '<hr/>These options affect your individual posts.', 'blossom-coach' ),
			)
		)
    );
    
    /** Show Related Posts */
    $wp_customize->add_setting( 
        'ed_related', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_related',
			array(
				'section'     => 'post_page_settings',
				'label'	      => __( 'Show Related Posts', 'blossom-coach' ),
                'description' => __( 'Enable to show related posts in single page.', 'blossom-coach' ),
			)
		)
	);
    
    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __( 'You may also like...', 'blossom-coach' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Related Posts Section Title', 'blossom-coach' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'related_post_title', array(
        'selector' => '.related-articles .related-title',
        'render_callback' => 'blossom_coach_get_related_title',
    ) );
    
    /** Hide Category */
    $wp_customize->add_setting( 
        'ed_category', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_category',
			array(
				'section'     => 'post_page_settings',
				'label'	      => __( 'Hide Category', 'blossom-coach' ),
                'description' => __( 'Enable to hide category.', 'blossom-coach' ),
			)
		)
	);

    /** Hide Post Author */
    $wp_customize->add_setting( 
        'ed_post_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Blossom_Coach_Toggle_Control( 
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Post Author', 'blossom-coach' ),
                'description' => __( 'Enable to hide post author.', 'blossom-coach' ),
            )
        )
    );
    
    /** Hide Posted Date */
    $wp_customize->add_setting( 
        'ed_post_date', 
        array(
            'default'           => false,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_post_date',
			array(
				'section'     => 'post_page_settings',
				'label'	      => __( 'Hide Posted Date', 'blossom-coach' ),
                'description' => __( 'Enable to hide posted date.', 'blossom-coach' ),
			)
		)
	);
    
    /** Show Featured Image */
    $wp_customize->add_setting( 
        'ed_featured_image', 
        array(
            'default'           => true,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
		new Blossom_Coach_Toggle_Control( 
			$wp_customize,
			'ed_featured_image',
			array(
				'section'     => 'post_page_settings',
				'label'	      => __( 'Show Featured Image', 'blossom-coach' ),
                'description' => __( 'Enable to show featured image in post detail (single page).', 'blossom-coach' ),
			)
		)
	);
    /** Posts(Blog) & Pages Settings Ends */
    
    /** Newsletter Settings */
    $wp_customize->add_section(
        'newsletter_settings',
        array(
            'title'    => __( 'Newsletter Settings', 'blossom-coach' ),
            'priority' => 60,
            'panel'    => 'general_settings',
        )
    );    
    
    if( blossom_coach_is_btnw_activated() ){
        /** Enable Newsletter Section */
        $wp_customize->add_setting( 
            'ed_newsletter', 
            array(
                'default'           => false,
                'sanitize_callback' => 'blossom_coach_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
    		new Blossom_Coach_Toggle_Control( 
    			$wp_customize,
    			'ed_newsletter',
    			array(
    				'section'     => 'newsletter_settings',
    				'label'	      => __( 'Newsletter Section', 'blossom-coach' ),
                    'description' => __( 'Enable to show Newsletter Section', 'blossom-coach' ),
    			)
    		)
    	);
        
        /** Newsletter Shortcode */
        $wp_customize->add_setting(
            'newsletter_shortcode',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );
        
        $wp_customize->add_control(
            'newsletter_shortcode',
            array(
                'type'        => 'text',
                'section'     => 'newsletter_settings',
                'label'       => __( 'Newsletter Shortcode', 'blossom-coach' ),
                'description' => __( 'Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'blossom-coach' ),
            )
        );
    }else{
        $wp_customize->add_setting(
    		'newsletter_note',
    		array(
    			'sanitize_callback' => 'wp_kses_post'
    		)
    	);
    
    	$wp_customize->add_control(
    		new Blossom_Coach_Note_Control( 
    			$wp_customize,
    			'newsletter_note',
    			array(
    				'section'     => 'newsletter_settings', 
                    'label'       => __( 'Newsletter Shortcode', 'blossom-coach' ),   				
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Email Newsletter%2$s. After that option related with this section will be visible.', 'blossom-coach' ), '<a href="' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) . '" target="_blank">', '</a>' ),
    			)
    		)
       ); 
    }
}
add_action( 'customize_register', 'blossom_coach_customize_register_general' );