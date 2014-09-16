<?php
/**
 * Member Lite 2.0 Theme Customizer
 *
 * @package Member Lite 2.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
class MemberLite2_Customize {
	public static function register ( $wp_customize ) {
		$wp_customize->add_section(
			'memberlite2_theme_options', 
			array(
				'title' => __( 'Member Lite 2.0 Options', 'memberlite2' ),
				'priority' => 35,
				'capability' => 'edit_theme_options',
				'description' => __('Allows you to customize settings for MemberLite 2.0.', 'memberlite2'),
			) 
		);
		$wp_customize->add_setting(
			'sidebar_location',
			array(
				'default' => 'sidebar-right',
			)
		);
		$wp_customize->add_control(
			'sidebar_location',
			array(
				'label' => 'Default Layout',
				'section' => 'memberlite2_theme_options',
				'type'       => 'radio',
					'choices'    => array(
						'sidebar-right'  => 'Right Sidebar',
						'sidebar-left'   => 'Left Sidebar',
					),
				'priority' => 20
			)
		);
		$wp_customize->add_setting(
			'sidebar_location_blog',
			array(
				'default' => 'sidebar-blog-right',
			)
		);
		$wp_customize->add_control(
			'sidebar_location_blog',
			array(
				'label' => 'Layout for Blog, Archive, Posts',
				'section' => 'memberlite2_theme_options',
				'type'       => 'radio',
					'choices'    => array(
						'sidebar-blog-right'  => 'Right Sidebar',
						'sidebar-blog-left'   => 'Left Sidebar',
					),
				'priority' => 30
			)
		);
		$wp_customize->add_setting(
			'content_archives',
			array(
				'default' => 'content',
			)
		);
		$wp_customize->add_control(
			'content_archives',
			array(
				'label' => 'Content Archives',
				'section' => 'memberlite2_theme_options',
				'type'       => 'radio',
					'choices'    => array(
						'content'  => 'Show Post Content',
						'excerpt'   => 'Show Post Excerpts',
					),
				'priority' => 40
			)
		);
		$wp_customize->add_setting(
			'copyright_textbox',
			array(
				'default' => '<a href="http://wordpress.org/">Proudly powered by WordPress</a><span class="sep"> | </span>Theme: Member Lite 2.0 by <a href="http://paidmembershipspro.com" rel="designer">Kim Coleman</a>',
			)
		);
		$wp_customize->add_control(
			'copyright_textbox',
			array(
				'label' => 'Copyright text',
				'section' => 'memberlite2_theme_options',
				'type' => 'text',
				'priority' => 50
			)
		);
		$wp_customize->add_setting(
			'color_primary',
			array(
				'default' => '#2C3E50',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport' => 'postMessage',
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'memberlite2_color_primary',
				array(
				'label' => __( 'Primary Color', 'memberlite2' ),
				'section' => 'colors',
				'settings' => 'color_primary',
				'priority' => 10,
				) 
		));
		$wp_customize->add_setting(
			'color_secondary',
			array(
				'default' => '#18BC9C',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport' => 'postMessage',
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'memberlite2_color_secondary',
				array(
				'label' => __( 'Secondary Color', 'memberlite2' ),
				'section' => 'colors',
				'settings' => 'color_secondary',
				'priority' => 20,
				) 
		));
		$wp_customize->add_setting(
			'color_action',
			array(
				'default' => '#F39C12',
				'type' => 'theme_mod',
				'capability' => 'edit_theme_options',
				'transport' => 'postMessage',
			) 
		);
		$wp_customize->add_control( new WP_Customize_Color_Control(
			$wp_customize,
			'memberlite2_color_action',
				array(
				'label' => __( 'Action Color', 'memberlite2' ),
				'section' => 'colors',
				'settings' => 'color_action',
				'priority' => 30,
				) 
		));		
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';	
		$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	}

	public static function header_output() {
	  ?>
	  <!--Customizer CSS--> 
	  <style type="text/css">
		   <?php self::generate_css('#mobile-navigation, .masthead, .footer-widgets', 'background', 'color_primary'); ?> 
		   <?php self::generate_css('a, .meta-navigation a, .main-navigation li:hover > a, #secondary .widget a:hover', 'color', 'color_primary'); ?>
		   <?php self::generate_css('#meta-member aside, a.pmpro_btn:hover, input[type="submit"].pmpro_btn:hover, .woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover', 'background', 'color_secondary'); ?> 
		   <?php self::generate_css('.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price', 'color', 'color_secondary'); ?>
		   <?php self::generate_css('.pmpro_btn, .pmpro_btn:link, .pmpro_btn:visited, input[type=button].pmpro_btn, input[type=submit].pmpro_btn, .woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt', 'background', 'color_action'); ?> 
		   <?php self::generate_css('#site-title a', 'color', 'header_textcolor', '#'); ?> 
		   <?php self::generate_css('body', 'background-color', 'background_color', '#'); ?> 
		   <?php self::generate_css('a', 'color', 'link_textcolor'); ?>
	  </style> 
	  <!--/Customizer CSS-->
	  <?php
	}
	
	public static function live_preview() {
		wp_enqueue_script( 
			'memberlite2_customizer',
			get_template_directory_uri() . '/js/customizer.js',
			array(  'jquery', 'customize-preview' ),
			'20140901',
			true
		);
	}

	public static function generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      	  
	  if ( ! empty( $mod ) ) {
         $return = sprintf('%s { %s:%s; }',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
    }
}

// Setup the Theme Customizer settings and controls...
add_action( 'customize_register' , array( 'MemberLite2_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'MemberLite2_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'MemberLite2_Customize' , 'live_preview' ) );