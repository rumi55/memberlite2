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
class memberlite_Customize {
	public static function register ( $wp_customize ) {
		$wp_customize->add_section(
			'memberlite_theme_options', 
			array(
				'title' => __( 'MemberLite Options', 'memberlite' ),
				'priority' => 35,
				'capability' => 'edit_theme_options',
				'description' => __('Allows you to customize settings for MemberLite.', 'memberlite'),
			) 
		);
		$wp_customize->add_setting(
			'memberlite_webfonts',
			array(
				'default' => 'Fjalla-One_Noto-Sans',
			)
		);
		$wp_customize->add_control(
			'memberlite_webfonts',
			array(
				'label' => 'Google Webfonts',
				'section' => 'memberlite_theme_options',
				'type'       => 'select',
				'choices'    => array(
					'Fjalla-One_Noto-Sans'  => 'Fjalla One and Noto Sans',
					'Oswald_Lato' => 'Oswald and Lato',
					'Ubuntu_Open-Sans' => 'Ubuntu and Open Sans',
					'Lato_Source-Sans-Pro' => 'Lato and Source Sans Pro',
					'Roboto-Slab_Roboto'  => 'Roboto Slab and Roboto',
					'Lato_Merriweather'  => 'Lato and Merriweather',
					'Playfair-Display_Open-Sans'  => 'Playfair Display and Open Sans',
					'Oswald_Quattrocento'  => 'Oswald and Quattrocento',
					'Abril-Fatface_Open-Sans'  => 'Abril Fatface and Open Sans',
					'Open-Sans_Gentium-Book-Basic' => 'Open Sans and Gentium Book Basic',
					'Oswald_PT-Mono' => 'Oswald and PT Mono'
				),
				'priority' => 10
			)
		);
		$wp_customize->add_setting(
			'meta_login',
			array(
				'default' => '1'
			)
		);
		$wp_customize->add_control(
			'meta_login', 
			array(
				'type' => 'checkbox',
				'label' => 'Show Login/Member Info in Header', 
				'section' => 'memberlite_theme_options',
				'priority' => '15'
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
				'section' => 'memberlite_theme_options',
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
				'section' => 'memberlite_theme_options',
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
				'section' => 'memberlite_theme_options',
				'type'       => 'radio',
					'choices'    => array(
						'content'  => 'Show Post Content',
						'excerpt'   => 'Show Post Excerpts',
					),
				'priority' => 40
			)
		);
		
		$memberlite_breadcrumbs = array();
		
		$memberlite_breadcrumbs[] = array(
			'slug'=>'page_breadcrumbs', 
			'label' => __('Breadcrumbs on Pages', 'ssbootstrapt'),
			'priority' => 51
		);
		$memberlite_breadcrumbs[] = array(
			'slug'=>'post_breadcrumbs', 
			'label' => __('Breadcrumbs on Posts', 'memberlite'),
			'priority' => 52
		);
		$memberlite_breadcrumbs[] = array(
			'slug'=>'archive_breadcrumbs', 
			'label' => __('Breadcrumbs on Archives', 'memberlite'),
			'priority' => 53
		);
		$memberlite_breadcrumbs[] = array(
			'slug'=>'attachment_breadcrumbs', 
			'label' => __('Breadcrumbs on Attachments', 'memberlite'),
			'priority' => 54
		);
		$memberlite_breadcrumbs[] = array(
			'slug'=>'search_breadcrumbs', 
			'label' => __('Breadcrumbs on Search Results', 'memberlite'),
			'priority' => 55
		);
		$memberlite_breadcrumbs[] = array(
			'slug'=>'profile_breadcrumbs', 
			'label' => __('Breadcrumbs on Profiles', 'memberlite'),
			'priority' => 56
		);
		foreach( $memberlite_breadcrumbs as $memberlite_breadcrumb ) {
			// SETTINGS
			$wp_customize->add_setting(
				$memberlite_breadcrumb['slug']
			);
			// CONTROLS
			$wp_customize->add_control(
				$memberlite_breadcrumb['slug'], 
				array(
					'type' => 'checkbox',
					'label' => $memberlite_breadcrumb['label'], 
					'section' => 'memberlite_theme_options',
					'priority' => $memberlite_breadcrumb['priority']
				)
			);
		};
		
		$wp_customize->add_setting(
			'memberlite_footerwidgets',
			array(
				'default' => '4',
			)
		);
		$wp_customize->add_control(
			'memberlite_footerwidgets',
			array(
				'label' => 'Footer Widgets',
				'section' => 'memberlite_theme_options',
				'type'       => 'select',
				'choices'    => array(
					'2' => '2',
					'3' => '3',
					'4'  => '4',
					'6' => '6'
				),
				'priority' => 60
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
				'label' => 'Copyright Text',
				'section' => 'memberlite_theme_options',
				'type' => 'text',
				'priority' => 70
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
			'memberlite_color_primary',
				array(
				'label' => __( 'Primary Color', 'memberlite' ),
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
			'memberlite_color_secondary',
				array(
				'label' => __( 'Secondary Color', 'memberlite' ),
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
			'memberlite_color_action',
				array(
				'label' => __( 'Action Color', 'memberlite' ),
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
			<?php self::generate_css('#mobile-navigation, .masthead, .footer-widgets, .btn_primary', 'background', 'color_primary'); ?> 
			<?php self::generate_css('a, .meta-navigation a, .main-navigation li:hover > a, #secondary .widget a:hover', 'color', 'color_primary'); ?>
			<?php self::generate_css('#meta-member aside, #meta-member .member-navigation ul ul, a.pmpro_btn:hover, input[type="submit"].pmpro_btn:hover, .btn_secondary, .woocommerce #content input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover', 'background', 'color_secondary'); ?> 
			<?php self::generate_css('.woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .woocommerce #content div.product p.price, .woocommerce #content div.product span.price, .woocommerce div.product p.price, .woocommerce div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page div.product span.price', 'color', 'color_secondary'); ?>
			<?php self::generate_css('.pmpro_btn, .pmpro_btn:link, .pmpro_btn:visited, input[type=button].pmpro_btn, input[type=submit].pmpro_btn, .woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt', 'background', 'color_action'); ?> 
			<?php self::generate_css('#site-title a', 'color', 'header_textcolor', '#'); ?> 
			<?php self::generate_css('body', 'background-color', 'background_color', '#'); ?> 
			<?php self::generate_css('a', 'color', 'link_textcolor'); ?>
			<?php 
				$fonts_string = get_theme_mod('memberlite_webfonts');
				$fonts = explode("_", $fonts_string);
				$header_font = str_replace("-", " ", $fonts[0]);
				$body_font = str_replace("-", " ", $fonts[1]);	
			?>
			<?php echo 'body, button, input[type="button"], input[type="reset"], input[type="submit"], .btn, a.comment-reply-link, a.more-link, a.pmpro_btn, input[type="submit"].pmpro_btn, .woocommerce #content input.button, .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce-page #content input.button, .woocommerce-page #respond input#submit, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce #content input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce-page #content input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, form.pmpro_form thead th span.pmpro_thead-msg {font-family: "' . $body_font . '", sans-serif; }'; ?>
			<?php echo 'h1, h2, h3, h4, h5, h6, label, .navigation, th, .pmpro_checkout thead th, #pmpro_account .pmpro_box h3, #meta-member .user {font-family: "' . $header_font . '", sans-serif; }'; ?>
		</style> 
		<!--/Customizer CSS-->
		<?php
	}
	
	public static function live_preview() {
		wp_enqueue_script( 
			'memberlite_customizer',
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
add_action( 'customize_register' , array( 'memberlite_Customize' , 'register' ) );

// Output custom CSS to live site
add_action( 'wp_head' , array( 'memberlite_Customize' , 'header_output' ) );

// Enqueue live preview javascript in Theme Customizer admin screen
add_action( 'customize_preview_init' , array( 'memberlite_Customize' , 'live_preview' ) );